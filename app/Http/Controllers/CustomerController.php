<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Rating;
use App\Models\Table;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index($uuid)
    {
        $table = Table::where('uuid', $uuid)->firstOrFail();
        // Fetch all menus, available ones first, then alphabetical
        $menus = Menu::orderBy('is_available', 'desc')
            ->orderBy('category')
            ->orderBy('name')
            ->get();
        
        // Check if cart exists in session for this table UUID
        $cartKey = "cart_{$uuid}";
        $cart = session()->get($cartKey, []);
        
        // Get active order for this table (only if table is occupied)
        $activeOrder = null;
        if ($table->status == 'occupied') {
            $activeOrder = Order::where('table_id', $table->id)
                ->with(['items.menu'])
                ->latest()
                ->first();
        }

        // Compute table ranking for favorite badge
        $allTables = Table::with('ratings')->get()->map(function ($t) {
            $avg = $t->ratings->avg('table_rating') ?? 5.0;
            $favs = $t->ratings->where('is_favorite_table', true)->count();
            $count = $t->ratings->count();
            $score = ($avg * 2) + ($favs * 3) + $count;
            return [
                'id' => $t->id,
                'avg_rating' => round($avg, 1),
                'fav_count' => $favs,
                'rating_count' => $count,
                'score' => $score,
            ];
        })->sortByDesc('score')->values();

        $tableRank = 1;
        $tableStats = [
            'avg_rating' => 5.0,
            'fav_count' => 0,
            'rating_count' => 0,
            'is_top' => false,
            'rank' => 1,
        ];

        foreach ($allTables as $index => $item) {
            if ($item['id'] === $table->id) {
                $tableRank = $index + 1;
                $tableStats = [
                    'avg_rating' => $item['avg_rating'],
                    'fav_count' => $item['fav_count'],
                    'rating_count' => $item['rating_count'],
                    'is_top' => ($index === 0 && $item['rating_count'] > 0),
                    'rank' => $tableRank,
                ];
                break;
            }
        }
        
        return view('customer.menu', compact('table', 'menus', 'cart', 'activeOrder', 'tableStats'));
    }

    public function addToCart(Request $request, $uuid)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        if (!$menu->is_available) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, menu "' . $menu->name . '" saat ini sedang tidak tersedia / stok habis.'
                ], 422);
            }
            return redirect()->back()->with('error', 'Maaf, menu "' . $menu->name . '" sedang tidak tersedia.');
        }

        $cartKey = "cart_{$uuid}";
        $cart = session()->get($cartKey, []);
        
        $currentQty = isset($cart[$request->menu_id]) ? $cart[$request->menu_id]['quantity'] : 0;
        if ($currentQty + $request->quantity > 100) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah maksimal untuk item ini adalah 100.'
                ], 422);
            }
            return redirect()->back()->with('error', 'Jumlah maksimal untuk item ini adalah 100.');
        }

        if (isset($cart[$request->menu_id])) {
            $cart[$request->menu_id]['quantity'] += $request->quantity;
        } else {
            $cart[$request->menu_id] = [
                "name" => $menu->name,
                "quantity" => $request->quantity,
                "price" => $menu->price,
                "image" => $menu->image
            ];
        }
        
        session()->put($cartKey, $cart);

        if ($request->ajax() || $request->wantsJson()) {
            $totalItems = collect($cart)->sum('quantity');
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'cart_count' => $totalItems
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function updateCartItem(Request $request, $uuid)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:0|max:100',
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        $cartKey = "cart_{$uuid}";
        $cart = session()->get($cartKey, []);

        if ($request->quantity > 0) {
            if (!$menu->is_available) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, menu "' . $menu->name . '" sedang tidak tersedia.'
                ], 422);
            }

            $cart[$request->menu_id] = [
                "name" => $menu->name,
                "quantity" => $request->quantity,
                "price" => $menu->price,
                "image" => $menu->image
            ];
        } else {
            if (isset($cart[$request->menu_id])) {
                unset($cart[$request->menu_id]);
            }
        }

        session()->put($cartKey, $cart);

        $totalItems = collect($cart)->sum('quantity');
        $totalPrice = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return response()->json([
            'success' => true,
            'cart_count' => $totalItems,
            'cart_total' => $totalPrice
        ]);
    }

    public function clearCart(Request $request, $uuid)
    {
        $cartKey = "cart_{$uuid}";
        session()->forget($cartKey);
        return response()->json([
            'success' => true,
            'cart_count' => 0,
            'cart_total' => 0
        ]);
    }

    public function checkout($uuid)
    {
        $table = Table::where('uuid', $uuid)->firstOrFail();
        $cartKey = "cart_{$uuid}";
        $cart = session()->get($cartKey, []);
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        
        return view('customer.checkout', compact('table', 'cart', 'paymentMethods'));
    }

    public function placeOrder(Request $request, $uuid)
    {
        $table = Table::where('uuid', $uuid)->firstOrFail();
        $cartKey = "cart_{$uuid}";
        $cart = session()->get($cartKey, []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong');
        }

        $existingOrder = null;
        if ($table->status == 'occupied') {
            $existingOrder = Order::where('table_id', $table->id)
                ->latest()
                ->first();
        }

        $request->validate([
            'customer_name' => $existingOrder ? 'nullable|string|max:255' : 'required|string|max:255',
            'payment_method_id' => $existingOrder ? 'nullable|exists:payment_methods,id' : 'required|exists:payment_methods,id',
            'floor' => 'required|string|in:Lantai 1,Lantai 2'
        ]);

        $paymentMethodName = 'Cash';
        if ($request->filled('payment_method_id')) {
            $paymentMethod = PaymentMethod::where('id', $request->payment_method_id)
                ->where('is_active', true)
                ->firstOrFail();
            $paymentMethodName = $paymentMethod->name;
        } elseif ($existingOrder) {
            $paymentMethodName = $existingOrder->payment_method;
        }

        // Calculate new items total
        $newItemsTotal = 0;
        foreach ($cart as $id => $details) {
            $newItemsTotal += $details['price'] * $details['quantity'];
        }

        if ($existingOrder) {
            // Add new items to existing order
            foreach ($cart as $id => $details) {
                $existingItem = OrderItem::where('order_id', $existingOrder->id)
                    ->where('menu_id', $id)
                    ->first();
                
                if ($existingItem) {
                    $existingItem->quantity += $details['quantity'];
                    $existingItem->save();
                } else {
                    OrderItem::create([
                        'order_id' => $existingOrder->id,
                        'menu_id' => $id,
                        'quantity' => $details['quantity'],
                        'price' => $details['price']
                    ]);
                }
            }

            $existingOrder->total_amount += $newItemsTotal;
            if ($request->has('floor')) {
                $existingOrder->floor = $request->floor;
            }
            
            if ($existingOrder->payment_status == 'paid') {
                $existingOrder->payment_status = 'pending';
            }
            
            $existingOrder->save();
            session()->forget($cartKey);

            return redirect()->route('order.status', ['uuid' => $uuid, 'order' => $existingOrder->id])
                ->with('success', 'Item berhasil ditambahkan ke pesanan yang sudah ada!');
        } else {
            // Create new order
            $order = Order::create([
                'table_id' => $table->id,
                'total_amount' => $newItemsTotal,
                'payment_method' => $paymentMethodName,
                'customer_name' => $request->customer_name,
                'floor' => $request->floor,
                'order_status' => 'pending',
                'payment_status' => 'pending'
            ]);

            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price']
                ]);
            }

            $table->status = 'occupied';
            $table->save();

            session()->forget($cartKey);

            return redirect()->route('order.status', ['uuid' => $uuid, 'order' => $order->id]);
        }
    }

    public function status($uuid, Order $order)
    {
        if ($order->table->uuid !== $uuid) {
            abort(403, 'Unauthorized access to this order.');
        }

        $order->load(['items.menu', 'table', 'rating']);
        return view('customer.status', compact('order'));
    }

    /**
     * AJAX Polling endpoint to check live order status & waiter name
     */
    public function checkStatus($uuid, Order $order)
    {
        if ($order->table->uuid !== $uuid) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'order_id' => $order->id,
            'order_status' => $order->order_status,
            'payment_status' => $order->payment_status,
            'waiter_name' => $order->waiter_name,
            'updated_at' => $order->updated_at ? $order->updated_at->toISOString() : now()->toISOString(),
        ]);
    }

    /**
     * Submit rating for order, table, and waiter
     */
    public function rateOrder(Request $request, $uuid, Order $order)
    {
        if ($order->table->uuid !== $uuid) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'food_rating' => 'required|integer|min:1|max:5',
            'table_rating' => 'required|integer|min:1|max:5',
            'waiter_rating' => 'nullable|integer|min:1|max:5',
            'is_favorite_table' => 'nullable',
            'review' => 'nullable|string|max:1000',
            'waiter_review' => 'nullable|string|max:1000',
        ]);

        $isFavorite = $request->has('is_favorite_table') && ($request->is_favorite_table == '1' || $request->is_favorite_table == 'on' || $request->is_favorite_table === true);

        Rating::updateOrCreate(
            ['order_id' => $order->id],
            [
                'table_id' => $order->table_id,
                'customer_name' => $order->customer_name ?? 'Pelanggan',
                'waiter_name' => $order->waiter_name,
                'food_rating' => (int) $request->food_rating,
                'table_rating' => (int) $request->table_rating,
                'waiter_rating' => $request->filled('waiter_rating') ? (int) $request->waiter_rating : 5,
                'is_favorite_table' => $isFavorite,
                'review' => $request->review,
                'waiter_review' => $request->waiter_review,
            ]
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih atas ulasan dan rating yang Anda berikan!'
            ]);
        }

        return redirect()->back()->with('success', 'Terima kasih atas ulasan dan rating yang Anda berikan!');
    }

    public function paymentInfo($uuid)
    {
        $table = Table::where('uuid', $uuid)->firstOrFail();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        
        return view('customer.payment_info', compact('table', 'paymentMethods'));
    }
}
