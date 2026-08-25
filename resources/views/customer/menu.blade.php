@extends('layouts.customer')

@section('title', 'Menu - Little Palembang')

@push('css')
<style>
    /* Menu page premium styles */
    .page-header {
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

    .page-header h1 {
        font-weight: 800;
        background: linear-gradient(135deg, #DC2626, #991B1B);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }

    /* Category filter pills (Merah Putih) */
    #categoryFilter .btn {
        border: 2px solid #DC2626;
        color: #DC2626;
        border-radius: 9999px !important;
        font-weight: 700;
        padding: 6px 18px;
        margin: 2px 4px;
        transition: all 0.25s ease;
        background: #ffffff;
    }

    #categoryFilter .btn:hover,
    #categoryFilter .btn.active {
        background: linear-gradient(135deg, #EF4444, #DC2626) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
        border-color: #DC2626 !important;
    }

    body.dark-mode #categoryFilter .btn {
        background: #1E293B;
    }

    /* Menu cards with staggered animation */
    .menu-card {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
        transition: all 0.3s ease;
    }

    .menu-card:nth-child(1) { animation-delay: 0.05s; }
    .menu-card:nth-child(2) { animation-delay: 0.1s; }
    .menu-card:nth-child(3) { animation-delay: 0.15s; }
    .menu-card:nth-child(4) { animation-delay: 0.2s; }
    .menu-card:nth-child(5) { animation-delay: 0.25s; }
    .menu-card:nth-child(6) { animation-delay: 0.3s; }
    .menu-card:nth-child(7) { animation-delay: 0.35s; }
    .menu-card:nth-child(8) { animation-delay: 0.4s; }

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

    .menu-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(220, 38, 38, 0.15) !important;
    }

    .menu-card .card-img-top {
        transition: transform 0.4s ease;
        border-radius: 15px 15px 0 0;
    }

    .menu-card:hover .card-img-top {
        transform: scale(1.06);
    }

    .menu-card .card {
        overflow: hidden;
        border-radius: 16px;
        border: 1px solid #E2E8F0;
    }

    /* Price text */
    .card-text.text-primary {
        font-weight: 800;
        font-size: 1.15rem;
        color: #DC2626 !important;
    }

    /* Quantity selector with animations */
    .quantity-selector {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 10px;
    }
    
    .quantity-btn {
        width: 32px;
        height: 32px;
        border: 1.5px solid #E2E8F0;
        background: white;
        border-radius: 8px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0F172A;
    }

    .quantity-btn:hover {
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: white;
        border-color: #DC2626;
        transform: scale(1.08);
    }
    
    body.dark-mode .quantity-btn {
        background: #0F172A;
        border-color: #334155;
        color: #F8FAFC;
    }
    
    .quantity-input {
        width: 55px;
        text-align: center;
        border: 1.5px solid #E2E8F0;
        border-radius: 8px;
        padding: 5px;
        font-weight: 700;
        transition: all 0.25s ease;
    }

    .quantity-input:focus {
        border-color: #DC2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
        outline: none;
    }
    
    body.dark-mode .quantity-input {
        background: #0F172A;
        border-color: #334155;
        color: #F8FAFC;
    }

    /* Active order card animation */
    #active-order {
        animation: slideInLeft 0.5s ease-out;
        border: 2px solid #DC2626 !important;
        border-radius: 16px;
        overflow: hidden;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Print button animation */
    .btn-primary {
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
    }

    /* Print Styles */
    @media print {
        .menu-list {
            display: none !important;
        }
        
        .page-header {
            display: none !important;
        }
        
        #active-order {
            border: 2px solid #000 !important;
            page-break-inside: avoid;
        }
        
        #active-order .card-body {
            padding: 20px !important;
        }
        
        #active-order h5 {
            font-size: 18px !important;
            margin-bottom: 15px !important;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        
        #active-order .table {
            border: 1px solid #000 !important;
        }
        
        #active-order .table th,
        #active-order .table td {
            border: 1px solid #000 !important;
            padding: 8px !important;
            color: #000 !important;
        }
        
        #active-order .badge {
            border: 1px solid #000 !important;
            padding: 4px 8px !important;
        }
        
        #active-order .alert {
            border: 2px solid #000 !important;
            padding: 10px !important;
        }
        
        /* Print header */
        #active-order::before {
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
        /* 1 column on very small screens */
        .menu-card {
            margin-bottom: 20px;
        }

        .col-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        #active-order .btn-sm {
            padding: 8px 12px;
        }

        #active-order .row .col-6 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 10px;
        }
    }

    @media (min-width: 577px) and (max-width: 768px) {
        /* 2 columns on medium screens */
        .page-header h1 {
            font-size: 1.8rem;
        }
    /* Menu availability styles */
    .menu-card-unavailable {
        opacity: 0.68;
        filter: grayscale(35%);
        transition: all 0.3s ease;
    }
    .menu-card-unavailable:hover {
        opacity: 0.85;
        filter: grayscale(15%);
    }
    .badge-out-of-stock {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(135deg, #DC2626, #991B1B);
        color: white;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 5px 10px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        z-index: 2;
    }
    .star-gold, .text-gold {
        color: #FFB800 !important;
        text-shadow: 0 0 2px rgba(255, 184, 0, 0.4);
    }
    .badge-table-rating {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 9999px;
        background: #FFF1F2;
        border: 1.5px solid #FECDD3;
        color: #991B1B;
        font-weight: 700;
        font-size: 0.85rem;
        margin-top: 6px;
    }
    body.dark-mode .badge-table-rating {
        background: #33141E;
        border-color: #881337;
        color: #FECDD3;
    }
</style>
@endpush

@section('content')
<div class="text-center mb-4 page-header">
    <h1 class="display-6 mb-1">Meja {{ $table->table_number }}</h1>
    
    <div>
        @if(isset($tableStats) && $tableStats['is_top'])
            <div class="badge-table-rating">
                <span>🏆</span>
                <span>Meja Terfavorit #1</span>
                <span class="star-gold" style="font-size: 1.1rem;">★</span>
                <span>{{ $tableStats['avg_rating'] }}/5.0</span>
                <span class="text-muted" style="font-size: 0.75rem;">({{ $tableStats['rating_count'] }} ulasan)</span>
            </div>
        @elseif(isset($tableStats) && $tableStats['rating_count'] > 0)
            <div class="badge-table-rating">
                <span class="star-gold" style="font-size: 1.1rem;">★</span>
                <span>{{ $tableStats['avg_rating'] }}/5.0</span>
                <span>• Meja Favorit #{{ $tableStats['rank'] }}</span>
                <span class="text-muted" style="font-size: 0.75rem;">({{ $tableStats['rating_count'] }} ulasan)</span>
            </div>
        @else
            <div class="badge-table-rating">
                <span class="star-gold" style="font-size: 1.1rem;">★</span>
                <span>5.0/5.0</span>
                <span>• Meja Nyaman & Bersih</span>
            </div>
        @endif
    </div>

    <p class="text-muted mt-2 mb-0">Pilih hidangan favorit khas Little Palembang</p>
    
    @if(count($cart) > 0)
    <button type="button" class="btn btn-outline-danger btn-sm mt-2" onclick="clearEntireCart()">
        <i class="fas fa-trash-alt"></i> Kosongkan Keranjang
    </button>
    @endif
</div>

@if($activeOrder)
<div class="card mb-4 border-warning" id="active-order">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">
                <i class="fas fa-receipt text-warning no-print"></i> Pesanan Aktif
            </h5>
            <button onclick="printActiveOrder()" class="btn btn-sm btn-primary no-print">
                <i class="fas fa-print"></i> Cetak Struk
            </button>
        </div>
        
        <div class="row mb-3">
            <div class="col-6">
                <p class="mb-1"><strong>Meja:</strong> {{ $table->table_number }}</p>
                <p class="mb-1"><strong>Nama:</strong> {{ $activeOrder->customer_name ?? 'Tamu' }}</p>
                <p class="mb-1"><strong>Tanggal:</strong> {{ $activeOrder->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="col-6">
                <p class="mb-1"><strong>Status Pesanan:</strong> 
                    <span class="badge bg-{{ $activeOrder->order_status == 'served' ? 'success' : 'warning' }}">
                        {{ ucfirst($activeOrder->order_status) }}
                    </span>
                </p>
                <p class="mb-1"><strong>Status Pembayaran:</strong> 
                    <span class="badge bg-{{ $activeOrder->payment_status == 'paid' ? 'success' : 'danger' }}">
                        {{ ucfirst($activeOrder->payment_status) }}
                    </span>
                </p>
                <p class="mb-1"><strong>Metode:</strong> {{ $activeOrder->payment_method }}</p>
            </div>
        </div>
        
        <hr>
        
        <h6>Detail Pesanan:</h6>
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
                @foreach($activeOrder->items as $item)
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
                    <th>Rp {{ number_format($activeOrder->total_amount, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
        
        @if($activeOrder->payment_method == 'Transfer' && $activeOrder->payment_status == 'pending')
        <div class="alert alert-info mb-0">
            <small><i class="fas fa-info-circle"></i> Silakan transfer ke Bank BCA: 1234567890 (Little Palembang) atau scan QRIS di kasir.</small>
        </div>
        @endif
        
        <div class="d-grid mt-3 no-print">
            <a href="{{ route('order.status', ['uuid' => $table->uuid, 'order' => $activeOrder->id]) }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-eye"></i> Lihat Detail Lengkap
            </a>
        </div>
    </div>
</div>
@endif

<div class="row mb-4">
    <div class="col-12 text-center mb-2">
        <div class="btn-group" role="group" id="categoryFilter">
            <button type="button" class="btn btn-outline-primary active" onclick="filterCustomerMenu('all', this)">Semua</button>
            <button type="button" class="btn btn-outline-primary" onclick="filterCustomerMenu('Makanan', this)">Makanan</button>
            <button type="button" class="btn btn-outline-primary" onclick="filterCustomerMenu('Minuman', this)">Minuman</button>
            <button type="button" class="btn btn-outline-primary" onclick="filterCustomerMenu('Camilan', this)">Camilan</button>
        </div>
    </div>
    <div class="col-12">
        <select id="subCategoryFilter" class="form-select" onchange="applyFilters()">
            <option value="all" data-category="all">Semua Sub Kategori</option>
            @php
                $subCatMapping = $menus->filter(function($m) { return !empty($m->sub_category); })
                    ->groupBy('sub_category')
                    ->map(function($group) { return $group->first()->category; });
            @endphp
            @foreach($subCatMapping as $sub => $cat)
                <option value="{{ $sub }}" data-category="{{ $cat }}">{{ $sub }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row menu-list" id="customerMenuGrid">
    @foreach($menus as $menu)
    <div class="col-6 col-md-4 col-lg-3 mb-4 menu-card customer-menu-item {{ !$menu->is_available ? 'menu-card-unavailable' : '' }}" data-category="{{ $menu->category }}" data-subcategory="{{ $menu->sub_category }}">
        <div class="card h-100 position-relative">
            @if(!$menu->is_available)
                <div class="badge-out-of-stock">
                    <i class="fas fa-ban me-1"></i> Stok Habis
                </div>
            @endif

            @if($menu->image)
                <img src="/images/{{ $menu->image }}" class="card-img-top" alt="{{ $menu->name }}" style="height: 150px; object-fit: cover;">
            @else
                <div class="bg-secondary text-white d-flex justify-content-center align-items-center" style="height: 150px;">
                    <i class="fas fa-utensils fa-2x"></i>
                </div>
            @endif
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="card-title" style="font-size: 1rem;">{{ $menu->name }}</h5>
                    <p class="card-text text-primary fw-bold mb-2">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                </div>
                
                @if($menu->is_available)
                <form action="{{ route('order.updateCartItem', $table->uuid) }}" method="POST" id="form-{{ $menu->id }}">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    
                    <div class="quantity-selector">
                        <button type="button" class="quantity-btn" onclick="updateAndSyncQty({{ $menu->id }}, -1)">−</button>
                        <input type="number" name="quantity" id="qty-{{ $menu->id }}" value="{{ isset($cart[$menu->id]) ? $cart[$menu->id]['quantity'] : 0 }}" min="0" max="100" class="quantity-input" onchange="syncQty({{ $menu->id }})">
                        <button type="button" class="quantity-btn" onclick="updateAndSyncQty({{ $menu->id }}, 1)">+</button>
                        <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="clearItem({{ $menu->id }})" title="Hapus Item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </form>
                @else
                <div class="mt-2 text-center">
                    <span class="badge bg-secondary w-100 py-2" style="font-size: 0.82rem; border-radius: 8px; cursor: not-allowed;">
                        <i class="fas fa-ban me-1"></i> Tidak Tersedia
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@php
    $cartCount = collect($cart)->sum('quantity');
    $cartTotal = collect($cart)->sum(function($item) { return $item['price'] * $item['quantity']; });
@endphp

<!-- Floating Bottom Checkout Bar (Mobile & Desktop friendly) -->
<div id="floating-cart-bar" class="fixed-bottom p-3 no-print" style="{{ $cartCount > 0 ? 'display: block;' : 'display: none;' }}; z-index: 999;">
    <div class="container" style="max-width: 650px;">
        <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 50%, #B91C1C 100%); border-radius: 18px; color: white; box-shadow: 0 10px 30px rgba(220, 38, 38, 0.45) !important;">
            <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="bg-white text-danger rounded-circle d-flex align-items-center justify-content-center me-2 font-weight-bold" style="width: 40px; height: 40px; font-size: 1.1rem; font-weight: 800; color: #DC2626 !important;" id="floating-cart-badge">
                        {{ $cartCount }}
                    </div>
                    <div>
                        <div style="font-size: 0.78rem; opacity: 0.9; text-transform: uppercase; letter-spacing: 0.5px;">Total Pesanan</div>
                        <strong style="font-size: 1.15rem;" id="floating-cart-total">Rp {{ number_format($cartTotal, 0, ',', '.') }}</strong>
                    </div>
                </div>
                <a href="{{ route('order.checkout', $table->uuid) }}" class="btn btn-light font-weight-bold px-3 py-2 rounded-pill" style="color: #DC2626 !important; font-weight: 800; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    Checkout <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
let currentCategory = 'all';

function filterCustomerMenu(category, btnElement) {
    currentCategory = category;
    
    // Update active button
    document.querySelectorAll('#categoryFilter .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    btnElement.classList.add('active');
    
    // Update subcategory dropdown visibility/options based on category
    const subSelect = document.getElementById('subCategoryFilter');
    
    Array.from(subSelect.options).forEach(opt => {
        if (opt.value === 'all') return;
        
        if (category === 'all' || opt.getAttribute('data-category') === category) {
            opt.style.display = '';
        } else {
            opt.style.display = 'none';
            // If the active subcategory is now hidden, reset to 'all'
            if (subSelect.value === opt.value) {
                subSelect.value = 'all';
            }
        }
    });
    
    applyFilters();
}

function applyFilters() {
    const subCategory = document.getElementById('subCategoryFilter').value;
    const items = document.querySelectorAll('.customer-menu-item');
    let visibleCount = 0;
    
    items.forEach(item => {
        const itemCat = item.getAttribute('data-category');
        const itemSubCat = item.getAttribute('data-subcategory');
        
        const catMatch = (currentCategory === 'all' || itemCat === currentCategory);
        const subCatMatch = (subCategory === 'all' || itemSubCat === subCategory);
        
        if (catMatch && subCatMatch) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    // Handle empty state if needed
    let emptyMsg = document.getElementById('emptyFilterMsg');
    if (visibleCount === 0) {
        if (!emptyMsg) {
            emptyMsg = document.createElement('div');
            emptyMsg.id = 'emptyFilterMsg';
            emptyMsg.className = 'col-12 text-center py-5';
            emptyMsg.innerHTML = '<i class="fas fa-search fa-3x text-muted mb-3"></i><p class="text-muted">Tidak ada menu yang sesuai dengan filter.</p>';
            document.getElementById('customerMenuGrid').appendChild(emptyMsg);
        }
        emptyMsg.style.display = 'block';
    } else if (emptyMsg) {
        emptyMsg.style.display = 'none';
    }
}

function printActiveOrder() {
    window.print();
}

function updateAndSyncQty(menuId, change) {
    const input = document.getElementById('qty-' + menuId);
    let value = parseInt(input.value) || 0;
    
    let newValue = value + change;
    if (newValue < 0) newValue = 0;
    if (newValue > 100) newValue = 100;
    
    if (newValue !== value) {
        input.value = newValue;
        syncQty(menuId);
    }
}

function clearItem(menuId) {
    const input = document.getElementById('qty-' + menuId);
    if(parseInt(input.value) !== 0) {
        input.value = 0;
        syncQty(menuId);
    }
}

function syncQty(menuId) {
    const form = document.getElementById('form-' + menuId);
    const formData = new FormData(form);
    const input = document.getElementById('qty-' + menuId);
    let value = parseInt(input.value);

    // Validate
    if (isNaN(value) || value < 0) {
        value = 0;
        input.value = 0;
    } else if (value > 100) {
        value = 100;
        input.value = 100;
    }
    
    formData.set('quantity', value);
    
    // Disable inputs momentarily
    const buttons = form.querySelectorAll('button');
    buttons.forEach(b => b.disabled = true);
    input.disabled = true;

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartUI(data.cart_count, data.cart_total);
            showToast(value > 0 ? 'Keranjang Diperbarui' : 'Item Dihapus', value > 0 ? '#DC2626' : '#64748B');
        }
    })
    .catch(error => console.error("Sync Cart Error:", error))
    .finally(() => {
        buttons.forEach(b => b.disabled = false);
        input.disabled = false;
    });
}

function clearEntireCart() {
    if(!confirm('Yakin ingin mengosongkan keranjang?')) return;
    
    const token = document.querySelector('input[name="_token"]').value;
    
    fetch("{{ route('order.clearCart', $table->uuid) }}", {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            _token: token
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Reset all inputs
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.value = 0;
            });
            updateCartUI(0, 0);
            showToast('Keranjang Dikosongkan', '#DC2626');
        }
    })
    .catch(error => console.error('Clear Cart Error:', error));
}

function updateCartUI(count, total) {
    // 1. Update Navbar Cart Count Badge
    const navCount = document.getElementById('nav-cart-count');
    if (navCount) {
        navCount.textContent = count;
        navCount.style.transform = 'scale(1.35)';
        setTimeout(() => { navCount.style.transform = 'scale(1)'; }, 200);
    }
    
    // 2. Update Floating Bottom Checkout Bar
    const floatingBar = document.getElementById('floating-cart-bar');
    const floatingBadge = document.getElementById('floating-cart-badge');
    const floatingTotal = document.getElementById('floating-cart-total');
    
    if (floatingBar) {
        if (count > 0) {
            floatingBar.style.display = 'block';
            if (floatingBadge) floatingBadge.textContent = count;
            if (floatingTotal) floatingTotal.textContent = 'Rp ' + Number(total || 0).toLocaleString('id-ID');
        } else {
            floatingBar.style.display = 'none';
        }
    }
    
    // 3. Toggle "Kosongkan Keranjang" header button
    const clearBtn = document.querySelector('.page-header .btn-outline-danger');
    if (clearBtn) {
        clearBtn.style.display = count > 0 ? 'inline-block' : 'none';
    } else if (count > 0) {
        const header = document.querySelector('.page-header');
        if (header) {
            const btnHtml = `<button type="button" class="btn btn-outline-danger btn-sm mt-2" onclick="clearEntireCart()"><i class="fas fa-trash-alt"></i> Kosongkan Keranjang</button>`;
            header.insertAdjacentHTML('beforeend', btnHtml);
        }
    }
}

function showToast(message, color = '#DC2626') {
    const toast = document.createElement('div');
    toast.innerHTML = `<i class="fas fa-info-circle me-1"></i> ${message}`;
    toast.style.position = 'fixed';
    toast.style.bottom = '85px';
    toast.style.right = '20px';
    toast.style.background = color;
    toast.style.color = '#fff';
    toast.style.padding = '10px 20px';
    toast.style.borderRadius = '30px';
    toast.style.zIndex = '99999';
    toast.style.boxShadow = '0 6px 20px rgba(0,0,0,0.25)';
    toast.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
    toast.style.fontWeight = 'bold';
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        setTimeout(() => toast.remove(), 350);
    }, 1500);
}
</script>
@endpush
@endsection
