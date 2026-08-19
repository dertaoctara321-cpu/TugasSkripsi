@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<style>
    .stats-card {
        animation: fadeInUp 0.5s ease-out;
        animation-fill-mode: both;
    }
    
    .stats-card:nth-child(1) { animation-delay: 0.05s; }
    .stats-card:nth-child(2) { animation-delay: 0.1s; }
    .stats-card:nth-child(3) { animation-delay: 0.15s; }
    .stats-card:nth-child(4) { animation-delay: 0.2s; }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chart-card {
        animation: fadeIn 0.6s ease-out;
        animation-fill-mode: both;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-lg-3 col-6 stats-card">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Rp {{ number_format($today, 0, ',', '.') }}</h3>
                <p>Penjualan Hari Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-cash-register"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6 stats-card">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Rp {{ number_format($week, 0, ',', '.') }}</h3>
                <p>Penjualan Minggu Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6 stats-card">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>Rp {{ number_format($month, 0, ',', '.') }}</h3>
                <p>Penjualan Bulan Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6 stats-card">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>Rp {{ number_format($year, 0, ',', '.') }}</h3>
                <p>Penjualan Tahun Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-pie"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <!-- Sales Trend Chart -->
    <div class="col-lg-8 chart-card mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-chart-area text-danger mr-2"></i> Tren Pendapatan Penjualan</h3>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-lg-4 chart-card mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle text-danger mr-2"></i> Ringkasan Pesanan</h3>
            </div>
            <div class="card-body">
                <div class="info-box bg-info mb-3" style="background: linear-gradient(135deg, #DC2626, #B91C1C) !important; color: white; border-radius: 12px;">
                    <span class="info-box-icon"><i class="fas fa-shopping-bag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Seluruh Pesanan</span>
                        <span class="info-box-number" style="font-size: 1.5rem;">{{ $totalOrders ?? 0 }}</span>
                    </div>
                </div>
                <div class="info-box bg-success mb-3" style="background: linear-gradient(135deg, #10B981, #059669) !important; color: white; border-radius: 12px;">
                    <span class="info-box-icon"><i class="fas fa-check-double"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pesanan Selesai</span>
                        <span class="info-box-number" style="font-size: 1.5rem;">{{ $completedOrders ?? 0 }}</span>
                    </div>
                </div>
                <div class="info-box bg-warning" style="background: linear-gradient(135deg, #F59E0B, #D97706) !important; color: white; border-radius: 12px;">
                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pesanan Menunggu / Aktif</span>
                        <span class="info-box-number" style="font-size: 1.5rem;">{{ $pendingOrders ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row">
    <div class="col-12 chart-card">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-receipt text-danger mr-2"></i> 10 Pesanan Terbaru</h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye mr-1"></i> Buka Semua Pesanan
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Meja</th>
                                <th>Nama Pelanggan</th>
                                <th>Total Tagihan</th>
                                <th>Status Pesanan</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td><strong class="text-danger">#{{ $order->id }}</strong></td>
                                <td><i class="fas fa-chair text-muted mr-1"></i> Meja {{ $order->table->table_number ?? '-' }}</td>
                                <td><strong>{{ $order->customer_name ?? 'Pelanggan' }}</strong></td>
                                <td><span class="font-weight-bold" style="color: #DC2626;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></td>
                                <td>
                                    @php
                                        $statusClass = 'status-badge-' . $order->order_status;
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td><small class="text-muted">{{ $order->created_at ? $order->created_at->diffForHumans() : '-' }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada pesanan terbaru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Sales Trend Chart (Merah Putih Theme)
const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Hari Ini', 'Minggu Ini', 'Bulan Ini', 'Tahun Ini'],
        datasets: [{
            label: 'Total Penjualan Terbayar (Rp)',
            data: [
                {{ $today }},
                {{ $week }},
                {{ $month }},
                {{ $year }}
            ],
            borderColor: '#DC2626',
            backgroundColor: 'rgba(220, 38, 38, 0.12)',
            borderWidth: 3,
            fill: true,
            tension: 0.35,
            pointBackgroundColor: '#DC2626',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 3,
            pointRadius: 6,
            pointHoverRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: {
                        family: 'Outfit',
                        size: 13,
                        weight: '600'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                titleFont: {
                    family: 'Outfit',
                    size: 13
                },
                bodyFont: {
                    family: 'Outfit',
                    size: 13,
                    weight: 'bold'
                },
                padding: 12,
                displayColors: false,
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    },
                    font: {
                        family: 'Outfit'
                    }
                },
                grid: {
                    color: 'rgba(220, 38, 38, 0.06)'
                }
            },
            x: {
                ticks: {
                    font: {
                        family: 'Outfit',
                        weight: '600'
                    }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>
@endpush
