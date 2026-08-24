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
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
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

<!-- Statistics Cards (Omzet Penjualan) -->
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

<!-- Customer Satisfaction & Rating Overview Cards -->
<div class="row">
    <div class="col-md-4 col-sm-6 mb-3">
        <div class="card bg-white shadow-sm border-0" style="border-left: 5px solid #DC2626 !important; border-radius: 12px;">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted font-weight-bold">🍜 RATING MAKANAN</small>
                        <h3 class="mb-0 font-weight-bold"><span class="star-gold">★</span> {{ $avgFoodRating ?? '5.0' }} <small class="text-muted" style="font-size: 0.9rem;">/ 5.0</small></h3>
                    </div>
                    <div class="bg-danger text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fas fa-utensils"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-6 mb-3">
        <div class="card bg-white shadow-sm border-0" style="border-left: 5px solid #F59E0B !important; border-radius: 12px;">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted font-weight-bold">🪑 RATING KENYAMANAN MEJA</small>
                        <h3 class="mb-0 font-weight-bold"><span class="star-gold">★</span> {{ $avgTableRating ?? '5.0' }} <small class="text-muted" style="font-size: 0.9rem;">/ 5.0</small></h3>
                    </div>
                    <div class="bg-warning text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fas fa-chair"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-12 mb-3">
        <div class="card bg-white shadow-sm border-0" style="border-left: 5px solid #10B981 !important; border-radius: 12px;">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted font-weight-bold">🤵 RATING PELAYANAN WAITERS</small>
                        <h3 class="mb-0 font-weight-bold"><span class="star-gold">★</span> {{ $avgWaiterRating ?? '5.0' }} <small class="text-muted" style="font-size: 0.9rem;">/ 5.0</small></h3>
                    </div>
                    <div class="bg-success text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts & Quick Stats Row -->
<div class="row">
    <!-- Sales Trend Chart -->
    <div class="col-lg-8 chart-card mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold"><i class="fas fa-chart-area text-danger mr-2"></i> Tren Pendapatan Penjualan</h3>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Order Stats -->
    <div class="col-lg-4 chart-card mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-info-circle text-danger mr-2"></i> Ringkasan Operasional</h3>
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
                    <span class="info-box-icon"><i class="fas fa-comments"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Ulasan Pelanggan</span>
                        <span class="info-box-number" style="font-size: 1.5rem;">{{ $totalRatings ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top Favorite Tables & Waiters Leaderboard Row -->
<div class="row">
    <!-- Top 3 Meja Terfavorit -->
    <div class="col-lg-6 chart-card mb-4">
        <div class="card h-100">
            <div class="card-header bg-warning text-dark font-weight-bold d-flex justify-content-between align-items-center">
                <span class="card-title mb-0"><i class="fas fa-trophy text-danger mr-2"></i> 🏆 Top Meja Terfavorit Pelanggan</span>
                <a href="{{ route('tables.index') }}" class="btn btn-xs btn-outline-dark font-weight-bold">Lihat Semua Meja</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($topTables ?? [] as $index => $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div class="d-flex align-items-center">
                            <span class="badge badge-pill badge-{{ $index == 0 ? 'danger' : ($index == 1 ? 'warning' : 'secondary') }} mr-3" style="font-size: 1rem; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                #{{ $index + 1 }}
                            </span>
                            <div>
                                <strong class="d-block font-weight-bold" style="font-size: 1.05rem;">Meja {{ $item['table_number'] }}</strong>
                                <small class="text-muted">{{ $item['rating_count'] }} ulasan • {{ $item['fav_count'] }} memfavoritkan</small>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="badge badge-light border font-weight-bold p-2" style="font-size: 0.95rem;">
                                <span class="star-gold">★</span> {{ $item['avg_rating'] }}/5.0
                            </span>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted">
                        Belum ada ulasan rating meja dari pelanggan.
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Waiters Performance Leaderboard -->
    <div class="col-lg-6 chart-card mb-4">
        <div class="card h-100">
            <div class="card-header bg-success text-white font-weight-bold">
                <span class="card-title mb-0"><i class="fas fa-medal mr-2"></i> 🤵 Leaderboard Kinerja Waiters</span>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($waiterLeaderboard ?? [] as $index => $waiter)
                    <li class="list-group-item py-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-pill badge-light border mr-2 font-weight-bold">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <strong style="font-size: 1.05rem;" class="text-dark">{{ $waiter['name'] }}</strong>
                                    <small class="text-muted ml-2">({{ $waiter['total_served'] }} pesanan dilayani)</small>
                                </div>
                            </div>
                            <span class="badge badge-light border p-2 font-weight-bold">
                                <span class="star-gold">★</span> {{ $waiter['avg_rating'] }}/5.0
                            </span>
                        </div>
                        @if($waiter['latest_comment'])
                            <small class="text-muted font-italic d-block mt-1 pl-4">
                                <i class="fas fa-quote-left mr-1"></i> "{{ $waiter['latest_comment'] }}"
                            </small>
                        @endif
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted">
                        Belum ada data ulasan khusus pelayan/waiters.
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Recent Reviews -->
<div class="row">
    <!-- Recent Orders -->
    <div class="col-lg-7 chart-card mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold"><i class="fas fa-receipt text-danger mr-2"></i> 10 Pesanan Terbaru</h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye mr-1"></i> Buka Semua
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
                                <th>Pelanggan</th>
                                <th>Waiters</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td><strong class="text-danger">#{{ $order->id }}</strong></td>
                                <td>Meja {{ $order->table->table_number ?? '-' }}</td>
                                <td>{{ $order->customer_name ?? 'Tamu' }}</td>
                                <td><small class="badge badge-light border">{{ $order->waiter_name ?? '-' }}</small></td>
                                <td><strong style="color: #DC2626;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                                <td>
                                    @php $statusClass = 'status-badge-' . $order->order_status; @endphp
                                    <span class="badge {{ $statusClass }}">{{ ucfirst($order->order_status) }}</span>
                                </td>
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

    <!-- Recent Customer Feedback -->
    <div class="col-lg-5 chart-card mb-4">
        <div class="card h-100">
            <div class="card-header bg-danger text-white font-weight-bold">
                <span class="card-title mb-0"><i class="fas fa-comment-alt mr-2"></i> Ulasan Terbaru Pelanggan</span>
            </div>
            <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                <ul class="list-group list-group-flush">
                    @forelse($recentReviews ?? [] as $rev)
                    <li class="list-group-item p-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong>{{ $rev->customer_name ?? 'Pelanggan' }} <small class="text-muted">(Meja {{ $rev->table->table_number ?? '-' }})</small></strong>
                            <span class="font-weight-bold"><span class="star-gold">★</span> {{ $rev->food_rating }}/5</span>
                        </div>
                        @if($rev->review)
                            <p class="mb-1 text-dark small font-italic">"{{ $rev->review }}"</p>
                        @endif
                        @if($rev->waiter_name && $rev->waiter_review)
                            <small class="text-danger d-block font-italic">Waiters ({{ $rev->waiter_name }}): "{{ $rev->waiter_review }}"</small>
                        @endif
                        <small class="text-muted" style="font-size: 0.75rem;">{{ $rev->created_at->diffForHumans() }}</small>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted">
                        Belum ada ulasan yang masuk.
                    </li>
                    @endforelse
                </ul>
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
