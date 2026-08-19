@extends('layouts.customer')

@section('title', 'Status Pesanan - Little Palembang')

@push('css')
<style>
    /* Status page animations */
    .status-header {
        animation: fadeInDown 0.6s ease-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .status-icon {
        animation: iconBounce 1s ease-in-out;
    }

    @keyframes iconBounce {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    .status-icon.cooking {
        animation: flame 1.5s ease-in-out infinite;
    }

    @keyframes flame {
        0%, 100% {
            transform: scale(1) rotate(0deg);
        }
        25% {
            transform: scale(1.1) rotate(-5deg);
        }
        75% {
            transform: scale(1.1) rotate(5deg);
        }
    }

    .status-icon.completed {
        animation: celebrate 0.8s ease-out;
    }

    @keyframes celebrate {
        0% {
            transform: scale(0) rotate(0deg);
        }
        50% {
            transform: scale(1.3) rotate(180deg);
        }
        100% {
            transform: scale(1) rotate(360deg);
        }
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
        padding: 30px 0;
        margin: 30px 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .timeline-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        margin-bottom: 30px;
        position: relative;
        animation: slideInUp 0.6s ease-out;
        animation-fill-mode: both;
        max-width: 300px;
    }

    .timeline-item:nth-child(1) { animation-delay: 0.1s; }
    .timeline-item:nth-child(2) { animation-delay: 0.2s; }
    .timeline-item:nth-child(3) { animation-delay: 0.3s; }
    .timeline-item:nth-child(4) { animation-delay: 0.4s; }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
        margin-bottom: 15px;
    }

    .timeline-icon.active {
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: white;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
        }
        50% {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.6);
        }
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
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 1.1rem;
    }

    .timeline-desc {
        font-size: 0.9rem;
        color: #666;
    }

    body.dark-mode .timeline-desc {
        color: #B0B0B0;
    }

    /* Receipt card */
    .receipt-card {
        animation: fadeInUp 0.6s ease-out;
        border-radius: 16px;
        border: 2px solid #DC2626;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .receipt-card .card-title {
        font-weight: 800;
        background: linear-gradient(135deg, #DC2626, #991B1B);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .total-amount {
        font-size: 1.3rem;
        font-weight: 800;
        color: #DC2626 !important;
    }

    /* Fix dark mode table visibility - FORCE DARK BACKGROUND */
    body.dark-mode .card {
        background-color: #2D2D2D !important;
    }

    body.dark-mode .table {
        color: #F7F7F7 !important;
        background-color: #2D2D2D !important;
        --bs-table-bg: #2D2D2D !important;
        --bs-table-striped-bg: #2D2D2D !important;
        --bs-table-active-bg: #2D2D2D !important;
        --bs-table-hover-bg: #333 !important;
    }

    body.dark-mode .table th,
    body.dark-mode .table td {
        color: #F7F7F7 !important;
        background-color: #2D2D2D !important;
        border-color: #000 !important;
    }

    body.dark-mode .table thead th {
        color: #F7F7F7 !important;
        background-color: #2D2D2D !important;
        border-color: #000 !important;
    }

    body.dark-mode .table tbody tr {
        background-color: #2D2D2D !important;
    }

    body.dark-mode .table tbody td,
    body.dark-mode .table tbody th {
        color: #F7F7F7 !important;
        background-color: #2D2D2D !important;
        border-color: #000 !important;
    }

    body.dark-mode .table tfoot th,
    body.dark-mode .table tfoot td {
        color: #F7F7F7 !important;
        background-color: #2D2D2D !important;
        border-color: #000 !important;
    }

    body.dark-mode .table-bordered {
        border-color: #000 !important;
    }

    body.dark-mode .table-bordered th,
    body.dark-mode .table-bordered td {
        border-color: #000 !important;
    }

    body.dark-mode .table-sm th,
    body.dark-mode .table-sm td {
        color: #F7F7F7 !important;
        background-color: #2D2D2D !important;
        border-color: #000 !important;
    }

    /* Force card body background */
    body.dark-mode .card-body {
        background-color: #2D2D2D !important;
    }

    /* Dark table class for manual application */
    .dark-table {
        background-color: #2D2D2D !important;
    }

    .dark-table,
    .dark-table th,
    .dark-table td,
    .dark-table thead,
    .dark-table tbody,
    .dark-table tfoot,
    .dark-table tr {
        background-color: #2D2D2D !important;
        color: #F7F7F7 !important;
        border-color: #000 !important;
    }

    /* Refresh button - only rotate icon */
    .btn-refresh {
        background: linear-gradient(135deg, #EF4444, #DC2626);
        border: none;
        color: white;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-refresh:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
        color: white;
    }

    .btn-refresh i {
        transition: transform 0.3s ease;
        display: inline-block;
    }

    .btn-refresh:hover i {
        transform: rotate(180deg);
    }

    /* Print Styles */
    @media print {
        .page-header {
            display: none !important;
        }
        
        #receipt {
            border: 2px solid #000 !important;
            page-break-inside: avoid;
        }
        
        #receipt .card-body {
            padding: 20px !important;
        }
        
        #receipt h5 {
            font-size: 18px !important;
            margin-bottom: 15px !important;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        
        #receipt .table {
            border: 1px solid #000 !important;
        }
        
        #receipt .table th,
        #receipt .table td {
            border: 1px solid #000 !important;
            padding: 8px !important;
            color: #000 !important;
        }
        
        #receipt .badge {
            border: 1px solid #000 !important;
            padding: 4px 8px !important;
        }
        
        #receipt .alert {
            border: 2px solid #000 !important;
            padding: 10px !important;
        }
        
        /* Print header */
        #receipt::before {
            content: "STRUK PESANAN";
            display: block;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
        }
    }

    /* Mobile responsive */
    @media (max-width: 576px) {
        .status-header h2 {
            font-size: 1.5rem;
        }

        .timeline-item {
            max-width: 100%;
        }

        .receipt-card .row .col-6 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 10px;
        }

        .d-grid.gap-2 {
            gap: 0.5rem !important;
        }

        .btn-refresh,
        .btn-outline-secondary {
            padding: 12px;
            font-size: 0.95rem;
        }
    }
</style>
@endpush

@section('content')
<div class="text-center mb-4 page-header status-header">
    <div class="mb-3">
        @if($order->order_status == 'pending')
            <i class="fas fa-clock fa-4x text-warning status-icon"></i>
        @elseif($order->order_status == 'cooking')
            <i class="fas fa-fire fa-4x text-danger status-icon cooking"></i>
        @elseif($order->order_status == 'served')
            <i class="fas fa-concierge-bell fa-4x text-success status-icon"></i>
        @elseif($order->order_status == 'completed')
            <i class="fas fa-check-circle fa-4x text-success status-icon completed"></i>
        @else
            <i class="fas fa-times-circle fa-4x text-muted status-icon"></i>
        @endif
    </div>
    <h2 class="status-title">Status Pesanan Anda</h2>
    <p class="lead" style="font-weight: 600; color: {{ $order->order_status == 'completed' ? '#10B981' : '#DC2626' }};">
        Status: {{ ucfirst($order->order_status) }}
    </p>
</div>

<!-- Progress Timeline -->
<div class="row mb-4">
    <div class="col-md-10 mx-auto">
        <div class="progress-timeline">
            <div class="timeline-item">
                <div class="timeline-icon {{ in_array($order->order_status, ['pending', 'cooking', 'served', 'completed']) ? 'completed' : 'pending' }}">
                    <i class="fas fa-check"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-title">Pesanan Diterima</div>
                    <div class="timeline-desc">Pesanan Anda telah diterima oleh sistem</div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-icon {{ in_array($order->order_status, ['cooking', 'served', 'completed']) ? ($order->order_status == 'cooking' ? 'active' : 'completed') : 'pending' }}">
                    <i class="fas {{ in_array($order->order_status, ['cooking', 'served', 'completed']) ? 'fa-fire' : 'fa-clock' }}"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-title">Sedang Dimasak</div>
                    <div class="timeline-desc">Koki sedang menyiapkan pesanan Anda</div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-icon {{ in_array($order->order_status, ['served', 'completed']) ? ($order->order_status == 'served' ? 'active' : 'completed') : 'pending' }}">
                    <i class="fas {{ in_array($order->order_status, ['served', 'completed']) ? 'fa-concierge-bell' : 'fa-clock' }}"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-title">Siap Disajikan</div>
                    <div class="timeline-desc">Pesanan Anda siap untuk disajikan</div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-icon {{ $order->order_status == 'completed' ? 'active' : 'pending' }}">
                    <i class="fas {{ $order->order_status == 'completed' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-title">Selesai</div>
                    <div class="timeline-desc">Pesanan selesai dan pembayaran lunas</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card mb-4 receipt-card" id="receipt">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-receipt no-print" style="color: #DC2626;"></i> Detail Pesanan
                    </h5>
                    <button onclick="printReceipt()" class="btn btn-sm btn-primary no-print" style="border-radius: 10px;">
                        <i class="fas fa-print"></i> Cetak Struk
                    </button>
                </div>
                
                <div class="row mb-3">
                    <div class="col-6">
                        <p class="mb-1"><strong>Meja:</strong> {{ $order->table->table_number }}</p>
                        <p class="mb-1"><strong>Lantai:</strong> {{ $order->floor ?? '-' }}</p>
                        <p class="mb-1"><strong>Nama:</strong> {{ $order->customer_name ?? 'Tamu' }}</p>
                        <p class="mb-1"><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1"><strong>Status Pesanan:</strong> 
                            <span class="badge" style="background: linear-gradient(135deg, {{ $order->order_status == 'completed' ? '#10B981, #059669' : '#EF4444, #DC2626' }});">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </p>
                        <p class="mb-1"><strong>Status Pembayaran:</strong> 
                            <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                        <p class="mb-1"><strong>Metode:</strong> {{ $order->payment_method }}</p>
                    </div>
                </div>

                <hr>

                <h6>Detail Pesanan:</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->menu->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">TOTAL:</th>
                                <th class="total-amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <hr>

                @if($order->payment_method == 'Transfer' && $order->payment_status == 'pending')
                    <div class="alert alert-info" style="border-radius: 10px; border-left: 4px solid #DC2626; background: #FFF1F2; color: #991B1B;">
                        <h6><i class="fas fa-info-circle"></i> Silakan Transfer ke:</h6>
                        <a href="{{ route('order.paymentInfo', $order->table->uuid) }}" class="btn btn-primary btn-sm" style="border-radius: 10px;">
                            <i class="fas fa-credit-card"></i> Lihat Info Pembayaran Lengkap
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="d-grid gap-2 no-print">
            <button onclick="window.location.reload()" class="btn btn-refresh">
                <i class="fas fa-sync"></i> Refresh Status
            </button>
            <a href="{{ route('order.index', $order->table->uuid) }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
                <i class="fas fa-arrow-left"></i> Kembali ke Menu
            </a>
        </div>
    </div>
</div>

@push('js')
<script>
function printReceipt() {
    window.print();
}

// Force dark mode table styling
function applyDarkModeToTable() {
    const body = document.body;
    const table = document.querySelector('#receipt .table');
    
    if (body.classList.contains('dark-mode') && table) {
        // Add dark-table class
        table.classList.add('dark-table');
        
        // Force inline styles as backup
        table.style.backgroundColor = '#2D2D2D';
        table.style.color = '#F7F7F7';
        
        // Apply to all table elements
        const elements = table.querySelectorAll('th, td, thead, tbody, tfoot, tr');
        elements.forEach(el => {
            el.style.backgroundColor = '#2D2D2D';
            el.style.color = '#F7F7F7';
            el.style.borderColor = '#000';
        });
    } else if (table) {
        // Remove dark mode if switching to light mode
        table.classList.remove('dark-table');
        table.style.backgroundColor = '';
        table.style.color = '';
        
        const elements = table.querySelectorAll('th, td, thead, tbody, tfoot, tr');
        elements.forEach(el => {
            el.style.backgroundColor = '';
            el.style.color = '';
            el.style.borderColor = '';
        });
    }
}

// Apply on page load
document.addEventListener('DOMContentLoaded', applyDarkModeToTable);

// Re-apply when theme changes (listen to storage event)
window.addEventListener('storage', applyDarkModeToTable);

// Also check periodically in case theme toggle doesn't trigger storage event
setInterval(applyDarkModeToTable, 500);
</script>
@endpush
@endsection
