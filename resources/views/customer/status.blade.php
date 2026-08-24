@extends('layouts.customer')

@section('title', 'Status Pesanan - Little Palembang')

@push('css')
<style>
    /* Status page animations */
    .status-header {
        animation: fadeInDown 0.6s ease-out;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .status-icon {
        animation: iconBounce 1s ease-in-out;
    }

    @keyframes iconBounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .status-icon.cooking {
        animation: flame 1.5s ease-in-out infinite;
    }

    @keyframes flame {
        0%, 100% { transform: scale(1) rotate(0deg); }
        25% { transform: scale(1.1) rotate(-5deg); }
        75% { transform: scale(1.1) rotate(5deg); }
    }

    .status-icon.completed {
        animation: celebrate 0.8s ease-out;
    }

    @keyframes celebrate {
        0% { transform: scale(0) rotate(0deg); }
        50% { transform: scale(1.3) rotate(180deg); }
        100% { transform: scale(1) rotate(360deg); }
    }

    .status-title {
        font-weight: 800;
        background: linear-gradient(135deg, #DC2626, #991B1B);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Progress timeline */
    .progress-timeline {
        position: relative;
        padding: 20px 0;
        margin: 20px 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .timeline-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        margin-bottom: 25px;
        position: relative;
        animation: slideInUp 0.6s ease-out;
        animation-fill-mode: both;
        max-width: 320px;
    }

    .timeline-item:nth-child(1) { animation-delay: 0.1s; }
    .timeline-item:nth-child(2) { animation-delay: 0.2s; }
    .timeline-item:nth-child(3) { animation-delay: 0.3s; }
    .timeline-item:nth-child(4) { animation-delay: 0.4s; }

    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .timeline-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        z-index: 2;
        transition: all 0.3s ease;
        flex-shrink: 0;
        margin-bottom: 12px;
    }

    .timeline-icon.active {
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: white;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4); }
        50% { transform: scale(1.1); box-shadow: 0 6px 20px rgba(220, 38, 38, 0.6); }
    }

    .timeline-icon.completed {
        background: linear-gradient(135deg, #10B981, #059669);
        color: white;
    }

    .timeline-icon.pending {
        background: #f0f0f0;
        color: #999;
    }

    .timeline-content {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .timeline-title {
        font-weight: 700;
        margin-bottom: 4px;
        font-size: 1.05rem;
    }

    .timeline-desc {
        font-size: 0.88rem;
        color: #64748B;
    }

    /* Delivery Alert Animation */
    .delivery-alert {
        background: linear-gradient(135deg, #FEF2F2, #FEE2E2);
        border: 2px solid #DC2626;
        animation: bounceGlow 1.5s ease-in-out infinite alternate;
    }

    @keyframes bounceGlow {
        from { box-shadow: 0 4px 15px rgba(220, 38, 38, 0.2); }
        to { box-shadow: 0 8px 25px rgba(220, 38, 38, 0.5); }
    }

    .animate-wobble {
        animation: wobble 1s ease-in-out infinite;
    }

    @keyframes wobble {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-15deg); }
        75% { transform: rotate(15deg); }
    }

    /* Thermal Receipt Look (Indomaret / Alfamart Style) */
    .thermal-receipt-wrapper {
        background: #FFFFFF;
        color: #000000;
        font-family: 'Courier New', Courier, monospace;
        padding: 16px 18px;
        border: 1px dashed #CBD5E1;
        border-radius: 4px;
        max-width: 360px;
        margin: 0 auto;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
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

    /* Star Rating Widget & Gold Star Colors */
    .star-gold, .text-gold {
        color: #FFB800 !important;
        text-shadow: 0 0 2px rgba(255, 184, 0, 0.4);
    }

    .star-rating-box {
        display: flex;
        justify-content: center;
        gap: 8px;
        font-size: 2.3rem;
        cursor: pointer;
        direction: rtl;
    }

    .star-rating-box input[type="radio"] {
        display: none;
    }

    .star-rating-box label {
        color: #CBD5E1;
        transition: all 0.2s ease;
        cursor: pointer;
        user-select: none;
    }

    .star-rating-box label:hover,
    .star-rating-box label:hover ~ label,
    .star-rating-box input[type="radio"]:checked ~ label {
        color: #FFB800 !important;
        text-shadow: 0 0 12px rgba(255, 184, 0, 0.7);
        transform: scale(1.18);
    }

    /* Print Styles (Strict 1-Page Thermal Layout) */
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
@endpush

@section('content')
<div class="text-center mb-4 page-header status-header">
    <div class="mb-3" id="mainStatusIcon">
        @if($order->order_status == 'pending')
            <i class="fas fa-clock fa-4x text-warning status-icon"></i>
        @elseif($order->order_status == 'cooking')
            <i class="fas fa-fire fa-4x text-danger status-icon cooking"></i>
        @elseif($order->order_status == 'served')
            <i class="fas fa-bell fa-4x text-danger status-icon animate-wobble"></i>
        @elseif($order->order_status == 'completed')
            <i class="fas fa-check-circle fa-4x text-success status-icon completed"></i>
        @else
            <i class="fas fa-times-circle fa-4x text-muted status-icon"></i>
        @endif
    </div>
    <h2 class="status-title" id="mainStatusTitle">Status Pesanan Anda</h2>
    <p class="lead" id="mainStatusText" style="font-weight: 700; color: {{ in_array($order->order_status, ['served', 'completed']) ? '#059669' : '#DC2626' }};">
        @if($order->order_status == 'pending')
            ⏳ Menunggu Konfirmasi Dapur
        @elseif($order->order_status == 'cooking')
            🍳 Sedang Dimasak oleh Koki
        @elseif($order->order_status == 'served')
            🛎️ Sedang Diantar ke Meja Anda!
        @elseif($order->order_status == 'completed')
            ✅ Pesanan Selesai
        @else
            {{ ucfirst($order->order_status) }}
        @endif
    </p>
</div>

<!-- Real-Time Delivery Notification Banner (Sedang Diantar) -->
<div id="deliveryAlertBanner" class="alert delivery-alert p-3 mb-4 rounded-4 shadow-sm" style="{{ $order->order_status == 'served' ? 'display: block;' : 'display: none;' }};">
    <div class="d-flex align-items-center">
        <div class="me-3 text-center" style="min-width: 50px;">
            <i class="fas fa-concierge-bell fa-2x text-danger animate-wobble"></i>
        </div>
        <div>
            <h5 class="mb-1 fw-bold text-danger">🛎️ Pesanan Anda Sedang Diantar!</h5>
            <p class="mb-0 text-dark" style="font-size: 0.92rem;">
                Pesanan sedang diantarkan oleh Waiter: <strong class="text-danger fw-bold" id="bannerWaiterName">{{ $order->waiter_name ?? 'Staf Pelayan' }}</strong> ke <strong class="text-dark">Meja {{ $order->table->table_number }}</strong> ({{ $order->floor ?? 'Lantai 1' }}). Silakan bersiap menikmati hidangan!
            </p>
        </div>
    </div>
</div>

<!-- Progress Timeline -->
<div class="row mb-4">
    <div class="col-md-10 mx-auto">
        <div class="progress-timeline">
            <!-- Step 1: Diterima -->
            <div class="timeline-item">
                <div class="timeline-icon {{ in_array($order->order_status, ['pending', 'cooking', 'served', 'completed']) ? 'completed' : 'pending' }}" id="step-icon-1">
                    <i class="fas fa-check"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-title">1. Pesanan Diterima</div>
                    <div class="timeline-desc">Pesanan masuk ke sistem kasir</div>
                </div>
            </div>

            <!-- Step 2: Dimasak -->
            <div class="timeline-item">
                <div class="timeline-icon {{ in_array($order->order_status, ['cooking', 'served', 'completed']) ? ($order->order_status == 'cooking' ? 'active' : 'completed') : 'pending' }}" id="step-icon-2">
                    <i class="fas {{ in_array($order->order_status, ['cooking', 'served', 'completed']) ? 'fa-fire' : 'fa-clock' }}"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-title">2. Sedang Dimasak</div>
                    <div class="timeline-desc">Koki sedang menyiapkan hidangan</div>
                </div>
            </div>

            <!-- Step 3: Diantar -->
            <div class="timeline-item">
                <div class="timeline-icon {{ in_array($order->order_status, ['served', 'completed']) ? ($order->order_status == 'served' ? 'active' : 'completed') : 'pending' }}" id="step-icon-3">
                    <i class="fas {{ in_array($order->order_status, ['served', 'completed']) ? 'fa-concierge-bell' : 'fa-clock' }}"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-title">3. Siap / Sedang Diantar</div>
                    <div class="timeline-desc" id="timelineWaiterDesc">
                        @if($order->waiter_name)
                            Diantar oleh: <strong>{{ $order->waiter_name }}</strong>
                        @else
                            Pelayan mengantar pesanan ke meja
                        @endif
                    </div>
                </div>
            </div>

            <!-- Step 4: Selesai -->
            <div class="timeline-item">
                <div class="timeline-icon {{ $order->order_status == 'completed' ? 'active' : 'pending' }}" id="step-icon-4">
                    <i class="fas {{ $order->order_status == 'completed' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-title">4. Selesai</div>
                    <div class="timeline-desc">Pesanan telah disajikan & selesai</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action & Receipt Card -->
<div class="row mb-4">
    <div class="col-md-8 mx-auto">
        
        <!-- Cetak Struk Button Trigger -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-bold" style="color: #991B1B;"><i class="fas fa-receipt me-1"></i> Rincian Struk Belanja</h5>
            <button type="button" onclick="printThermalReceipt()" class="btn btn-danger btn-sm px-3 fw-bold" style="border-radius: 10px;">
                <i class="fas fa-print me-1"></i> Cetak Struk (POS Thermal)
            </button>
        </div>

        <!-- Indomaret / Alfamart Style Thermal Receipt Component -->
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
                <span>Meja {{ $order->table->table_number }} ({{ $order->floor ?? 'Lantai 1' }})</span>
            </div>
            <div class="thermal-row">
                <span>Pelanggan</span>
                <span>{{ $order->customer_name ?? 'Tamu' }}</span>
            </div>
            <div class="thermal-row">
                <span>Waiters</span>
                <span id="receiptWaiterName">{{ $order->waiter_name ?? 'Staf Pelayan' }}</span>
            </div>
            <div class="thermal-row">
                <span>Kasir</span>
                <span>POS Self-Order</span>
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
                <span style="font-weight: bold; color: {{ $order->payment_status == 'paid' ? '#059669' : '#DC2626' }};">
                    {{ strtoupper($order->payment_status == 'paid' ? 'LUNAS (PAID)' : 'BELUM LUNAS') }}
                </span>
            </div>

            <div class="thermal-double-divider"></div>

            <div style="text-align: center; margin-top: 10px;">
                <div style="font-weight: bold;">TERIMA KASIH ATAS KUNJUNGANNYA</div>
                <div>SEMOGA HARI ANDA MENYENANGKAN</div>
                <div style="font-size: 11px; margin-top: 4px;">Kritik & Saran: 0812-7890-1234</div>
                <div style="font-size: 11px;">Instagram: @littlepalembang.cafe</div>
            </div>

            <div class="thermal-barcode">
                *LP{{ $order->id }}{{ $order->created_at->format('His') }}*
            </div>
        </div>

    </div>
</div>

<!-- Customer Rating & Review Section -->
<div class="row mb-5">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden" style="background: linear-gradient(to bottom, #ffffff, #FFF1F2);">
            <div class="card-header bg-danger text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-star text-warning me-2"></i> Penilaian & Ulasan Pelanggan</h5>
            </div>
            <div class="card-body p-4">
                
                @if($order->rating)
                <!-- Already Rated Display -->
                <div class="text-center py-3">
                    <div class="text-success mb-2">
                        <i class="fas fa-check-circle fa-3x"></i>
                    </div>
                    <h5 class="fw-bold text-success">Terima Kasih Atas Penilaian Anda!</h5>
                    <p class="text-muted mb-3">Ulasan Anda sangat berharga untuk peningkatan kualitas layanan Little Palembang Cafe.</p>

                    <div class="row g-3 text-start justify-content-center">
                        <div class="col-sm-6">
                            <div class="p-3 bg-white rounded-3 shadow-sm border">
                                <div class="text-muted small fw-bold">🍜 Makanan & Minuman</div>
                                <div class="fs-5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $order->rating->food_rating ? 'star-gold' : 'text-muted opacity-25' }}"></i>
                                    @endfor
                                    <span class="text-dark small fw-bold ms-1">({{ $order->rating->food_rating }}/5)</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="p-3 bg-white rounded-3 shadow-sm border">
                                <div class="text-muted small fw-bold">🪑 Kenyamanan Meja {{ $order->table->table_number }}</div>
                                <div class="fs-5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $order->rating->table_rating ? 'star-gold' : 'text-muted opacity-25' }}"></i>
                                    @endfor
                                    <span class="text-dark small fw-bold ms-1">({{ $order->rating->table_rating }}/5)</span>
                                    @if($order->rating->is_favorite_table)
                                        <span class="badge bg-danger ms-1" style="font-size: 0.7rem;">❤️ Meja Favorit</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="p-3 bg-white rounded-3 shadow-sm border">
                                <div class="text-muted small fw-bold">🤵 Pelayanan Waiters: {{ $order->rating->waiter_name ?? 'Pelayan' }}</div>
                                <div class="fs-5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= ($order->rating->waiter_rating ?? 5) ? 'star-gold' : 'text-muted opacity-25' }}"></i>
                                    @endfor
                                    <span class="text-dark small fw-bold ms-1">({{ $order->rating->waiter_rating ?? 5 }}/5)</span>
                                </div>
                                @if($order->rating->waiter_review)
                                    <div class="mt-2 text-dark fst-italic" style="font-size: 0.9rem;">
                                        "{{ $order->rating->waiter_review }}"
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($order->rating->review)
                        <div class="col-sm-12">
                            <div class="p-3 bg-white rounded-3 shadow-sm border">
                                <div class="text-muted small fw-bold">💬 Ulasan / Kritik & Saran</div>
                                <div class="text-dark fst-italic mt-1" style="font-size: 0.92rem;">
                                    "{{ $order->rating->review }}"
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                @else
                <!-- Rating Submission Form -->
                <form action="{{ route('order.rate', ['uuid' => $order->table->uuid, 'order' => $order->id]) }}" method="POST" id="ratingForm">
                    @csrf
                    
                    <p class="text-muted text-center mb-4">Bagikan pengalaman bersantap Anda di Little Palembang Cafe</p>

                    <!-- 1. Food Rating -->
                    <div class="mb-4 text-center">
                        <label class="fw-bold d-block mb-1 text-dark">1. Bagaimana Rasa Makanan & Minuman? 🍜</label>
                        <div class="star-rating-box" id="foodStars">
                            <input type="radio" id="food-5" name="food_rating" value="5" checked><label for="food-5" title="5 Bintang - Sangat Enak">★</label>
                            <input type="radio" id="food-4" name="food_rating" value="4"><label for="food-4" title="4 Bintang - Enak">★</label>
                            <input type="radio" id="food-3" name="food_rating" value="3"><label for="food-3" title="3 Bintang - Cukup">★</label>
                            <input type="radio" id="food-2" name="food_rating" value="2"><label for="food-2" title="2 Bintang - Kurang">★</label>
                            <input type="radio" id="food-1" name="food_rating" value="1"><label for="food-1" title="1 Bintang - Sangat Kurang">★</label>
                        </div>
                    </div>

                    <!-- 2. Table Rating & Favorite -->
                    <div class="mb-4 text-center p-3 rounded-3 bg-white shadow-sm border">
                        <label class="fw-bold d-block mb-1 text-dark">2. Kenyamanan Meja {{ $order->table->table_number }} ({{ $order->floor ?? 'Lantai 1' }}) 🪑</label>
                        <div class="star-rating-box" id="tableStars">
                            <input type="radio" id="table-5" name="table_rating" value="5" checked><label for="table-5" title="5 Bintang - Sangat Nyaman">★</label>
                            <input type="radio" id="table-4" name="table_rating" value="4"><label for="table-4" title="4 Bintang - Nyaman">★</label>
                            <input type="radio" id="table-3" name="table_rating" value="3"><label for="table-3" title="3 Bintang - Cukup">★</label>
                            <input type="radio" id="table-2" name="table_rating" value="2"><label for="table-2" title="2 Bintang - Kurang">★</label>
                            <input type="radio" id="table-1" name="table_rating" value="1"><label for="table-1" title="1 Bintang - Tidak Nyaman">★</label>
                        </div>
                        
                        <div class="form-check form-switch d-inline-block mt-2">
                            <input class="form-check-input" type="checkbox" name="is_favorite_table" value="1" id="isFavoriteCheck" checked style="cursor: pointer;">
                            <label class="form-check-label fw-bold text-danger" for="isFavoriteCheck" style="cursor: pointer;">
                                ❤️ Jadikan Meja {{ $order->table->table_number }} Sebagai Meja Favorit Saya
                            </label>
                        </div>
                    </div>

                    <!-- 3. Waiter Rating & Comment -->
                    <div class="mb-4 text-center p-3 rounded-3 bg-white shadow-sm border">
                        <label class="fw-bold d-block mb-1 text-dark">
                            3. Pelayanan Waiters (<span id="ratingWaiterLabel">{{ $order->waiter_name ?? 'Pelayan' }}</span>) 🤵
                        </label>
                        <div class="star-rating-box" id="waiterStars">
                            <input type="radio" id="waiter-5" name="waiter_rating" value="5" checked><label for="waiter-5" title="5 Bintang - Sangat Ramah & Cepat">★</label>
                            <input type="radio" id="waiter-4" name="waiter_rating" value="4"><label for="waiter-4" title="4 Bintang - Ramah">★</label>
                            <input type="radio" id="waiter-3" name="waiter_rating" value="3"><label for="waiter-3" title="3 Bintang - Cukup">★</label>
                            <input type="radio" id="waiter-2" name="waiter_rating" value="2"><label for="waiter-2" title="2 Bintang - Kurang">★</label>
                            <input type="radio" id="waiter-1" name="waiter_rating" value="1"><label for="waiter-1" title="1 Bintang - Tidak Ramah">★</label>
                        </div>
                        <input type="text" name="waiter_review" class="form-control form-control-sm mt-2" placeholder="Tulis pujian atau catatan untuk Waiter ini (opsional)...">
                    </div>

                    <!-- 4. General Review -->
                    <div class="mb-4">
                        <label class="fw-bold text-dark mb-1">Kritik, Saran, atau Ulasan Umum:</label>
                        <textarea name="review" class="form-control" rows="3" placeholder="Ceritakan pengalaman Anda bersantap di Little Palembang Cafe..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-danger w-100 py-2 fw-bold rounded-3 shadow-sm" style="font-size: 1.05rem;">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Penilaian & Ulasan
                    </button>
                </form>
                @endif

            </div>
        </div>

        <div class="d-grid gap-2 mt-3 no-print">
            <a href="{{ route('order.index', $order->table->uuid) }}" class="btn btn-outline-secondary py-2" style="border-radius: 10px;">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Katalog Menu
            </a>
        </div>

    </div>
</div>

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

// Audio chime alert using Web Audio API
function playChime() {
    try {
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        if (!AudioContext) return;
        const ctx = new AudioContext();
        
        const now = ctx.currentTime;
        const osc1 = ctx.createOscillator();
        const osc2 = ctx.createOscillator();
        const gain = ctx.createGain();

        osc1.type = 'sine';
        osc1.frequency.setValueAtTime(587.33, now); // D5
        osc1.frequency.setValueAtTime(880, now + 0.15); // A5

        osc2.type = 'triangle';
        osc2.frequency.setValueAtTime(880, now);
        osc2.frequency.setValueAtTime(1174.66, now + 0.15); // D6

        gain.gain.setValueAtTime(0.3, now);
        gain.gain.exponentialRampToValueAtTime(0.001, now + 1.2);

        osc1.connect(gain);
        osc2.connect(gain);
        gain.connect(ctx.destination);

        osc1.start(now);
        osc2.start(now);
        osc1.stop(now + 1.2);
        osc2.stop(now + 1.2);
    } catch(e) {
        console.log('Audio chime error:', e);
    }
}

// Live polling status
let currentOrderStatus = "{{ $order->order_status }}";
const orderCheckUrl = "{{ route('order.checkStatus', ['uuid' => $order->table->uuid, 'order' => $order->id]) }}";

function checkLiveStatus() {
    fetch(orderCheckUrl, {
        headers: { 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (!data || !data.order_status) return;

        if (data.waiter_name) {
            const bwn = document.getElementById('bannerWaiterName');
            const rwn = document.getElementById('receiptWaiterName');
            const rwl = document.getElementById('ratingWaiterLabel');
            const twd = document.getElementById('timelineWaiterDesc');

            if (bwn) bwn.textContent = data.waiter_name;
            if (rwn) rwn.textContent = data.waiter_name;
            if (rwl) rwl.textContent = data.waiter_name;
            if (twd) twd.innerHTML = 'Diantar oleh: <strong>' + data.waiter_name + '</strong>';
        }

        // If status changed to served
        if (data.order_status === 'served' && currentOrderStatus !== 'served') {
            currentOrderStatus = 'served';
            playChime();
            
            // Show alert banner
            const banner = document.getElementById('deliveryAlertBanner');
            if (banner) banner.style.display = 'block';

            // Update main status text & icon
            const text = document.getElementById('mainStatusText');
            if (text) {
                text.textContent = '🛎️ Sedang Diantar ke Meja Anda!';
                text.style.color = '#059669';
            }

            const icon = document.getElementById('mainStatusIcon');
            if (icon) {
                icon.innerHTML = '<i class="fas fa-bell fa-4x text-danger status-icon animate-wobble"></i>';
            }

            // Update timeline
            const s2 = document.getElementById('step-icon-2');
            const s3 = document.getElementById('step-icon-3');
            if (s2) s2.className = 'timeline-icon completed';
            if (s3) s3.className = 'timeline-icon active';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'info',
                    title: '🛎️ Pesanan Sedang Diantar!',
                    html: 'Pesanan Anda sedang diantarkan oleh <b>' + (data.waiter_name || 'Waiters') + '</b> ke meja Anda. Selamat menikmati!',
                    confirmButtonColor: '#DC2626',
                    confirmButtonText: 'Baik, Terima Kasih!'
                });
            }
        } else if (data.order_status === 'completed' && currentOrderStatus !== 'completed') {
            currentOrderStatus = 'completed';
            
            const text = document.getElementById('mainStatusText');
            if (text) {
                text.textContent = '✅ Pesanan Selesai';
                text.style.color = '#059669';
            }

            const icon = document.getElementById('mainStatusIcon');
            if (icon) {
                icon.innerHTML = '<i class="fas fa-check-circle fa-4x text-success status-icon completed"></i>';
            }

            const s3 = document.getElementById('step-icon-3');
            const s4 = document.getElementById('step-icon-4');
            if (s3) s3.className = 'timeline-icon completed';
            if (s4) s4.className = 'timeline-icon active';
        }
    })
    .catch(err => console.log('Polling check error:', err));
}

// Poll every 3.5 seconds
setInterval(checkLiveStatus, 3500);
</script>
@endpush
@endsection
