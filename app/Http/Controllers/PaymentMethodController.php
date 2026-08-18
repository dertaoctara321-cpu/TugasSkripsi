<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return view('admin.payment_methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('admin.payment_methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bank_transfer,qris,cash',
            'account_number' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'qr_code_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'instructions' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'type', 'account_number', 'account_name', 'instructions', 'is_active']);

        if ($request->hasFile('qr_code_image')) {
            $image = $request->file('qr_code_image');
            $imageName = \Illuminate\Support\Str::random(20) . '.' . $image->extension();
            $image->move(public_path('images/payment'), $imageName);
            $data['qr_code_image'] = 'images/payment/' . $imageName;
        }

        PaymentMethod::create($data);

        return redirect()->route('payment-methods.index')
                        ->with('success', 'Metode pembayaran berhasil ditambahkan');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:bank_transfer,qris,cash',
            'account_number' => 'nullable|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'qr_code_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'instructions' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'type', 'account_number', 'account_name', 'instructions', 'is_active']);

        if ($request->hasFile('qr_code_image')) {
            // Delete old image
            if ($paymentMethod->qr_code_image && file_exists(public_path($paymentMethod->qr_code_image))) {
                unlink(public_path($paymentMethod->qr_code_image));
            }

            $image = $request->file('qr_code_image');
            $imageName = \Illuminate\Support\Str::random(20) . '.' . $image->extension();
            $image->move(public_path('images/payment'), $imageName);
            $data['qr_code_image'] = 'images/payment/' . $imageName;
        }

        $paymentMethod->update($data);

        return redirect()->route('payment-methods.index')
                        ->with('success', 'Metode pembayaran berhasil diupdate');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        // Delete image if exists
        if ($paymentMethod->qr_code_image && file_exists(public_path($paymentMethod->qr_code_image))) {
            unlink(public_path($paymentMethod->qr_code_image));
        }

        $paymentMethod->delete();

        return redirect()->route('payment-methods.index')
                        ->with('success', 'Metode pembayaran berhasil dihapus');
    }
}
