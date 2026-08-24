<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Order::with(['table', 'rating'])->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(\App\Models\Order $order)
    {
        $order->load(['items.menu', 'table', 'rating']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, \App\Models\Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,cooking,served,completed,cancelled',
            'waiter_name'  => 'nullable|string|max:255',
        ]);

        $updateData = ['order_status' => $request->order_status];
        if ($request->filled('waiter_name')) {
            $updateData['waiter_name'] = $request->waiter_name;
        }

        $order->update($updateData);

        // Auto-cancel payment and clear table when order is cancelled
        if ($request->order_status === 'cancelled') {
            $order->update(['payment_status' => 'cancelled']);
            
            $hasOtherActiveOrders = \App\Models\Order::where('table_id', $order->table_id)
                ->where('id', '!=', $order->id)
                ->whereIn('order_status', ['pending', 'cooking', 'served'])
                ->exists();

            if (!$hasOtherActiveOrders && $order->table) {
                $order->table->update(['status' => 'available']);
            }
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diupdate.');
    }

    public function verifyPayment(\App\Models\Order $order)
    {
        $order->update(['payment_status' => 'paid']);
        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function destroy(\App\Models\Order $order)
    {
        $table = $order->table;
        $orderId = $order->id;

        // Delete order (will cascade delete order items)
        $order->delete();

        // Clear table only if no other active orders exist
        if ($table) {
            $hasOtherActiveOrders = \App\Models\Order::where('table_id', $table->id)
                ->whereIn('order_status', ['pending', 'cooking', 'served'])
                ->exists();

            if (!$hasOtherActiveOrders) {
                $table->update(['status' => 'available']);
            }
        }

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
