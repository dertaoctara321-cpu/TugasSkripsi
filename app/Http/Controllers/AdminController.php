<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $today = Order::whereDate('created_at', today())->where('payment_status', 'paid')->sum('total_amount');
        $week = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->where('payment_status', 'paid')->sum('total_amount');
        $month = Order::whereMonth('created_at', now()->month)->where('payment_status', 'paid')->sum('total_amount');
        $year = Order::whereYear('created_at', now()->year)->where('payment_status', 'paid')->sum('total_amount');

        // Order statistics
        $totalOrders = Order::count();
        $completedOrders = Order::where('order_status', 'completed')->count();
        $pendingOrders = Order::where('order_status', 'pending')->count();

        // Recent orders (last 10)
        $recentOrders = Order::with(['table', 'rating'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Rating & Review Statistics
        $totalRatings = Rating::count();
        $avgFoodRating = $totalRatings > 0 ? round(Rating::avg('food_rating') ?? 0.0, 1) : 0.0;
        $avgTableRating = $totalRatings > 0 ? round(Rating::avg('table_rating') ?? 0.0, 1) : 0.0;
        $avgWaiterRating = $totalRatings > 0 ? round(Rating::avg('waiter_rating') ?? 0.0, 1) : 0.0;

        // Top 3 Favorite Tables
        $topTables = Table::with('ratings')->get()->map(function ($t) {
            $avg = $t->ratings->count() > 0 ? ($t->ratings->avg('table_rating') ?? 0.0) : 0.0;
            $favs = $t->ratings->where('is_favorite_table', true)->count();
            $count = $t->ratings->count();
            $score = ($avg * 2) + ($favs * 3) + $count;
            return [
                'table' => $t,
                'table_number' => $t->table_number,
                'avg_rating' => round($avg, 1),
                'fav_count' => $favs,
                'rating_count' => $count,
                'score' => $score,
            ];
        })->sortByDesc('score')->take(3)->values();

        // Waiters Performance Leaderboard
        $waiterLeaderboard = Rating::whereNotNull('waiter_name')
            ->where('waiter_name', '!=', '')
            ->get()
            ->groupBy('waiter_name')
            ->map(function ($group, $name) {
                return [
                    'name' => $name,
                    'avg_rating' => round($group->avg('waiter_rating'), 1),
                    'total_served' => $group->count(),
                    'latest_comment' => $group->whereNotNull('waiter_review')->last()?->waiter_review,
                ];
            })
            ->sortByDesc('avg_rating')
            ->values();

        // Recent Customer Reviews
        $recentReviews = Rating::with(['order', 'table'])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('admin.dashboard', compact(
            'today', 'week', 'month', 'year',
            'totalOrders', 'completedOrders', 'pendingOrders', 'recentOrders',
            'totalRatings', 'avgFoodRating', 'avgTableRating', 'avgWaiterRating',
            'topTables', 'waiterLeaderboard', 'recentReviews'
        ));
    }

    public function reports()
    {
        $today = Order::whereDate('created_at', today())->where('payment_status', 'paid')->sum('total_amount');
        $week = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->where('payment_status', 'paid')->sum('total_amount');
        $month = Order::whereMonth('created_at', now()->month)->where('payment_status', 'paid')->sum('total_amount');
        $year = Order::whereYear('created_at', now()->year)->where('payment_status', 'paid')->sum('total_amount');
        $paidOrders = Order::with(['table', 'rating'])->where('payment_status', 'paid')->orderBy('created_at', 'desc')->get();

        // 1. All customer reviews for evaluation reports
        $allReviews = Rating::with(['order', 'table'])->orderBy('created_at', 'desc')->get();
        $totalRev = $allReviews->count();
        $avgFoodRating = $totalRev > 0 ? round(Rating::avg('food_rating') ?? 0.0, 1) : 0.0;
        $avgTableRating = $totalRev > 0 ? round(Rating::avg('table_rating') ?? 0.0, 1) : 0.0;
        $avgWaiterRating = $totalRev > 0 ? round(Rating::avg('waiter_rating') ?? 0.0, 1) : 0.0;

        // 2. Stock Report (Sisa Stok, Jumlah Terjual, Status Ketersediaan)
        $stockReports = Menu::leftJoin('order_items', 'menus.id', '=', 'order_items.menu_id')
            ->select(
                'menus.id',
                'menus.name',
                'menus.category',
                'menus.sub_category',
                'menus.price',
                'menus.stock',
                'menus.is_available',
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold')
            )
            ->groupBy('menus.id', 'menus.name', 'menus.category', 'menus.sub_category', 'menus.price', 'menus.stock', 'menus.is_available')
            ->orderBy('menus.category')
            ->orderBy('menus.name')
            ->get()
            ->map(function ($menu) {
                if (!$menu->is_available || $menu->stock <= 0) {
                    $menu->stock_status = 'Habis';
                    $menu->badge_class = 'danger';
                } elseif ($menu->stock <= 5) {
                    $menu->stock_status = 'Menipis';
                    $menu->badge_class = 'warning';
                } else {
                    $menu->stock_status = 'Aman';
                    $menu->badge_class = 'success';
                }
                return $menu;
            });

        $stockStats = [
            'total_menus' => $stockReports->count(),
            'safe_stock'  => $stockReports->where('stock_status', 'Aman')->count(),
            'low_stock'   => $stockReports->where('stock_status', 'Menipis')->count(),
            'out_stock'   => $stockReports->where('stock_status', 'Habis')->count(),
            'total_sold'  => $stockReports->sum('total_sold'),
        ];

        return view('admin.reports', compact(
            'today', 'week', 'month', 'year', 'paidOrders',
            'allReviews', 'avgFoodRating', 'avgTableRating', 'avgWaiterRating',
            'stockReports', 'stockStats'
        ));
    }
}
