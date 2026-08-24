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
        font-size: 1.05rem;
        padding: 10px 12px;
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

    /* Thermal Receipt for printing */
    .thermal-receipt-wrapper {
        background: #ffffff;
        color: #000000;
        font-family: 'Courier New', Courier, monospace;
        padding: 16px 18px;
        border: 1px dashed #CBD5E1;
        border-radius: 4px;
        max-width: 360px;
        margin: 0 auto;
        line-height: 1.3;
        font-size: 12.5px;
    }

    .thermal-header {
        text-align: center;
        margin-bottom: 8px;
    }

    .thermal-title {
        font-size: 15px;
        font-weight: 900;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .thermal-divider {
        border-top: 1px dashed #000000;
        margin: 6px 0;
    }

    .thermal-double-divider {
        border-top: 2px double #000000;
        margin: 6px 0;
    }

    .thermal-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2px;
    }

    .thermal-barcode {
        text-align: center;
        margin-top: 10px;
        letter-spacing: 3px;
        font-size: 14px;
        font-weight: bold;
    }

    @media print {
        @page {
            size: auto;
            margin: 0mm;
        }
        
        html, body {
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }

        body * {
            visibility: hidden !important;
        }
        
        #thermalReceiptToPrint, #thermalReceiptToPrint * {
            visibility: visible !important;
        }

        #thermalReceiptToPrint {
            display: block !important;
            position: absolute !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            top: 0 !important;
            width: 100% !important;
            max-width: 78mm !important;
            margin: 0 auto !important;
            padding: 8px 10px !important;
            border: none !important;
            box-shadow: none !important;
            color: #000000 !important;
            background: #ffffff !important;
            font-family: 'Courier New', Courier, monospace !important;
            font-size: 11.5px !important;
            line-height: 1.25 !important;
            page-break-after: avoid !important;
            page-break-inside: avoid !important;
        }
    }
</style>

<div class="row order-details-wrapper">
    <!-- Order Items - Left Side -->
    <div class="col-lg-8 mb-4">
        <div class="card card-red mb-4">
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
                                            <img src="/images/{{ $item->menu->image }}" alt="{{ $item->menu->name }}" class="rounded mr-3" style="width: 50px; height: 50px; object-fit: cover; border: 1px solid #E2E8F0;">
                                        @endif
                                        <div>
                                            <strong class="d-block" style="font-size: 1.05rem;">{{ $item->menu->name ?? 'Menu tidak ditemukan' }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center font-weight-bold" style="font-size: 1.1rem;">{{ $item->quantity }}x</td>
                                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-right font-weight-bold" style="color: #DC2626;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
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
                    <button type="button" onclick="printThermalReceipt()" class="btn btn-danger btn-sm font-weight-bold">
                        <i class="fas fa-print mr-1"></i> Cetak Struk POS (Thermal Indomaret/Alfa)
                    </button>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm ml-2">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>

        <!-- Customer Rating & Review Details (If Reviewed) -->
        @if($order->rating)
        <div class="card card-outline card-warning">
            <div class="card-header bg-warning text-dark font-weight-bold">
                <i class="fas fa-star mr-2"></i> Ulasan & Penilaian dari Pelanggan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-light rounded text-center border">
                            <span class="text-muted small d-block font-weight-bold">🍜 Makanan & Minuman</span>
                            <span class="h4 mb-0 font-weight-bold"><span class="star-gold">★</span> {{ $order->rating->food_rating }}/5</span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-light rounded text-center border">
                            <span class="text-muted small d-block font-weight-bold">🪑 Kenyamanan Meja</span>
                            <span class="h4 mb-0 font-weight-bold"><span class="star-gold">★</span> {{ $order->rating->table_rating }}/5</span>
                            @if($order->rating->is_favorite_table)
                                <br><span class="badge badge-danger mt-1">❤️ Meja Terfavorit</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="p-3 bg-light rounded text-center border">
                            <span class="text-muted small d-block font-weight-bold">🤵 Pelayanan Waiters</span>
                            <span class="h4 mb-0 font-weight-bold"><span class="star-gold">★</span> {{ $order->rating->waiter_rating ?? 5 }}/5</span>
                            <small class="d-block text-muted">({{ $order->rating->waiter_name ?? 'Pelayan' }})</small>
                        </div>
                    </div>
                </div>

                @if($order->rating->waiter_review)
                <div class="alert alert-info py-2 mb-2">
                    <strong><i class="fas fa-comment-dots mr-1"></i> Ulasan untuk Waiters ({{ $order->rating->waiter_name ?? 'Pelayan' }}):</strong>
                    <p class="mb-0 font-italic text-dark">"{{ $order->rating->waiter_review }}"</p>
                </div>
                @endif

                @if($order->rating->review)
                <div class="alert alert-secondary py-2 mb-0">
                    <strong><i class="fas fa-quote-left mr-1"></i> Ulasan Umum Pelanggan:</strong>
                    <p class="mb-0 font-italic text-dark">"{{ $order->rating->review }}"</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Hidden Thermal Receipt format for printing -->
        <div style="display: none;">
            <div class="thermal-receipt-wrapper" id="thermalReceiptToPrint">
                <div class="thermal-header">
                    <div class="thermal-title">LITTLE PALEMBANG CAFE</div>
                    <div>Spesialis Pempek & Kuliner Nusantara</div>
                    <div>Jl. Demang Lebar Daun No. 45, Palembang</div>
                    <div>Telp/WA: 0812-7890-1234</div>
                </div>

                <div class="thermal-double-divider"></div>

                <div class="thermal-row">
                    <span>No. Nota</span>
                    <span>#LP-{{ $order->created_at->format('Ymd') }}-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="thermal-row">
                    <span>Waktu</span>
                    <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="thermal-row">
                    <span>Meja / Lantai</span>
                    <span>Meja {{ $order->table->table_number ?? '-' }} ({{ $order->floor ?? 'Lantai 1' }})</span>
                </div>
                <div class="thermal-row">
                    <span>Pelanggan</span>
                    <span>{{ $order->customer_name ?? 'Tamu' }}</span>
                </div>
                <div class="thermal-row">
                    <span>Waitress</span>
                    <span>{{ $order->waiter_name ?? 'Staf Pelayan' }}</span>
                </div>
                <div class="thermal-row">
                    <span>Kasir</span>
                    <span>{{ Auth::user()->name ?? 'Kasir POS' }}</span>
                </div>

                <div class="thermal-divider"></div>
                
                <div class="thermal-row" style="font-weight: bold;">
                    <span>ITEM MENU</span>
                    <span>TOTAL (RP)</span>
                </div>
                
                <div class="thermal-divider"></div>

                @foreach($order->items as $item)
                <div style="margin-bottom: 4px;">
                    <div style="font-weight: bold;">{{ strtoupper($item->menu->name ?? 'Menu') }}</div>
                    <div class="thermal-row" style="padding-left: 8px;">
                        <span>{{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }}</span>
                        <span>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach

                <div class="thermal-divider"></div>

                <div class="thermal-row">
                    <span>Total Item (Qty)</span>
                    <span>{{ $order->items->sum('quantity') }}</span>
                </div>
                <div class="thermal-row">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="thermal-row">
                    <span>Diskon</span>
                    <span>Rp 0</span>
                </div>
                <div class="thermal-row" style="font-weight: bold; font-size: 14px;">
                    <span>TOTAL AKHIR</span>
                    <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="thermal-row">
                    <span>Metode Pembayaran</span>
                    <span>{{ $order->payment_method ?? 'Cash' }}</span>
                </div>
                <div class="thermal-row">
                    <span>Status Pembayaran</span>
                    <span style="font-weight: bold;">{{ strtoupper($order->payment_status == 'paid' ? 'LUNAS (PAID)' : 'BELUM LUNAS') }}</span>
                </div>

                <div class="thermal-double-divider"></div>

                <div style="text-align: center; margin-top: 10px;">
                    <div style="font-weight: bold;">TERIMA KASIH ATAS KUNJUNGANNYA</div>
                    <div>SEMOGA HARI ANDA MENYENANGKAN</div>
                    <div style="font-size: 11px; margin-top: 4px;">Kritik & Saran: 0812-7890-1234</div>
                </div>

                <div class="thermal-barcode">
                    *LP{{ $order->id }}{{ $order->created_at->format('His') }}*
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
                    <span class="info-label"><i class="fas fa-user-tie mr-1"></i> Waitress / Pelayan</span>
                    <span class="info-value text-danger">
                        {{ $order->waiter_name ?? 'Belum Ditugaskan' }}
                    </span>
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

                <!-- 1. Dapur / Admin: Ubah Status Masak & Sajian + Pilih Waiter -->
                @if(Auth::user()->isAdmin() || Auth::user()->isDapur())
                <div class="mb-3">
                    <label class="info-label font-weight-bold text-danger"><i class="fas fa-fire mr-1"></i> Update Status & Tugaskan Waiters</label>
                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-muted mb-1">Status Pengerjaan:</label>
                            <select name="order_status" class="form-control status-select" required>
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>⏳ Menunggu (Pending)</option>
                                <option value="cooking" {{ $order->order_status == 'cooking' ? 'selected' : '' }}>🍳 Sedang Dimasak (Cooking)</option>
                                <option value="served" {{ $order->order_status == 'served' ? 'selected' : '' }}>🛎️ Dihidangkan / Diantar (Served)</option>
                                <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>✅ Selesai (Completed)</option>
                                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>❌ Batalkan Pesanan</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-user-check mr-1"></i> Nama Waiters Pengantar:</label>
                            <select name="waiter_name" class="form-control font-weight-bold" style="font-size: 0.95rem; border: 2px solid #CBD5E1;">
                                <option value="">-- Pilih Nama Waiters --</option>
                                @foreach(\App\Models\Order::WAITERS as $waiter)
                                    <option value="{{ $waiter }}" {{ (old('waiter_name', $order->waiter_name) == $waiter) ? 'selected' : '' }}>
                                        🤵 {{ $waiter }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted font-italic">Nama waiters akan tampil pada notifikasi layar & struk pelanggan.</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block font-weight-bold">
                            <i class="fas fa-sync-alt mr-1"></i> Simpan Status & Waiter
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

@push('js')
<script>
function printThermalReceipt() {
    const receiptEl = document.getElementById('thermalReceiptToPrint');
    if (!receiptEl) {
        window.print();
        return;
    }

    let iframe = document.getElementById('receiptPrintIframe');
    if (!iframe) {
        iframe = document.createElement('iframe');
        iframe.id = 'receiptPrintIframe';
        iframe.style.position = 'fixed';
        iframe.style.right = '0';
        iframe.style.bottom = '0';
        iframe.style.width = '0';
        iframe.style.height = '0';
        iframe.style.border = '0';
        iframe.style.visibility = 'hidden';
        document.body.appendChild(iframe);
    }

    const receiptHtml = receiptEl.innerHTML;
    const doc = iframe.contentWindow.document;
    doc.open();
    doc.write(`
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="utf-8">
            <title>Struk Belanja - Little Palembang</title>
            <style>
                @page {
                    size: 80mm auto;
                    margin: 0mm;
                }
                * {
                    box-sizing: border-box;
                    margin: 0;
                    padding: 0;
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
                html, body {
                    background: #ffffff !important;
                    color: #000000 !important;
                    font-family: 'Courier New', Courier, monospace !important;
                    font-size: 11.5px !important;
                    line-height: 1.28 !important;
                    width: 100% !important;
                    max-width: 76mm !important;
                    margin: 0 auto !important;
                    padding: 4px 6px !important;
                }
                .thermal-header {
                    text-align: center;
                    margin-bottom: 6px;
                }
                .thermal-title {
                    font-size: 14px;
                    font-weight: 900;
                    letter-spacing: 0.5px;
                    margin-bottom: 2px;
                }
                .thermal-divider {
                    border-top: 1px dashed #000000;
                    margin: 5px 0;
                }
                .thermal-double-divider {
                    border-top: 2px double #000000;
                    margin: 5px 0;
                }
                .thermal-row {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 2px;
                    font-size: 11px;
                }
                .thermal-barcode {
                    text-align: center;
                    margin-top: 8px;
                    letter-spacing: 3px;
                    font-size: 13px;
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <div>\${receiptHtml}</div>
        </body>
        </html>
    `);
    doc.close();

    setTimeout(() => {
        iframe.contentWindow.focus();
        iframe.contentWindow.print();
    }, 250);
}
</script>
@endpush
