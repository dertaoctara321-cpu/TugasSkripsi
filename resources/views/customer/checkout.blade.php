@extends('layouts.customer')

@section('title', 'Checkout Pesanan - Little Palembang')

@section('content')
<style>
    .checkout-card {
        animation: fadeInUp 0.5s ease-out;
        border-radius: 18px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .checkout-card .card-title {
        font-weight: 800;
        background: linear-gradient(135deg, #DC2626, #991B1B);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .total-amount {
        font-size: 1.35rem;
        font-weight: 800;
        color: #DC2626 !important;
    }

    .form-control, .form-select {
        border-radius: 12px;
        border: 1.5px solid #E2E8F0;
        padding: 12px 16px;
        transition: all 0.25s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #DC2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
    }

    .btn-submit {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 50%, #B91C1C 100%) !important;
        border: none;
        border-radius: 12px;
        padding: 15px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.25s ease;
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(220, 38, 38, 0.55);
    }
</style>

<div class="card checkout-card">
    <div class="card-body p-4">
        <h4 class="card-title mb-4"><i class="fas fa-shopping-bag text-danger me-2"></i> Konfirmasi Pesanan Anda</h4>
        
        @if(!empty($cart))
            @php 
                $activeOrder = null;
                if ($table->status == 'occupied') {
                    $activeOrder = \App\Models\Order::where('table_id', $table->id)->latest()->first();
                }
            @endphp

            @if($activeOrder)
            <div class="alert alert-info mb-4" style="border-radius: 12px; border-left: 4px solid #DC2626; background: #FFF1F2; color: #991B1B;">
                <i class="fas fa-info-circle me-1"></i> <strong>Pesanan Aktif:</strong> Anda sudah memiliki pesanan yang sedang berjalan. 
                Menu baru yang Anda checkout akan ditambahkan ke pesanan meja Anda.
            </div>
            @endif

            <div class="table-responsive">
                <table class="table checkout-table">
                    <thead>
                        <tr style="background: #FFF1F2; color: #991B1B;">
                            <th>Item Menu</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0 @endphp
                        @foreach($cart as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr>
                                <td><strong>{{ $details['name'] }}</strong></td>
                                <td class="text-center font-weight-bold">{{ $details['quantity'] }}x</td>
                                <td class="text-end">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                <td class="text-end font-weight-bold" style="color: #DC2626;">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">{{ $activeOrder ? 'Total Item Baru' : 'Grand Total' }}</td>
                            <td class="total-amount text-end">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                        @if($activeOrder)
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total Pesanan Sebelumnya</td>
                            <td class="fw-bold text-end">Rp {{ number_format($activeOrder->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr style="background: #FFF1F2;">
                            <td colspan="3" class="text-end fw-bold" style="color: #991B1B; font-size: 1.15rem;">TOTAL KESELURUHAN</td>
                            <td class="total-amount text-end">Rp {{ number_format($total + $activeOrder->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    </tfoot>
                </table>
            </div>

            <form action="{{ route('order.placeOrder', request()->route('uuid')) }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Pemesan <span class="text-danger">*</span></label>
                    <input type="text" name="customer_name" class="form-control" 
                           placeholder="Contoh: Budi" 
                           value="{{ $activeOrder ? $activeOrder->customer_name : '' }}"
                           {{ $activeOrder ? 'readonly' : 'required' }}>
                    @if($activeOrder)
                    <small class="text-muted">Nama disesuaikan dengan pesanan aktif sebelumnya</small>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Lantai Kafe <span class="text-danger">*</span></label>
                    <select name="floor" class="form-select" {{ $activeOrder ? 'disabled' : 'required' }}>
                        <option value="Lantai 1" {{ $activeOrder && $activeOrder->floor == 'Lantai 1' ? 'selected' : '' }}>Lantai 1</option>
                        <option value="Lantai 2" {{ $activeOrder && $activeOrder->floor == 'Lantai 2' ? 'selected' : '' }}>Lantai 2</option>
                    </select>
                    @if($activeOrder)
                    <input type="hidden" name="floor" value="{{ $activeOrder->floor }}">
                    @endif
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Pilihan Metode Pembayaran <span class="text-danger">*</span></label>
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
                    <small class="text-muted">Metode pembayaran mengikuti pesanan aktif</small>
                    @endif
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg btn-submit text-white">
                        <i class="fas fa-check-circle me-1"></i> {{ $activeOrder ? 'Tambahkan ke Pesanan' : 'Konfirmasi & Pesan Sekarang' }}
                    </button>
                    <a href="{{ route('order.index', request()->route('uuid')) }}" class="btn btn-outline-secondary" style="border-radius: 12px; font-weight: 600; padding: 10px;">
                        <i class="fas fa-arrow-left me-1"></i> Kembali Pilih Menu
                    </a>
                </div>
            </form>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-bag fa-3x mb-3 text-muted"></i>
                <p class="text-muted">Keranjang Anda kosong.</p>
                <a href="{{ route('order.index', request()->route('uuid')) }}" class="btn btn-primary">
                    <i class="fas fa-utensils me-1"></i> Lihat Daftar Menu
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
