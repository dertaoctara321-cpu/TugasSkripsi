<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index($uuid)
    {
        $table = \App\Models\Table::where('uuid', $uuid)->firstOrFail();
        $menus = \App\Models\Menu::where('is_available', true)->get();
        
        // Check if cart exists in session
        $cart = session()->get('cart', []);
        
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
            'quantity' => 'required|integer|min:1|max:100', // Frontend should prevent 0
        ]);

        $menu = \App\Models\Menu::findOrFail($request->menu_id);
        $cart = session()->get('cart', []);
        
        if(isset($cart[$request->menu_id])) {
            $cart[$request->menu_id]['quantity'] += $request->quantity;
        } else {
            $cart[$request->menu_id] = [
                "name" => $menu->name,
                "quantity" => $request->quantity,
                "price" => $menu->price,
                "image" => $menu->image
            ];
        }
        
        session()->put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            // Include cart count or just success
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
            'quantity' => 'required|integer|min:0',
        ]);

        $menu = \App\Models\Menu::findOrFail($request->menu_id);
        $cart = session()->get('cart', []);

        if ($request->quantity > 0) {
            $cart[$request->menu_id] = [
                "name" => $menu->name,
                "quantity" => $request->quantity,
                "price" => $menu->price,
                "image" => $menu->image
            ];
        } else {
            // Remove item from cart if qty is 0
            if (isset($cart[$request->menu_id])) {
                unset($cart[$request->menu_id]);
            }
        }

        session()->put('cart', $cart);

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
        session()->forget('cart');
        return response()->json([
            'success' => true,
            'cart_count' => 0,
            'cart_total' => 0
        ]);
    }

    public function checkout($uuid)
    {
        $table = \App\Models\Table::where('uuid', $uuid)->firstOrFail();
        $cart = session()->get('cart', []);
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        
        return view('customer.checkout', compact('table', 'cart', 'paymentMethods'));
    }

    public function placeOrder(Request $request, $uuid)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'payment_method' => 'required|in:Cash,Transfer',
            'floor' => 'required|string|in:Lantai 1,Lantai 2'
        ]);

        $table = \App\Models\Table::where('uuid', $uuid)->firstOrFail();
        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong');
        }

        // Calculate new items total
        $newItemsTotal = 0;
        foreach($cart as $id => $details) {
            $newItemsTotal += $details['price'] * $details['quantity'];
        }

        // Check if there's an existing active order for this table (only if table is occupied)
        $existingOrder = null;
        if ($table->status == 'occupied') {
            $existingOrder = \App\Models\Order::where('table_id', $table->id)
                ->latest()
                ->first();
        }

        if ($existingOrder) {
            // Add new items to existing order
            foreach($cart as $id => $details) {
                // Check if this menu item already exists in the order
                $existingItem = \App\Models\OrderItem::where('order_id', $existingOrder->id)
                    ->where('menu_id', $id)
                    ->first();
                
                if ($existingItem) {
                    // Update quantity if item already exists
                    $existingItem->quantity += $details['quantity'];
                    $existingItem->save();
                } else {
                    // Create new order item
                    \App\Models\OrderItem::create([
                        'order_id' => $existingOrder->id,
                        'menu_id' => $id,
                        'quantity' => $details['quantity'],
                        'price' => $details['price']
                    ]);
                }
            }

            // Update total amount and optionally floor
            $existingOrder->total_amount += $newItemsTotal;
            if ($request->has('floor')) {
                $existingOrder->floor = $request->floor;
            }
            
            // Reset payment status to pending if it was already paid
            // Customer needs to pay for the additional items
            if ($existingOrder->payment_status == 'paid') {
                $existingOrder->payment_status = 'pending';
            }
            
            $existingOrder->save();

            session()->forget('cart');

            return redirect()->route('order.status', ['uuid' => $uuid, 'order' => $existingOrder->id])
                ->with('success', 'Item berhasil ditambahkan ke pesanan yang sudah ada!');
        } else {
            // Create new order if no active order exists
            $order = \App\Models\Order::create([
                'table_id' => $table->id,
                'total_amount' => $newItemsTotal,
                'payment_method' => $request->payment_method,
                'customer_name' => $request->customer_name,
                'floor' => $request->floor,
                'order_status' => 'pending',
                'payment_status' => 'pending'
            ]);

            foreach($cart as $id => $details) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price']
                ]);
            }

            // Set table status to occupied
            $table->status = 'occupied';
            $table->save();

            // Auto re-enable location validation if it was disabled
            // This prevents staff from forgetting to re-enable during busy times
            if (!$table->require_location) {
                $table->require_location = true;
                $table->save();
                \Log::info("Location validation auto re-enabled for table: {$table->table_number} after order placement");
            }

            session()->forget('cart');

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
