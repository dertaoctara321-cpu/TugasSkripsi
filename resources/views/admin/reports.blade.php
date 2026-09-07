@extends('layouts.admin')

@section('title', 'Laporan Penjualan, Stok Menu & Evaluasi Pelanggan')

@section('content')
<style>
    .nav-pills .nav-link {
        font-weight: 700;
        color: #475569;
        border-radius: 10px;
        padding: 10px 20px;
        margin-right: 8px;
        background: #F1F5F9;
        transition: all 0.25s ease;
    }
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%) !important;
        color: white !important;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
    }
    .star-gold {
        color: #FFB800 !important;
    }
    @media print {
        .no-print, .nav-pills, .btn, .main-footer, .main-header, .main-sidebar {
            display: none !important;
        }
        .tab-pane {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        .card {
            border: 1px solid #000 !important;
            box-shadow: none !important;
            page-break-inside: avoid;
        }
    }
</style>

<!-- Top Navigation Tabs -->
<div class="row mb-4 no-print">
    <div class="col-12">
        <ul class="nav nav-pills" id="reportTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="sales-tab" data-toggle="pill" href="#sales-report" role="tab">
                    <i class="fas fa-chart-line mr-1"></i> Laporan Penjualan & Omzet
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="stock-tab" data-toggle="pill" href="#stock-report" role="tab">
                    <i class="fas fa-boxes mr-1"></i> Laporan Stok Menu ({{ $stockStats['total_menus'] ?? 0 }})
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="eval-tab" data-toggle="pill" href="#eval-report" role="tab">
                    <i class="fas fa-star mr-1"></i> Laporan Hasil Evaluasi Pelanggan ({{ count($allReviews) }})
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="tab-content" id="reportTabsContent">
    
    <!-- ==================== TAB 1: LAPORAN PENJUALAN ==================== -->
    <div class="tab-pane fade show active" id="sales-report" role="tabpanel">
        <div class="row mb-4">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info shadow-sm">
                    <div class="inner">
                        <h3>Rp {{ number_format($today, 0, ',', '.') }}</h3>
                        <p class="font-weight-bold">Pendapatan Hari Ini</p>
                    </div>
                    <div class="icon"><i class="fas fa-calendar-day"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success shadow-sm">
                    <div class="inner">
                        <h3>Rp {{ number_format($week, 0, ',', '.') }}</h3>
                        <p class="font-weight-bold">Pendapatan Minggu Ini</p>
                    </div>
                    <div class="icon"><i class="fas fa-calendar-week"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning shadow-sm">
                    <div class="inner">
                        <h3>Rp {{ number_format($month, 0, ',', '.') }}</h3>
                        <p class="font-weight-bold">Pendapatan Bulan Ini</p>
                    </div>
                    <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger shadow-sm">
                    <div class="inner">
                        <h3>Rp {{ number_format($year, 0, ',', '.') }}</h3>
                        <p class="font-weight-bold">Pendapatan Tahun Ini</p>
                    </div>
                    <div class="icon"><i class="fas fa-calendar"></i></div>
                </div>
            </div>
        </div>

        <div class="card card-red mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title text-white mb-0">
                    <i class="fas fa-file-invoice-dollar mr-2"></i> Riwayat Transaksi Penjualan Terbayar (Lunas)
                </h3>
                <button onclick="window.print()" class="btn btn-light btn-sm ml-auto no-print" style="color: #DC2626; font-weight: 700;">
                    <i class="fas fa-print mr-1"></i> Cetak Laporan Penjualan
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 70px;">ID</th>
                                <th>Meja & Lokasi</th>
                                <th>Pelanggan</th>
                                <th>Waiters</th>
                                <th>Total Pembayaran</th>
                                <th>Metode Bayar</th>
                                <th>Rating</th>
                                <th>Tanggal & Waktu</th>
                                <th class="text-center no-print" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($paidOrders as $order)
                            <tr>
                                <td><strong class="text-danger">#{{ $order->id }}</strong></td>
                                <td>
                                    <strong><i class="fas fa-chair text-muted mr-1"></i> Meja {{ $order->table->table_number ?? '-' }}</strong>
                                    @if($order->floor)
                                        <small class="text-muted d-block">{{ $order->floor }}</small>
                                    @endif
                                </td>
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
                                <td class="text-center no-print">
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
    </div>

    <!-- ==================== TAB 2: LAPORAN STOK MENU ==================== -->
    <div class="tab-pane fade" id="stock-report" role="tabpanel">
        
        <!-- Stock Summary Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary shadow-sm">
                    <div class="inner">
                        <h3>{{ $stockStats['total_menus'] ?? 0 }}</h3>
                        <p class="font-weight-bold">Total Varian Menu</p>
                    </div>
                    <div class="icon"><i class="fas fa-utensils"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success shadow-sm">
                    <div class="inner">
                        <h3>{{ $stockStats['safe_stock'] ?? 0 }}</h3>
                        <p class="font-weight-bold">Stok Aman (> 5 Porsi)</p>
                    </div>
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning shadow-sm">
                    <div class="inner">
                        <h3>{{ $stockStats['low_stock'] ?? 0 }}</h3>
                        <p class="font-weight-bold">Stok Menipis (≤ 5 Porsi)</p>
                    </div>
                    <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger shadow-sm">
                    <div class="inner">
                        <h3>{{ $stockStats['out_stock'] ?? 0 }}</h3>
                        <p class="font-weight-bold">Stok Habis / Kosong</p>
                    </div>
                    <div class="icon"><i class="fas fa-ban"></i></div>
                </div>
            </div>
        </div>

        <div class="card card-red mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title text-white mb-0">
                    <i class="fas fa-boxes mr-2"></i> Laporan Monitoring Stok & Penjualan Menu
                </h3>
                <div class="ml-auto no-print d-flex align-items-center">
                    <input type="text" id="stockSearchInput" class="form-control form-control-sm mr-2" placeholder="Filter nama menu..." style="width: 200px;" onkeyup="filterStockTable()">
                    <button onclick="window.print()" class="btn btn-light btn-sm font-weight-bold" style="color: #DC2626;">
                        <i class="fas fa-print mr-1"></i> Cetak Laporan Stok
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="stockReportTable">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px;">No</th>
                                <th>Nama Hidangan / Minuman</th>
                                <th>Kategori</th>
                                <th>Sub Kategori</th>
                                <th class="text-right">Harga</th>
                                <th class="text-center">Total Terjual</th>
                                <th class="text-center">Sisa Stok</th>
                                <th class="text-center">Status Stok</th>
                                <th class="text-center no-print" style="width: 90px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockReports as $index => $item)
                            <tr class="stock-row">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <strong class="stock-menu-name">{{ $item->name }}</strong>
                                </td>
                                <td><span class="badge badge-secondary">{{ $item->category }}</span></td>
                                <td><small class="text-muted">{{ $item->sub_category ?? '-' }}</small></td>
                                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-center font-weight-bold">{{ $item->total_sold }} porsi</td>
                                <td class="text-center">
                                    <span class="font-weight-bold" style="font-size: 1.05rem; color: {{ $item->stock <= 5 ? '#DC2626' : '#166534' }};">
                                        {{ $item->stock }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $item->badge_class }} px-2 py-1">
                                        @if($item->stock_status == 'Aman')
                                            <i class="fas fa-check-circle mr-1"></i> Aman
                                        @elseif($item->stock_status == 'Menipis')
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Menipis
                                        @else
                                            <i class="fas fa-times-circle mr-1"></i> Habis
                                        @endif
                                    </span>
                                </td>
                                <td class="text-center no-print">
                                    <a href="{{ route('menus.edit', $item->id) }}" class="btn btn-outline-danger btn-sm" title="Edit Stok & Menu">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    Belum ada data stok menu.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold bg-light">
                                <td colspan="5" class="text-right">TOTAL PORSI TERJUAL KESELURUHAN:</td>
                                <td class="text-center text-danger">{{ $stockStats['total_sold'] ?? 0 }} porsi</td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== TAB 3: LAPORAN EVALUASI PELANGGAN ==================== -->
    <div class="tab-pane fade" id="eval-report" role="tabpanel">
        
        <!-- Satisfaction Summary KPI -->
        <div class="row mb-4">
            <div class="col-md-4 col-sm-6 mb-2">
                <div class="p-3 bg-white rounded shadow-sm border text-center">
                    <span class="text-muted small font-weight-bold d-block">🍜 RATA-RATA RATING MAKANAN</span>
                    <h3 class="font-weight-bold mb-0 text-dark"><span class="star-gold">★</span> {{ $avgFoodRating ?? '0.0' }} <small class="text-muted">/ 5.0</small></h3>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-2">
                <div class="p-3 bg-white rounded shadow-sm border text-center">
                    <span class="text-muted small font-weight-bold d-block">🪑 RATA-RATA RATING MEJA</span>
                    <h3 class="font-weight-bold mb-0 text-dark"><span class="star-gold">★</span> {{ $avgTableRating ?? '0.0' }} <small class="text-muted">/ 5.0</small></h3>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 mb-2">
                <div class="p-3 bg-white rounded shadow-sm border text-center">
                    <span class="text-muted small font-weight-bold d-block">🤵 RATA-RATA RATING WAITERS</span>
                    <h3 class="font-weight-bold mb-0 text-dark"><span class="star-gold">★</span> {{ $avgWaiterRating ?? '0.0' }} <small class="text-muted">/ 5.0</small></h3>
                </div>
            </div>
        </div>

        <div class="card card-red mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title text-white mb-0">
                    <i class="fas fa-comments mr-2"></i> Laporan Hasil Evaluasi & Feedback Kepuasan Pelanggan ({{ count($allReviews) }} Ulasan)
                </h3>
                <button onclick="window.print()" class="btn btn-light btn-sm ml-auto no-print" style="color: #DC2626; font-weight: 700;">
                    <i class="fas fa-print mr-1"></i> Cetak Laporan Evaluasi
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Order</th>
                                <th>Meja</th>
                                <th>Pelanggan</th>
                                <th>Waiters</th>
                                <th class="text-center">Rating Makanan</th>
                                <th class="text-center">Rating Meja</th>
                                <th class="text-center">Rating Waiter</th>
                                <th>Kritik, Saran & Ulasan</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allReviews as $rev)
                            <tr>
                                <td><strong class="text-danger">#{{ $rev->order_id }}</strong></td>
                                <td>
                                    <strong>Meja {{ $rev->table->table_number ?? '-' }}</strong>
                                    @if($rev->is_favorite_table)
                                        <br><span class="badge badge-danger">❤️ Favorit</span>
                                    @endif
                                </td>
                                <td>{{ $rev->customer_name ?? 'Pelanggan' }}</td>
                                <td>
                                    @if($rev->waiter_name)
                                        <span class="badge badge-info">{{ $rev->waiter_name }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center font-weight-bold">
                                    <span class="star-gold">★</span> {{ $rev->food_rating }}/5
                                </td>
                                <td class="text-center font-weight-bold">
                                    <span class="star-gold">★</span> {{ $rev->table_rating }}/5
                                </td>
                                <td class="text-center font-weight-bold">
                                    <span class="star-gold">★</span> {{ $rev->waiter_rating ?? 5 }}/5
                                </td>
                                <td>
                                    @if($rev->review)
                                        <div><strong class="text-dark">Komentar:</strong> <span class="font-italic">"{{ $rev->review }}"</span></div>
                                    @endif
                                    @if($rev->waiter_review)
                                        <div class="mt-1"><strong class="text-danger">Untuk Pelayan:</strong> <span class="font-italic text-muted">"{{ $rev->waiter_review }}"</span></div>
                                    @endif
                                    @if(!$rev->review && !$rev->waiter_review)
                                        <span class="text-muted small fst-italic">Hanya memberikan bintang rating</span>
                                    @endif
                                </td>
                                <td><small class="text-muted">{{ $rev->created_at->format('d/m/Y H:i') }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    Belum ada data evaluasi atau ulasan dari pelanggan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
function filterStockTable() {
    const input = document.getElementById('stockSearchInput');
    const filter = input ? input.value.toLowerCase() : '';
    const rows = document.querySelectorAll('#stockReportTable .stock-row');
    
    rows.forEach(row => {
        const name = row.querySelector('.stock-menu-name')?.textContent.toLowerCase() || '';
        if (name.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endpush

@endsection
