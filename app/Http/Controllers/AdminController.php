<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Rating;
use App\Models\Table;
use Illuminate\Http\Request;

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
        $avgFoodRating = round(Rating::avg('food_rating') ?? 5.0, 1);
        $avgTableRating = round(Rating::avg('table_rating') ?? 5.0, 1);
        $avgWaiterRating = round(Rating::avg('waiter_rating') ?? 5.0, 1);

        // Top 3 Favorite Tables
        $topTables = Table::with('ratings')->get()->map(function ($t) {
            $avg = $t->ratings->avg('table_rating') ?? 5.0;
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

        // All customer reviews for reports
        $allReviews = Rating::with(['order', 'table'])->orderBy('created_at', 'desc')->get();
        $avgFoodRating = round(Rating::avg('food_rating') ?? 5.0, 1);
        $avgTableRating = round(Rating::avg('table_rating') ?? 5.0, 1);
        $avgWaiterRating = round(Rating::avg('waiter_rating') ?? 5.0, 1);

        return view('admin.reports', compact(
            'today', 'week', 'month', 'year', 'paidOrders',
            'allReviews', 'avgFoodRating', 'avgTableRating', 'avgWaiterRating'
        ));
    }
}
