@extends('layouts.admin')

@section('title', 'Laporan Penjualan (Owner & Admin)')

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

<div class="card card-red">
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
                        <th>Total Pembayaran</th>
                        <th>Metode Bayar</th>
                        <th>Tanggal & Waktu Transaksi</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paidOrders as $order)
                    <tr>
                        <td><strong class="text-danger">#{{ $order->id }}</strong></td>
                        <td><strong><i class="fas fa-chair text-muted mr-1"></i> Meja {{ $order->table->table_number ?? '-' }}</strong></td>
                        <td>{{ $order->customer_name ?? 'Pelanggan' }}</td>
                        <td><strong style="color: #DC2626;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                        <td>
                            <span class="badge badge-secondary">
                                <i class="fas fa-wallet mr-1"></i> {{ $order->payment_method ?? 'Cash' }}
                            </span>
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
                        <td colspan="7" class="text-center py-4 text-muted">
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
@endsection
