@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    .order-details-wrapper {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .info-card {
        position: sticky;
        top: 20px;
    }

    .status-select {
        font-size: 1.3rem;
        padding: 18px;
        font-weight: 700;
        border-radius: 12px;
        border: 3px solid var(--admin-primary);
        background-color: white;
        color: #333;
        height: auto;
        min-height: 60px;
        line-height: 1.5;
    }

    .status-select:focus {
        border-color: var(--admin-secondary);
        box-shadow: 0 0 0 4px rgba(255, 140, 66, 0.3);
    }

    .status-select option {
        font-size: 1.2rem;
        padding: 15px 10px;
        font-weight: 600;
        background-color: white;
        color: #333;
        line-height: 2;
        min-height: 50px;
    }

    .status-select option:hover,
    .status-select option:checked {
        background-color: var(--admin-primary);
        color: white;
    }

    .update-status-btn {
        padding: 18px 20px;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .verify-payment-btn {
        padding: 20px;
        font-size: 1.3rem;
        font-weight: 700;
        margin-top: 15px;
    }

    .info-item {
        padding: 12px 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: var(--admin-secondary);
        display: block;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 1.1rem;
    }
</style>

<div class="row order-details-wrapper">
    <!-- Order Items - Left Side -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-utensils"></i> Item Pesanan</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                            <tr>
                                <td><strong>{{ $item->menu->name }}</strong></td>
                                <td>{{ $item->quantity }}x</td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td><strong>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background: linear-gradient(135deg, rgba(255, 140, 66, 0.1), rgba(139, 69, 19, 0.1));">
                                <th colspan="3" class="text-right" style="font-size: 1.2rem;">TOTAL:</th>
                                <th style="font-size: 1.3rem; color: var(--admin-primary);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Info - Right Side (Full Height) -->
    <div class="col-md-4">
        <div class="card info-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Pesanan</h3>
            </div>
            <div class="card-body">
                <!-- Order Information -->
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-table"></i> Meja / Lantai</span>
                    <span class="info-value">Meja {{ $order->table->table_number }} <span class="badge badge-info">{{ $order->floor ?? '-' }}</span></span>
                </div>

                <div class="info-item">
                    <span class="info-label"><i class="fas fa-user"></i> Pelanggan</span>
                    <span class="info-value">{{ $order->customer_name ?? 'Tamu' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label"><i class="fas fa-credit-card"></i> Metode Pembayaran</span>
                    <span class="info-value">{{ $order->payment_method }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label"><i class="fas fa-clock"></i> Waktu Pemesanan</span>
                    <span class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label"><i class="fas fa-fire"></i> Status Pesanan</span>
                    @php
                        $statusMap = [
                            'pending' => 'Menunggu',
                            'cooking' => 'Sedang Dimasak',
                            'served' => 'Dihidangkan',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan'
                        ];
                        $statusClass = 'status-badge-' . $order->order_status;
                    @endphp
                    <span class="badge {{ $statusClass }}" style="font-size: 0.95rem; padding: 8px 15px;">
                        {{ $statusMap[$order->order_status] ?? ucfirst($order->order_status) }}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label"><i class="fas fa-money-bill-wave"></i> Status Pembayaran</span>
                    @php
                        $paymentMap = [
                            'pending' => 'Belum Dibayar',
                            'paid' => 'Sudah Dibayar',
                            'cancelled' => 'Dibatalkan'
                        ];
                    @endphp
                    <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'cancelled' ? 'secondary' : 'danger') }}" style="font-size: 0.95rem; padding: 8px 15px;">
                        {{ $paymentMap[$order->payment_status] ?? ucfirst($order->payment_status) }}
                    </span>
                </div>

                <hr style="margin: 20px 0; border-top: 2px solid #e0e0e0;">

                <!-- Update Order Status -->
                @if(in_array($order->order_status, ['completed', 'cancelled']))
                    <div class="alert alert-info text-center" style="border-radius: 10px; font-weight: 600;">
                        <i class="fas fa-lock"></i> Status pesanan tidak dapat diubah lagi
                    </div>
                @else
                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="mb-3" id="statusForm">
                    @csrf
                    @method('PUT')
                    <label class="info-label"><i class="fas fa-edit"></i> Ubah Status Pesanan</label>
                    <div class="input-group">
                        <select name="order_status" class="form-control status-select" id="orderStatusSelect">
                            <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="cooking" {{ $order->order_status == 'cooking' ? 'selected' : '' }}>Sedang Dimasak</option>
                            <option value="served" {{ $order->order_status == 'served' ? 'selected' : '' }}>Dihidangkan</option>
                            <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block update-status-btn mt-2">
                        <i class="fas fa-check"></i> Update Status
                    </button>
                </form>
                @endif

                <!-- Verify Payment Button -->
                @if($order->payment_status == 'pending' && $order->order_status != 'cancelled')
                <form action="{{ route('orders.verifyPayment', $order->id) }}" method="POST" id="verifyPaymentForm">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success btn-block verify-payment-btn">
                        <i class="fas fa-check-circle"></i> Verifikasi Pembayaran
                    </button>
                </form>
                @elseif($order->payment_status == 'paid')
                <div class="alert alert-success text-center" style="border-radius: 10px; font-weight: 600;">
                    <i class="fas fa-check-circle"></i> Pembayaran Sudah Terverifikasi
                </div>
                @elseif($order->payment_status == 'cancelled')
                <div class="alert alert-secondary text-center" style="border-radius: 10px; font-weight: 600;">
                    <i class="fas fa-ban"></i> Pembayaran Dibatalkan
                </div>
                @endif

                <!-- Delete Order Button -->
                <hr style="margin: 20px 0; border-top: 2px solid #e0e0e0;">
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" id="deleteOrderForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block" style="padding: 15px; font-size: 1.1rem; font-weight: 700;">
                        <i class="fas fa-trash"></i> Hapus Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Custom SweetAlert2 theme
const swalTheme = {
    confirmButtonColor: '#FF8C42',
    cancelButtonColor: '#9E9E9E',
    background: '#fff',
    color: '#333',
    iconColor: '#FF8C42'
};

// Auto-cancel payment when order is cancelled
const orderStatusSelect = document.getElementById('orderStatusSelect');
if (orderStatusSelect) {
    orderStatusSelect.addEventListener('change', function(e) {
        if (this.value === 'cancelled') {
            e.preventDefault();
            const currentValue = this.value;
            const previousValue = '{{ $order->order_status }}';
            
            Swal.fire({
                title: 'Batalkan Pesanan?',
                html: '<div style="text-align: left; padding: 10px;"><strong>Membatalkan pesanan akan:</strong><ul style="margin-top: 10px;"><li>Mengubah status pembayaran menjadi "Dibatalkan"</li><li>Mengosongkan meja</li></ul></div>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check"></i> Ya, Batalkan',
                cancelButtonText: '<i class="fas fa-times"></i> Tidak',
                ...swalTheme,
                customClass: {
                    confirmButton: 'btn btn-danger btn-lg',
                    cancelButton: 'btn btn-secondary btn-lg'
                }
            }).then((result) => {
                if (!result.isConfirmed) {
                    // Reset to previous value
                    this.value = previousValue;
                }
            });
        }
    });
}

// Verify payment confirmation
const verifyForm = document.getElementById('verifyPaymentForm');
if (verifyForm) {
    verifyForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Verifikasi Pembayaran?',
            text: 'Konfirmasi bahwa pembayaran sudah diterima?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check-circle"></i> Ya, Verifikasi',
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            ...swalTheme,
            customClass: {
                confirmButton: 'btn btn-success btn-lg',
                cancelButton: 'btn btn-secondary btn-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
}

// Update status confirmation
const statusForm = document.getElementById('statusForm');
if (statusForm) {
    statusForm.addEventListener('submit', function(e) {
        const selectedStatus = document.getElementById('orderStatusSelect').value;
        const statusMap = {
            'pending': 'Menunggu',
            'cooking': 'Sedang Dimasak',
            'served': 'Dihidangkan',
            'completed': 'Selesai',
            'cancelled': 'Dibatalkan'
        };
        
        e.preventDefault();
        
        Swal.fire({
            title: 'Update Status Pesanan?',
            html: `Ubah status menjadi <strong>"${statusMap[selectedStatus]}"</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check"></i> Ya, Update',
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            ...swalTheme,
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                cancelButton: 'btn btn-secondary btn-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
}

// Delete order confirmation
const deleteForm = document.getElementById('deleteOrderForm');
if (deleteForm) {
    deleteForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Hapus Pesanan?',
            html: '<strong>Pesanan akan dihapus permanen!</strong><br>Tindakan ini tidak dapat dibatalkan.',
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus',
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            ...swalTheme,
            confirmButtonColor: '#F44336',
            customClass: {
                confirmButton: 'btn btn-danger btn-lg',
                cancelButton: 'btn btn-secondary btn-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
}
</script>
@endpush
