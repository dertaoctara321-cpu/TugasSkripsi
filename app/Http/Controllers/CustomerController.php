<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index($uuid)
    {
        $table = \App\Models\Table::where('uuid', $uuid)->firstOrFail();
        $menus = \App\Models\Menu::where('is_available', true)->get();
        
        // Check if cart exists in session for this table UUID
        $cartKey = "cart_{$uuid}";
        $cart = session()->get($cartKey, []);
        
        // Get active order for this table (only if table is occupied)
        $activeOrder = null;
        if ($table->status == 'occupied') {
            $activeOrder = \App\Models\Order::where('table_id', $table->id)
                ->latest()
                ->first();
        }
        
        return view('customer.menu', compact('table', 'menus', 'cart', 'activeOrder'));
    }

    public function addToCart(Request $request, $uuid)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $menu = \App\Models\Menu::findOrFail($request->menu_id);
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

        $menu = \App\Models\Menu::findOrFail($request->menu_id);
        $cartKey = "cart_{$uuid}";
        $cart = session()->get($cartKey, []);

        if ($request->quantity > 0) {
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
        $table = \App\Models\Table::where('uuid', $uuid)->firstOrFail();
        $cartKey = "cart_{$uuid}";
        $cart = session()->get($cartKey, []);
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        
        return view('customer.checkout', compact('table', 'cart', 'paymentMethods'));
    }

    public function placeOrder(Request $request, $uuid)
    {
        $table = \App\Models\Table::where('uuid', $uuid)->firstOrFail();
        $cartKey = "cart_{$uuid}";
        $cart = session()->get($cartKey, []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong');
        }

        $existingOrder = null;
        if ($table->status == 'occupied') {
            $existingOrder = \App\Models\Order::where('table_id', $table->id)
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
            $paymentMethod = \App\Models\PaymentMethod::where('id', $request->payment_method_id)
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
                $existingItem = \App\Models\OrderItem::where('order_id', $existingOrder->id)
                    ->where('menu_id', $id)
                    ->first();
                
                if ($existingItem) {
                    $existingItem->quantity += $details['quantity'];
                    $existingItem->save();
                } else {
                    \App\Models\OrderItem::create([
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
            $order = \App\Models\Order::create([
                'table_id' => $table->id,
                'total_amount' => $newItemsTotal,
                'payment_method' => $paymentMethodName,
                'customer_name' => $request->customer_name,
                'floor' => $request->floor,
                'order_status' => 'pending',
                'payment_status' => 'pending'
            ]);

            foreach ($cart as $id => $details) {
                \App\Models\OrderItem::create([
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

    public function status($uuid, \App\Models\Order $order)
    {
        if ($order->table->uuid !== $uuid) {
            abort(403, 'Unauthorized access to this order.');
        }
        return view('customer.status', compact('order'));
    }

    public function paymentInfo($uuid)
    {
        $table = \App\Models\Table::where('uuid', $uuid)->firstOrFail();
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        
        return view('customer.payment_info', compact('table', 'paymentMethods'));
    }
}
