@extends('layouts.admin')

@section('title', Auth::user()->isDapur() ? 'Antrean Pesanan Dapur' : (Auth::user()->isKasir() ? 'Kasir & Pembayaran' : 'Pesanan Masuk'))

@section('content')
<style>
    .orders-table-wrapper {
        animation: fadeIn 0.4s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="card orders-table-wrapper card-red">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title text-white mb-0">
            <i class="fas fa-receipt mr-2"></i> 
            @if(Auth::user()->isDapur())
                Daftar Pesanan yang Perlu Diproses Dapur
            @elseif(Auth::user()->isKasir())
                Daftar Pesanan & Pembayaran Kasir
            @else
                Semua Pesanan Masuk
            @endif
        </h3>
        <span class="badge badge-light ml-auto font-weight-bold" style="color: #DC2626; font-size: 0.85rem;">
            Total: {{ $orders->count() }} Pesanan
        </span>
    </div>
    <div class="card-body">
        
        <!-- Desktop Table View -->
        <div class="d-none d-lg-block">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 70px;">ID</th>
                            <th>Meja</th>
                            <th>Nama Pelanggan</th>
                            <th>Total Tagihan</th>
                            <th>Status Pesanan</th>
                            <th>Status Pembayaran</th>
                            <th>Waktu Masuk</th>
                            <th class="text-center" style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td><strong class="text-danger">#{{ $order->id }}</strong></td>
                            <td>
                                <strong><i class="fas fa-chair text-muted mr-1"></i> Meja {{ $order->table->table_number ?? '-' }}</strong>
                                @if($order->floor)
                                    <br><small class="text-muted">{{ $order->floor }}</small>
                                @endif
                            </td>
                            <td>{{ $order->customer_name ?? 'Tamu' }}</td>
                            <td><strong style="color: #DC2626;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                            <td>
                                @php
                                    $statusClass = 'status-badge-' . $order->order_status;
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    @if($order->order_status == 'pending')
                                        <i class="fas fa-clock mr-1"></i> Menunggu
                                    @elseif($order->order_status == 'cooking')
                                        <i class="fas fa-fire mr-1"></i> Dimasak
                                    @elseif($order->order_status == 'served')
                                        <i class="fas fa-concierge-bell mr-1"></i> Dihidangkan
                                    @elseif($order->order_status == 'completed')
                                        <i class="fas fa-check-circle mr-1"></i> Selesai
                                    @else
                                        <i class="fas fa-times-circle mr-1"></i> {{ ucfirst($order->order_status) }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}">
                                    <i class="fas fa-{{ $order->payment_status == 'paid' ? 'check' : 'times' }} mr-1"></i>
                                    {{ $order->payment_status == 'paid' ? 'Lunas' : 'Belum Bayar' }}
                                </span>
                            </td>
                            <td><small class="text-muted">{{ $order->created_at ? $order->created_at->format('d/m H:i') : '-' }}</small></td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    @if(Auth::user()->isAdmin())
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada pesanan masuk saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="d-lg-none">
            @forelse ($orders as $order)
            <div class="card mb-3" style="border-left: 5px solid #DC2626;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0 font-weight-bold text-danger">
                            <i class="fas fa-receipt mr-1"></i> Order #{{ $order->id }}
                        </h5>
                        @php
                            $statusClass = 'status-badge-' . $order->order_status;
                        @endphp
                        <span class="badge {{ $statusClass }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>

                    <div class="mb-2">
                        <strong><i class="fas fa-chair text-muted mr-1"></i> Meja:</strong> {{ $order->table->table_number ?? '-' }}
                    </div>
                    <div class="mb-2">
                        <strong><i class="fas fa-user text-muted mr-1"></i> Pelanggan:</strong> {{ $order->customer_name ?? 'Tamu' }}
                    </div>
                    <div class="mb-2">
                        <strong><i class="fas fa-money-bill-wave text-muted mr-1"></i> Total:</strong> 
                        <span class="font-weight-bold text-danger">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-credit-card text-muted mr-1"></i> Pembayaran:</strong>
                        <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}">
                            {{ $order->payment_status == 'paid' ? 'Lunas' : 'Belum Bayar' }}
                        </span>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-block">
                            <i class="fas fa-eye mr-1"></i> Lihat Detail Pesanan
                        </a>
                        @if(Auth::user()->isAdmin())
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="margin-left: 8px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-4 text-muted">
                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                Belum ada pesanan masuk.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
