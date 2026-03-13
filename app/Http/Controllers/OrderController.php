<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Order::with('table')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(\App\Models\Order $order)
    {
        $order->load('items.menu', 'table');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, \App\Models\Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,cooking,served,completed,cancelled',
        ]);

        $order->update(['order_status' => $request->order_status]);

        // Auto-cancel payment and clear table when order is cancelled
        if ($request->order_status === 'cancelled') {
            $order->update(['payment_status' => 'cancelled']);
            
            // Clear the table
            $order->table->update([
                'status' => 'available'
            ]);
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
        // Clear the table
        $order->table->update([
            'status' => 'available'
        ]);

        // Delete order (will cascade delete order items)
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
