@extends('layouts.admin')

@section('title', 'Laporan Penjualan & Kepuasan Pelanggan')

@section('content')
<div class="row mb-4">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Rp {{ number_format($today, 0, ',', '.') }}</h3>
                <p>Pendapatan Hari Ini</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-day"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Rp {{ number_format($week, 0, ',', '.') }}</h3>
                <p>Pendapatan Minggu Ini</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-week"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>Rp {{ number_format($month, 0, ',', '.') }}</h3>
                <p>Pendapatan Bulan Ini</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>Rp {{ number_format($year, 0, ',', '.') }}</h3>
                <p>Pendapatan Tahun Ini</p>
            </div>
            <div class="icon"><i class="fas fa-calendar"></i></div>
        </div>
    </div>
</div>

<!-- Satisfaction Summary -->
<div class="row mb-4">
    <div class="col-md-4 col-sm-6 mb-2">
        <div class="p-3 bg-white rounded shadow-sm border text-center">
            <span class="text-muted small font-weight-bold d-block">🍜 RATA-RATA RATING MAKANAN</span>
            <h4 class="font-weight-bold mb-0"><span class="star-gold">★</span> {{ $avgFoodRating ?? '5.0' }} / 5.0</h4>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 mb-2">
        <div class="p-3 bg-white rounded shadow-sm border text-center">
            <span class="text-muted small font-weight-bold d-block">🪑 RATA-RATA RATING MEJA</span>
            <h4 class="font-weight-bold mb-0"><span class="star-gold">★</span> {{ $avgTableRating ?? '5.0' }} / 5.0</h4>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 mb-2">
        <div class="p-3 bg-white rounded shadow-sm border text-center">
            <span class="text-muted small font-weight-bold d-block">🤵 RATA-RATA RATING WAITERS</span>
            <h4 class="font-weight-bold mb-0"><span class="star-gold">★</span> {{ $avgWaiterRating ?? '5.0' }} / 5.0</h4>
        </div>
    </div>
</div>

<div class="card card-red mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title text-white mb-0">
            <i class="fas fa-file-invoice-dollar mr-2"></i> Riwayat Transaksi Penjualan Terbayar (Lunas)
        </h3>
        <button onclick="window.print()" class="btn btn-light btn-sm ml-auto" style="color: #DC2626; font-weight: 700;">
            <i class="fas fa-print mr-1"></i> Cetak Laporan
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 70px;">ID</th>
                        <th>Meja</th>
                        <th>Pelanggan</th>
                        <th>Waiters</th>
                        <th>Total Pembayaran</th>
                        <th>Metode Bayar</th>
                        <th>Rating Pelanggan</th>
                        <th>Tanggal & Waktu</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paidOrders as $order)
                    <tr>
                        <td><strong class="text-danger">#{{ $order->id }}</strong></td>
                        <td><strong><i class="fas fa-chair text-muted mr-1"></i> Meja {{ $order->table->table_number ?? '-' }}</strong></td>
                        <td>{{ $order->customer_name ?? 'Pelanggan' }}</td>
                        <td>
                            @if($order->waiter_name)
                                <span class="badge badge-info">{{ $order->waiter_name }}</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td><strong style="color: #DC2626;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                        <td>
                            <span class="badge badge-secondary">
                                <i class="fas fa-wallet mr-1"></i> {{ $order->payment_method ?? 'Cash' }}
                            </span>
                        </td>
                        <td>
                            @if($order->rating)
                                <span class="badge badge-light border font-weight-bold">
                                    <span class="star-gold">★</span> {{ $order->rating->food_rating }}/5
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            <i class="fas fa-receipt fa-2x mb-2 d-block"></i>
                            Belum ada riwayat transaksi penjualan terbayar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Customer Review Log Section -->
@if(isset($allReviews) && count($allReviews) > 0)
<div class="card card-outline card-warning">
    <div class="card-header bg-warning text-dark font-weight-bold">
        <i class="fas fa-star mr-1"></i> Log Ulasan & Masukan Pelanggan ({{ count($allReviews) }} Ulasan)
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Meja</th>
                        <th>Pelanggan</th>
                        <th>Waiters</th>
                        <th>R. Makanan</th>
                        <th>R. Meja</th>
                        <th>R. Waiter</th>
                        <th>Ulasan / Catatan</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allReviews as $rev)
                    <tr>
                        <td><strong>#{{ $rev->order_id }}</strong></td>
                        <td>Meja {{ $rev->table->table_number ?? '-' }}</td>
                        <td>{{ $rev->customer_name ?? 'Pelanggan' }}</td>
                        <td>{{ $rev->waiter_name ?? '-' }}</td>
                        <td><span class="font-weight-bold"><span class="star-gold">★</span> {{ $rev->food_rating }}</span></td>
                        <td>
                            <span class="font-weight-bold"><span class="star-gold">★</span> {{ $rev->table_rating }}</span>
                            @if($rev->is_favorite_table)
                                <small class="badge badge-danger">Favorit</small>
                            @endif
                        </td>
                        <td><span class="font-weight-bold"><span class="star-gold">★</span> {{ $rev->waiter_rating ?? 5 }}</span></td>
                        <td>
                            @if($rev->review)
                                <div><small class="text-dark font-italic">"{{ $rev->review }}"</small></div>
                            @endif
                            @if($rev->waiter_review)
                                <div><small class="text-danger font-italic">Waiters: "{{ $rev->waiter_review }}"</small></div>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $rev->created_at->format('d/m/Y H:i') }}</small></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@endsection
