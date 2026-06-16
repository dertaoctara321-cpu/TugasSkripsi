@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')
<style>
    .orders-table-wrapper {
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
    
    .status-badge-pending {
        background: linear-gradient(135deg, #FFC107, #FFA000);
        color: white;
    }
    
    .status-badge-cooking {
        background: linear-gradient(135deg, #FF8C42, #8B4513);
        color: white;
    }
    
    .status-badge-served {
        background: linear-gradient(135deg, #2196F3, #1976D2);
        color: white;
    }
    
    .status-badge-completed {
        background: linear-gradient(135deg, #4CAF50, #388E3C);
        color: white;
    }
    
    .status-badge-cancelled {
        background: linear-gradient(135deg, #9E9E9E, #757575);
        color: white;
    }
</style>

<div class="card orders-table-wrapper">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-receipt"></i> Pesanan Masuk</h3>
    </div>
    <div class="card-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ $message }}
            </div>
        @endif
        
        <!-- Desktop Table View -->
        <div class="d-none d-lg-block">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Meja</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status Pesanan</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td><i class="fas fa-table"></i> Meja {{ $order->table->table_number }} <br><small class="text-muted">{{ $order->floor ?? '-' }}</small></td>
                            <td>{{ $order->customer_name }}</td>
                            <td><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                            <td>
                                @php
                                    $statusClass = 'status-badge-' . $order->order_status;
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    @if($order->order_status == 'pending')
                                        <i class="fas fa-clock"></i>
                                    @elseif($order->order_status == 'cooking')
                                        <i class="fas fa-fire"></i>
                                    @elseif($order->order_status == 'served')
                                        <i class="fas fa-concierge-bell"></i>
                                    @elseif($order->order_status == 'completed')
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        <i class="fas fa-times-circle"></i>
                                    @endif
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}">
                                    <i class="fas fa-{{ $order->payment_status == 'paid' ? 'check' : 'times' }}"></i>
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="d-lg-none">
            @foreach ($orders as $order)
            <div class="card mb-3" style="border-left: 4px solid var(--admin-primary);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-receipt"></i> Order #{{ $order->id }}
                        </h5>
                        @php
                            $statusClass = 'status-badge-' . $order->order_status;
                        @endphp
                        <span class="badge {{ $statusClass }}">
                            @if($order->order_status == 'pending')
                                <i class="fas fa-clock"></i>
                            @elseif($order->order_status == 'cooking')
                                <i class="fas fa-fire"></i>
                            @elseif($order->order_status == 'served')
                                <i class="fas fa-concierge-bell"></i>
                            @elseif($order->order_status == 'completed')
                                <i class="fas fa-check-circle"></i>
                            @else
                                <i class="fas fa-times-circle"></i>
                            @endif
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>

                    <div class="mb-2">
                        <strong><i class="fas fa-table"></i> Meja:</strong> {{ $order->table->table_number }} ({{ $order->floor ?? '-' }})
                    </div>
                    <div class="mb-2">
                        <strong><i class="fas fa-user"></i> Pelanggan:</strong> {{ $order->customer_name }}
                    </div>
                    <div class="mb-2">
                        <strong><i class="fas fa-money-bill-wave"></i> Total:</strong> 
                        <span class="text-success fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-3">
                        <strong><i class="fas fa-credit-card"></i> Pembayaran:</strong>
                        <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}">
                            <i class="fas fa-{{ $order->payment_status == 'paid' ? 'check' : 'times' }}"></i>
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>

                    <div class="btn-group btn-block" role="group">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-block">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
