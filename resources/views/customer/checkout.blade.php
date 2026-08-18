@extends('layouts.customer')

@section('title', 'Checkout - Little Palembang')

@push('css')
<style>
    .checkout-card {
        animation: fadeInUp 0.6s ease-out;
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .checkout-card .card-title {
        font-weight: 700;
        background: linear-gradient(135deg, #8B4513, #FF8C42);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .checkout-table tbody tr {
        animation: slideInLeft 0.4s ease-out;
        animation-fill-mode: both;
    }

    .checkout-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
    .checkout-table tbody tr:nth-child(2) { animation-delay: 0.2s; }
    .checkout-table tbody tr:nth-child(3) { animation-delay: 0.3s; }
    .checkout-table tbody tr:nth-child(4) { animation-delay: 0.4s; }
    .checkout-table tbody tr:nth-child(5) { animation-delay: 0.5s; }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .total-amount {
        font-size: 1.3rem;
        font-weight: 700;
        background: linear-gradient(135deg, #FF8C42, #8B4513);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1.5px solid #ddd;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #FF8C42;
        box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.2);
    }

    .btn-submit {
        background: linear-gradient(135deg, #FF8C42, #8B4513);
        border: none;
        border-radius: 12px;
        padding: 15px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-submit:hover::before {
        width: 400px;
        height: 400px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(139, 69, 19, 0.4);
    }

    .empty-cart-icon {
        animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
</style>
@endpush

@section('content')
<div class="card checkout-card">
    <div class="card-body">
        <h4 class="card-title mb-4">🛒 Pesanan Anda</h4>
        
        @if(!empty($cart))
            @php 
                $activeOrder = null;
                if ($table->status == 'occupied') {
                    $activeOrder = \App\Models\Order::where('table_id', $table->id)->latest()->first();
                }
            @endphp

            @if($activeOrder)
            <div class="alert alert-info" style="border-radius: 10px; border-left: 4px solid #FF8C42;">
                <i class="fas fa-info-circle"></i> <strong>Info:</strong> Anda sudah memiliki pesanan aktif. 
                Item baru akan ditambahkan ke pesanan yang sudah ada.
            </div>
            @endif

            <div class="table-responsive">
                <table class="table checkout-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0 @endphp
                        @foreach($cart as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr>
                                <td>{{ $details['name'] }}</td>
                                <td>{{ $details['quantity'] }}</td>
                                <td>{{ number_format($details['price'], 0, ',', '.') }}</td>
                                <td>{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">{{ $activeOrder ? 'Total Item Baru' : 'Grand Total' }}</td>
                            <td class="total-amount">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                        @if($activeOrder)
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total Pesanan Sebelumnya</td>
                            <td class="fw-bold">Rp {{ number_format($activeOrder->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">GRAND TOTAL</td>
                            <td class="total-amount">Rp {{ number_format($total + $activeOrder->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    </tfoot>
                </table>
            </div>

            <form action="{{ route('order.placeOrder', request()->route('uuid')) }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Anda <span class="text-danger">*</span></label>
                    <input type="text" name="customer_name" class="form-control" 
                           placeholder="Nama Lengkap" 
                           value="{{ $activeOrder ? $activeOrder->customer_name : '' }}"
                           {{ $activeOrder ? 'readonly' : 'required' }}>
                    @if($activeOrder)
                    <small class="text-muted">Nama dari pesanan aktif</small>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Lantai Kafe <span class="text-danger">*</span></label>
                    <select name="floor" class="form-select" {{ $activeOrder ? 'disabled' : 'required' }}>
                        <option value="Lantai 1" {{ $activeOrder && $activeOrder->floor == 'Lantai 1' ? 'selected' : '' }}>Lantai 1</option>
                        <option value="Lantai 2" {{ $activeOrder && $activeOrder->floor == 'Lantai 2' ? 'selected' : '' }}>Lantai 2</option>
                    </select>
                    @if($activeOrder)
                    <input type="hidden" name="floor" value="{{ $activeOrder->floor }}">
                    <small class="text-muted">Lantai dari pesanan aktif</small>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                    <select name="payment_method_id" class="form-select" {{ $activeOrder ? 'disabled' : 'required' }}>
                        @if($paymentMethods->count() > 0)
                            @foreach($paymentMethods as $pm)
                                <option value="{{ $pm->id }}" {{ $activeOrder && strtolower($activeOrder->payment_method) == strtolower($pm->name) ? 'selected' : '' }}>
                                    {{ $pm->name }} {{ $pm->type ? '('.strtoupper(str_replace('_', ' ', $pm->type)).')' : '' }}
                                </option>
                            @endforeach
                        @else
                            <option value="">Cash (Bayar di Kasir)</option>
                        @endif
                    </select>
                    @if($activeOrder)
                    <small class="text-muted">Metode pembayaran dari pesanan aktif</small>
                    @endif
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg btn-submit">
                        <i class="fas fa-check-circle"></i> {{ $activeOrder ? 'Tambahkan ke Pesanan' : 'Pesan Sekarang' }}
                    </button>
                    <a href="{{ route('order.index', request()->route('uuid')) }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
                        <i class="fas fa-arrow-left"></i> Tambah Item Lagi
                    </a>
                </div>
            </form>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x mb-3 text-muted empty-cart-icon"></i>
                <p>Keranjang Anda kosong.</p>
                <a href="{{ route('order.index', request()->route('uuid')) }}" class="btn btn-primary">
                    <i class="fas fa-utensils"></i> Browse Menu
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
