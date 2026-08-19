@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<style>
    .order-details-wrapper {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .info-card {
        position: sticky;
        top: 20px;
    }

    .status-select {
        font-size: 1.1rem;
        padding: 12px 14px;
        font-weight: 700;
        border-radius: 10px;
        border: 2px solid #DC2626;
        background-color: white;
        color: #0F172A;
    }

    .status-select:focus {
        border-color: #991B1B;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.2);
    }

    .info-item {
        padding: 10px 0;
        border-bottom: 1px solid #E2E8F0;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #64748B;
        display: block;
        font-size: 0.85rem;
        margin-bottom: 2px;
    }

    .info-value {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0F172A;
    }

    body.dark-mode .info-value {
        color: #F8FAFC;
    }
</style>

<div class="row order-details-wrapper">
    <!-- Order Items - Left Side -->
    <div class="col-lg-8 mb-4">
        <div class="card card-red">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title text-white mb-0">
                    <i class="fas fa-utensils mr-2"></i> Daftar Menu Pesanan #{{ $order->id }}
                </h3>
                <span class="badge badge-light" style="color: #DC2626; font-size: 0.85rem;">
                    {{ $order->items->count() }} Item
                </span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th class="text-center" style="width: 80px;">Qty</th>
                                <th class="text-right">Harga Satuan</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->menu && $item->menu->image)
                                            <img src="{{ asset('storage/' . $item->menu->image) }}" alt="{{ $item->menu->name }}" class="rounded mr-3" style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #E2E8F0;">
                                        @endif
                                        <div>
                                            <strong class="d-block" style="font-size: 1.05rem;">{{ $item->menu->name ?? 'Menu tidak ditemukan' }}</strong>
                                            @if($item->notes)
                                                <small class="text-danger font-italic"><i class="fas fa-sticky-note mr-1"></i> Catatan: {{ $item->notes }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center font-weight-bold" style="font-size: 1.1rem;">{{ $item->quantity }}x</td>
                                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-right font-weight-bold" style="color: #DC2626;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background: #FFF1F2; font-size: 1.15rem;">
                                <td colspan="3" class="text-right font-weight-bold" style="color: #991B1B;">Total Keseluruhan :</td>
                                <td class="text-right font-weight-bold" style="color: #DC2626;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-3 text-right">
                    <button onclick="window.print()" class="btn btn-secondary btn-sm">
                        <i class="fas fa-print mr-1"></i> Cetak Struk / Nota
                    </button>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-danger btn-sm ml-2">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Info & Role Actions - Right Side -->
    <div class="col-lg-4">
        <div class="card info-card">
            <div class="card-header bg-danger text-white">
                <h3 class="card-title mb-0"><i class="fas fa-info-circle mr-2"></i> Informasi & Status</h3>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-chair mr-1"></i> Lokasi Meja</span>
                    <span class="info-value">Meja {{ $order->table->table_number ?? '-' }} {{ $order->floor ? "({$order->floor})" : '' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label"><i class="fas fa-user mr-1"></i> Nama Pelanggan</span>
                    <span class="info-value">{{ $order->customer_name ?? 'Pelanggan / Tamu' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label"><i class="fas fa-credit-card mr-1"></i> Metode Pembayaran</span>
                    <span class="info-value">{{ $order->payment_method ?? 'Cash' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label"><i class="fas fa-clock mr-1"></i> Waktu Pemesanan</span>
                    <span class="info-value">{{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label"><i class="fas fa-shield-alt mr-1"></i> Status Pembayaran</span>
                    <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }} p-2 mt-1" style="font-size: 0.9rem;">
                        <i class="fas fa-{{ $order->payment_status == 'paid' ? 'check-circle' : 'exclamation-circle' }} mr-1"></i>
                        {{ $order->payment_status == 'paid' ? 'LUNAS (TERVERIFIKASI)' : 'BELUM DIVERIFIKASI' }}
                    </span>
                </div>

                <hr class="my-3">

                <!-- 1. Dapur / Admin: Ubah Status Masak & Sajian -->
                @if(Auth::user()->isAdmin() || Auth::user()->isDapur())
                <div class="mb-3">
                    <label class="info-label font-weight-bold text-danger"><i class="fas fa-fire mr-1"></i> Update Status Pengerjaan (Dapur)</label>
                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <select name="order_status" class="form-control status-select" required>
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>⏳ Menunggu (Pending)</option>
                                <option value="cooking" {{ $order->order_status == 'cooking' ? 'selected' : '' }}>🍳 Sedang Dimasak (Cooking)</option>
                                <option value="served" {{ $order->order_status == 'served' ? 'selected' : '' }}>🛎️ Dihidangkan (Served)</option>
                                <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>✅ Selesai (Completed)</option>
                                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>❌ Batalkan Pesanan</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block font-weight-bold">
                            <i class="fas fa-sync-alt mr-1"></i> Simpan Status Pesanan
                        </button>
                    </form>
                </div>
                @endif

                <!-- 2. Kasir / Admin: Verifikasi Pembayaran -->
                @if(Auth::user()->isAdmin() || Auth::user()->isKasir())
                <div class="mb-3">
                    <label class="info-label font-weight-bold text-success"><i class="fas fa-cash-register mr-1"></i> Tindakan Kasir (POS)</label>
                    @if($order->payment_status != 'paid')
                    <form action="{{ route('orders.verifyPayment', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-block font-weight-bold" onclick="return confirm('Pastikan pembayaran dari pelanggan telah diterima. Verifikasi sekarang?')">
                            <i class="fas fa-check-circle mr-1"></i> Verifikasi Pembayaran Lunas
                        </button>
                    </form>
                    @else
                    <div class="alert alert-success text-center py-2 mb-2 font-weight-bold">
                        <i class="fas fa-check-circle mr-1"></i> Pembayaran Sudah Lunas
                    </div>
                    @endif

                    @if($order->table && $order->table->status == 'occupied')
                    <form action="{{ route('tables.clear', $order->table->id) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-block font-weight-bold text-dark" onclick="return confirm('Kosongkan meja {{ $order->table->table_number }} untuk pelanggan baru?')">
                            <i class="fas fa-door-open mr-1"></i> Kosongkan Meja {{ $order->table->table_number }}
                        </button>
                    </form>
                    @endif
                </div>
                @endif

                <!-- 3. Admin Only: Hapus Pesanan -->
                @if(Auth::user()->isAdmin())
                <hr class="my-3">
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-block font-weight-bold" onclick="return confirm('Yakin ingin menghapus permanen pesanan ini?')">
                        <i class="fas fa-trash mr-1"></i> Hapus Pesanan (Admin)
                    </button>
                </form>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
