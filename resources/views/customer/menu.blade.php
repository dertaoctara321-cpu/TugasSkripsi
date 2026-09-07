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

    /* Live Search Box */
    .search-box-wrapper {
        position: relative;
        max-width: 600px;
        margin: 0 auto 16px auto;
    }

    .search-box-wrapper .form-control {
        border-radius: 50px;
        padding: 12px 45px 12px 48px;
        border: 2px solid #DC2626;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.12);
        font-size: 0.95rem;
        transition: all 0.25s ease;
        background: #ffffff;
    }

    .search-box-wrapper .form-control:focus {
        box-shadow: 0 6px 22px rgba(220, 38, 38, 0.25);
        border-color: #991B1B;
        outline: none;
    }

    body.dark-mode .search-box-wrapper .form-control {
        background: #1E293B;
        color: #F8FAFC;
        border-color: #DC2626;
    }

    .search-box-wrapper .search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #DC2626;
        font-size: 1.1rem;
        pointer-events: none;
    }

    .search-box-wrapper .clear-search-btn {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #94A3B8;
        font-size: 1.1rem;
        cursor: pointer;
        padding: 0;
        display: none;
        line-height: 1;
    }

    .search-box-wrapper .clear-search-btn:hover {
        color: #DC2626;
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
        font-size: 0.9rem;
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

    /* Menu cards */
    .menu-card {
        transition: all 0.3s ease;
    }

    .menu-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(220, 38, 38, 0.15) !important;
    }

    .menu-card .card-img-top {
        transition: transform 0.4s ease;
        border-radius: 15px 15px 0 0;
    }

    .menu-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .menu-card .card {
        overflow: hidden;
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        transition: border-color 0.25s ease, box-shadow 0.25s ease;
    }

    body.dark-mode .menu-card .card {
        background: #1E293B;
        border-color: #334155;
    }

    /* Stock badges */
    .badge-stock {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(16, 185, 129, 0.95);
        color: white;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 4px 9px;
        border-radius: 20px;
        box-shadow: 0 3px 8px rgba(16, 185, 129, 0.4);
        z-index: 2;
        backdrop-filter: blur(4px);
    }

    .badge-low-stock {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #F59E0B;
        color: #111827;
        font-weight: 800;
        font-size: 0.72rem;
        padding: 4px 9px;
        border-radius: 20px;
        box-shadow: 0 3px 8px rgba(245, 158, 11, 0.4);
        z-index: 2;
        animation: pulseWarning 1.8s infinite;
    }

    @keyframes pulseWarning {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.06); }
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

    .menu-card-unavailable {
        opacity: 0.65;
        filter: grayscale(40%);
        transition: all 0.3s ease;
    }

    /* Menu Card Description */
    .menu-card-desc {
        font-size: 0.77rem;
        color: #64748B;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.3em;
        line-height: 1.3;
        margin-bottom: 8px;
    }

    body.dark-mode .menu-card-desc {
        color: #94A3B8;
    }

    /* Button Kustom / Detail */
    .btn-detail-condiment {
        font-size: 0.76rem;
        font-weight: 700;
        color: #DC2626;
        background: #FFF1F2;
        border: 1px solid #FECDD3;
        border-radius: 8px;
        padding: 5px 10px;
        text-align: center;
        display: block;
        width: 100%;
        margin-bottom: 10px;
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-detail-condiment:hover {
        background: #FEE2E2;
        color: #991B1B;
        border-color: #FDA4AF;
        transform: translateY(-1px);
    }

    body.dark-mode .btn-detail-condiment {
        background: #33141E;
        border-color: #881337;
        color: #FECDD3;
    }

    .item-note-badge {
        font-size: 0.72rem;
        background: #FEF3C7;
        border: 1px dashed #F59E0B;
        color: #92400E;
        padding: 3px 8px;
        border-radius: 6px;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 8px;
        font-weight: 600;
    }

    body.dark-mode .item-note-badge {
        background: #451A03;
        border-color: #D97706;
        color: #FDE68A;
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

    .quantity-btn:hover:not(:disabled) {
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: white;
        border-color: #DC2626;
        transform: scale(1.08);
    }

    .quantity-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    body.dark-mode .quantity-btn {
        background: #0F172A;
        border-color: #334155;
        color: #F8FAFC;
    }
    
    .quantity-input {
        width: 50px;
        text-align: center;
        border: 1.5px solid #E2E8F0;
        border-radius: 8px;
        padding: 4px;
        font-weight: 700;
        transition: all 0.25s ease;
        font-size: 0.95rem;
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

    /* Active order card animation */
    #active-order {
        animation: slideInLeft 0.5s ease-out;
        border: 2px solid #DC2626 !important;
        border-radius: 16px;
        overflow: hidden;
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* Mobile responsive optimizations */
    @media (max-width: 576px) {
        .page-header h1 {
            font-size: 1.45rem;
        }
        .col-6 {
            padding-left: 6px;
            padding-right: 6px;
        }
        .card-body.p-3 {
            padding: 10px !important;
        }
        .card-title {
            font-size: 0.92rem !important;
        }
        .card-text.text-primary {
            font-size: 1rem !important;
        }
        .quantity-btn {
            width: 28px;
            height: 28px;
            font-size: 15px;
        }
        .quantity-input {
            width: 42px;
            font-size: 0.88rem;
            padding: 2px;
        }
        .btn-detail-condiment {
            font-size: 0.72rem;
            padding: 4px 6px;
        }
    }
</style>
@endpush

@section('content')
<div class="text-center mb-4 page-header">
    <h1 class="display-6 mb-1">
        Meja {{ $table->table_number }} 
        <span class="badge {{ (int)$table->table_number <= 18 ? 'bg-info' : 'bg-primary' }}" style="font-size: 0.95rem; vertical-align: middle; border-radius: 20px; font-weight: 700;">
            <i class="fas fa-layer-group me-1"></i> {{ $table->floor }}
        </span>
    </h1>
    
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
            <div class="badge-table-rating" style="background: #F8FAFC; border-color: #E2E8F0; color: #64748B;">
                <span style="font-size: 1.1rem; color: #CBD5E1;">★</span>
                <span>0.0/5.0</span>
                <span>• Belum Ada Ulasan</span>
            </div>
        @endif
    </div>

    <p class="text-muted mt-2 mb-0">Pilih hidangan khas Little Palembang lengkap dengan informasi stok & komposisi</p>
    
    @if(count($cart) > 0)
    <button type="button" class="btn btn-outline-danger btn-sm mt-2" onclick="clearEntireCart()">
        <i class="fas fa-trash-alt me-1"></i> Kosongkan Keranjang
    </button>
    @endif
</div>

<!-- Search Bar (Pencarian Menu & Komposisi) -->
<div class="search-box-wrapper">
    <i class="fas fa-search search-icon"></i>
    <input type="text" id="menuSearchInput" class="form-control" placeholder="Cari nama hidangan, minuman, atau komposisi..." oninput="applyFilters()" autocomplete="off">
    <button type="button" class="clear-search-btn" id="clearSearchBtn" onclick="clearSearch()" title="Hapus pencarian">
        <i class="fas fa-times-circle"></i>
    </button>
</div>

@if($activeOrder)
<div class="card mb-4 border-warning" id="active-order">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">
                <i class="fas fa-receipt text-warning no-print"></i> Pesanan Aktif Meja Anda
            </h5>
            <a href="{{ route('order.status', ['uuid' => $table->uuid, 'order' => $activeOrder->id]) }}" class="btn btn-sm btn-primary no-print">
                <i class="fas fa-eye me-1"></i> Live Status
            </a>
        </div>
        
        <div class="row mb-3">
            <div class="col-6">
                <p class="mb-1"><strong>Meja:</strong> {{ $table->table_number }}</p>
                <p class="mb-1"><strong>Nama:</strong> {{ $activeOrder->customer_name ?? 'Tamu' }}</p>
            </div>
            <div class="col-6">
                <p class="mb-1"><strong>Status:</strong> 
                    <span class="badge bg-{{ in_array($activeOrder->order_status, ['served', 'completed']) ? 'success' : 'warning' }}">
                        {{ ucfirst($activeOrder->order_status) }}
                    </span>
                </p>
                <p class="mb-1"><strong>Pembayaran:</strong> 
                    <span class="badge bg-{{ $activeOrder->payment_status == 'paid' ? 'success' : 'danger' }}">
                        {{ ucfirst($activeOrder->payment_status) }}
                    </span>
                </p>
            </div>
        </div>

        <div class="alert alert-info py-2 mb-0" style="font-size: 0.85rem;">
            <i class="fas fa-info-circle me-1"></i> Anda dapat menambahkan pesanan baru ke meja ini kapan saja.
        </div>
    </div>
</div>
@endif

<!-- Category & Subcategory Filter -->
<div class="row mb-4">
    <div class="col-12 text-center mb-2">
        <div class="btn-group" role="group" id="categoryFilter">
            <button type="button" class="btn btn-outline-primary active" onclick="filterCustomerMenu('all', this)">Semua</button>
            <button type="button" class="btn btn-outline-primary" onclick="filterCustomerMenu('Makanan', this)">Makanan</button>
            <button type="button" class="btn btn-outline-primary" onclick="filterCustomerMenu('Minuman', this)">Minuman</button>
            <button type="button" class="btn btn-outline-primary" onclick="filterCustomerMenu('Camilan', this)">Camilan</button>
        </div>
    </div>
    <div class="col-12 col-md-8 mx-auto">
        <select id="subCategoryFilter" class="form-select shadow-sm" onchange="applyFilters()" style="border-radius: 12px; border: 1.5px solid #E2E8F0;">
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

<!-- Menus Grid -->
<div class="row menu-list" id="customerMenuGrid">
    @foreach($menus as $menu)
    @php
        $isItemAvailable = $menu->is_available && $menu->stock > 0;
        $cartItem = $cart[$menu->id] ?? null;
        $cartQty = $cartItem ? $cartItem['quantity'] : 0;
        $cartNote = $cartItem['notes'] ?? '';
    @endphp
    <div class="col-6 col-md-4 col-lg-3 mb-4 menu-card customer-menu-item {{ !$isItemAvailable ? 'menu-card-unavailable' : '' }}" 
         id="menu-card-{{ $menu->id }}"
         data-id="{{ $menu->id }}"
         data-name="{{ strtolower($menu->name) }}" 
         data-category="{{ $menu->category }}" 
         data-subcategory="{{ $menu->sub_category }}"
         data-desc="{{ strtolower($menu->description ?? '') }}"
         data-price="{{ $menu->price }}"
         data-stock="{{ $menu->stock }}"
         data-image="{{ $menu->image ? '/images/' . $menu->image : '' }}"
         data-available="{{ $isItemAvailable ? 1 : 0 }}">
        
        <div class="card h-100 position-relative shadow-sm">
            <!-- Stock Badges -->
            @if(!$isItemAvailable)
                <div class="badge-out-of-stock">
                    <i class="fas fa-ban me-1"></i> Stok Habis
                </div>
            @elseif($menu->stock <= 5)
                <div class="badge-low-stock">
                    <i class="fas fa-fire me-1"></i> Sisa {{ $menu->stock }}
                </div>
            @else
                <div class="badge-stock">
                    <i class="fas fa-boxes me-1"></i> Stok: {{ $menu->stock }}
                </div>
            @endif

            <!-- Menu Image -->
            @if($menu->image)
                <img src="/images/{{ $menu->image }}" class="card-img-top" alt="{{ $menu->name }}" style="height: 145px; object-fit: cover;" loading="lazy">
            @else
                <div class="bg-secondary text-white d-flex justify-content-center align-items-center" style="height: 145px;">
                    <i class="fas fa-utensils fa-2x"></i>
                </div>
            @endif

            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="card-title text-dark fw-bold mb-1" style="font-size: 0.98rem; line-height: 1.25;">
                        {{ $menu->name }}
                    </h5>
                    
                    <p class="card-text text-primary fw-bold mb-1">
                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                    </p>

                    <!-- Truncated Description / Composition -->
                    @if($menu->description)
                        <p class="menu-card-desc" title="{{ $menu->description }}">
                            {{ $menu->description }}
                        </p>
                    @else
                        <p class="menu-card-desc text-muted fst-italic">
                            Hidangan lezat Little Palembang.
                        </p>
                    @endif

                    <!-- Note Badge if already configured in cart -->
                    <div class="item-note-badge" id="note-badge-{{ $menu->id }}" style="{{ !empty($cartNote) ? 'display: block;' : 'display: none;' }}">
                        <i class="fas fa-pen-nib me-1"></i> <span id="note-text-{{ $menu->id }}">{{ $cartNote }}</span>
                    </div>

                    <!-- Button Detail & Kustom Condiment -->
                    <button type="button" class="btn-detail-condiment" onclick="openMenuDetailModal({{ $menu->id }})">
                        <i class="fas fa-sliders-h me-1"></i> Detail & Kustom Note
                    </button>
                </div>
                
                @if($isItemAvailable)
                <form action="{{ route('order.updateCartItem', $table->uuid) }}" method="POST" id="form-{{ $menu->id }}">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    <input type="hidden" name="notes" id="hidden-note-{{ $menu->id }}" value="{{ $cartNote }}">
                    
                    <div class="quantity-selector">
                        <button type="button" class="quantity-btn" onclick="updateAndSyncQty({{ $menu->id }}, -1)">−</button>
                        <input type="number" name="quantity" id="qty-{{ $menu->id }}" value="{{ $cartQty }}" min="0" max="{{ min(100, $menu->stock) }}" class="quantity-input" onchange="syncQty({{ $menu->id }})">
                        <button type="button" class="quantity-btn" onclick="updateAndSyncQty({{ $menu->id }}, 1)">+</button>
                        <button type="button" class="btn btn-sm btn-outline-danger ms-1 px-2" onclick="clearItem({{ $menu->id }})" title="Hapus Item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </form>
                @else
                <div class="mt-2 text-center">
                    <span class="badge bg-secondary w-100 py-2" style="font-size: 0.82rem; border-radius: 8px; cursor: not-allowed;">
                        <i class="fas fa-ban me-1"></i> Stok Habis
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

<!-- Modal Detail Hidangan, Komposisi & Condiment Note -->
<div class="modal fade" id="menuDetailModal" tabindex="-1" aria-labelledby="menuDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 22px; border: none; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.25);">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%); border: none;">
                <h5 class="modal-title fw-bold" id="menuDetailModalLabel">
                    <i class="fas fa-utensils me-2"></i> Detail Hidangan & Kustomisasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="modalMenuId" value="">
                
                <div class="text-center mb-3">
                    <img id="modalMenuImg" src="" alt="" class="rounded-3 shadow-sm img-fluid" style="max-height: 180px; width: 100%; object-fit: cover; border: 1px solid #E2E8F0;">
                </div>

                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark" id="modalMenuName">Nama Menu</h4>
                        <span class="badge bg-danger me-1" id="modalMenuCategory">Kategori</span>
                        <span class="badge bg-light text-dark border" id="modalMenuSubCategory">Sub</span>
                    </div>
                    <div class="text-end">
                        <div class="fs-5 fw-bold text-danger" id="modalMenuPrice">Rp 0</div>
                        <span class="badge bg-success" id="modalMenuStock">Stok: 20</span>
                    </div>
                </div>

                <!-- Komposisi & Deskripsi Detail -->
                <div class="mb-3 p-3 rounded-3" style="background: #F8FAFC; border: 1.5px solid #E2E8F0;">
                    <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.88rem;">
                        <i class="fas fa-clipboard-list text-danger me-1"></i> Komposisi & Deskripsi Hidangan:
                    </h6>
                    <p class="mb-0 text-muted" id="modalMenuDesc" style="font-size: 0.85rem; line-height: 1.45;">
                        Deskripsi belum tersedia.
                    </p>
                </div>

                <!-- Pilihan Condiment: Level Pedas -->
                <div class="mb-3">
                    <label class="form-label fw-bold d-block mb-1 text-dark" style="font-size: 0.88rem;">
                        <i class="fas fa-pepper-hot text-danger me-1"></i> Pilihan Level Pedas (Condiment):
                    </label>
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="modalSpicy" id="spicy0" value="Tidak Pedas">
                        <label class="btn btn-outline-danger btn-sm" for="spicy0">Tidak Pedas</label>

                        <input type="radio" class="btn-check" name="modalSpicy" id="spicy1" value="Pedas Sedang" checked>
                        <label class="btn btn-outline-danger btn-sm" for="spicy1">Sedang 👍</label>

                        <input type="radio" class="btn-check" name="modalSpicy" id="spicy2" value="Pedas">
                        <label class="btn btn-outline-danger btn-sm" for="spicy2">Pedas 🔥</label>

                        <input type="radio" class="btn-check" name="modalSpicy" id="spicy3" value="Ekstra Pedas">
                        <label class="btn btn-outline-danger btn-sm" for="spicy3">Ekstra 🌶️</label>
                    </div>
                </div>

                <!-- Pilihan Suhu / Es (Minuman) -->
                <div class="mb-3" id="condimentDrinkSection">
                    <label class="form-label fw-bold d-block mb-1 text-dark" style="font-size: 0.88rem;">
                        <i class="fas fa-glass-whiskey text-info me-1"></i> Pilihan Suhu / Es:
                    </label>
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="modalDrinkTemp" id="tempIce" value="Dingin (Es)" checked>
                        <label class="btn btn-outline-secondary btn-sm" for="tempIce">Dingin (Es)</label>

                        <input type="radio" class="btn-check" name="modalDrinkTemp" id="tempLessIce" value="Sedikit Es">
                        <label class="btn btn-outline-secondary btn-sm" for="tempLessIce">Sedikit Es</label>

                        <input type="radio" class="btn-check" name="modalDrinkTemp" id="tempWarm" value="Hangat / Normal">
                        <label class="btn btn-outline-secondary btn-sm" for="tempWarm">Hangat / Normal</label>
                    </div>
                </div>

                <!-- Opsi Penyajian Kuah / Cuko -->
                <div class="mb-3" id="condimentKuahSection">
                    <label class="form-label fw-bold d-block mb-1 text-dark" style="font-size: 0.88rem;">
                        <i class="fas fa-bowl-food text-warning me-1"></i> Opsi Kuah Cuko:
                    </label>
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="modalKuah" id="kuahCampur" value="Kuah/Cuko Dicampur" checked>
                        <label class="btn btn-outline-secondary btn-sm" for="kuahCampur">Dicampur</label>

                        <input type="radio" class="btn-check" name="modalKuah" id="kuahPisah" value="Kuah/Cuko Dipisah">
                        <label class="btn btn-outline-secondary btn-sm" for="kuahPisah">Dipisah</label>
                    </div>
                </div>

                <!-- Catatan Bebas Tambahan -->
                <div class="mb-3">
                    <label class="form-label fw-bold mb-1 text-dark" style="font-size: 0.88rem;">
                        <i class="fas fa-pen-nib text-danger me-1"></i> Catatan Khusus untuk Dapur (Opsional):
                    </label>
                    <input type="text" id="modalCustomNote" class="form-control form-control-sm" placeholder="Contoh: jangan pakai daun bawang, cuko diperbanyak, dll.">
                </div>

                <!-- Quantity in Modal -->
                <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="background: #FFF1F2; border: 1.5px solid #FECDD3;">
                    <span class="fw-bold text-dark" style="font-size: 0.95rem;">Jumlah Porsi:</span>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="quantity-btn" onclick="adjustModalQty(-1)">−</button>
                        <input type="number" id="modalQtyInput" class="quantity-input" value="1" min="1" max="100" readonly style="width: 50px;">
                        <button type="button" class="quantity-btn" onclick="adjustModalQty(1)">+</button>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer p-3" style="background: #F8FAFC; border-top: 1px solid #E2E8F0;">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div>
                        <div class="small text-muted">Subtotal:</div>
                        <strong class="fs-5 text-danger" id="modalSubtotalText">Rp 0</strong>
                    </div>
                    <button type="button" class="btn btn-danger px-4 py-2 fw-bold rounded-pill" id="modalAddToCartBtn" onclick="submitModalCart()">
                        <i class="fas fa-cart-plus me-1"></i> Simpan ke Pesanan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
let currentCategory = 'all';
let activeModalMenuPrice = 0;
let activeModalMaxStock = 100;

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
            if (subSelect.value === opt.value) {
                subSelect.value = 'all';
            }
        }
    });
    
    applyFilters();
}

function clearSearch() {
    const input = document.getElementById('menuSearchInput');
    if (input) {
        input.value = '';
        applyFilters();
    }
}

function applyFilters() {
    const subCategory = document.getElementById('subCategoryFilter').value;
    const searchInput = document.getElementById('menuSearchInput');
    const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
    const clearBtn = document.getElementById('clearSearchBtn');
    
    if (clearBtn) {
        clearBtn.style.display = query ? 'block' : 'none';
    }

    const items = document.querySelectorAll('.customer-menu-item');
    let visibleCount = 0;
    
    items.forEach(item => {
        const itemCat = item.getAttribute('data-category') || '';
        const itemSubCat = item.getAttribute('data-subcategory') || '';
        const itemName = item.getAttribute('data-name') || '';
        const itemDesc = item.getAttribute('data-desc') || '';
        
        const catMatch = (currentCategory === 'all' || itemCat === currentCategory);
        const subCatMatch = (subCategory === 'all' || itemSubCat === subCategory);
        const searchMatch = (!query || itemName.includes(query) || itemDesc.includes(query));
        
        if (catMatch && subCatMatch && searchMatch) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    let emptyMsg = document.getElementById('emptyFilterMsg');
    if (visibleCount === 0) {
        if (!emptyMsg) {
            emptyMsg = document.createElement('div');
            emptyMsg.id = 'emptyFilterMsg';
            emptyMsg.className = 'col-12 text-center py-5';
            emptyMsg.innerHTML = '<i class="fas fa-search fa-3x text-muted mb-3"></i><h5 class="text-muted fw-bold">Tidak ada menu yang sesuai</h5><p class="text-muted small">Coba gunakan kata kunci pencarian lain atau pilih kategori Semua.</p>';
            document.getElementById('customerMenuGrid').appendChild(emptyMsg);
        }
        emptyMsg.style.display = 'block';
    } else if (emptyMsg) {
        emptyMsg.style.display = 'none';
    }
}

function openMenuDetailModal(menuId) {
    const card = document.getElementById('menu-card-' + menuId);
    if (!card) return;

    const name = card.querySelector('.card-title').textContent.trim();
    const price = parseFloat(card.getAttribute('data-price')) || 0;
    const stock = parseInt(card.getAttribute('data-stock')) || 0;
    const category = card.getAttribute('data-category') || '';
    const subCategory = card.getAttribute('data-subcategory') || '';
    const desc = card.querySelector('.menu-card-desc')?.textContent.trim() || 'Deskripsi belum tersedia.';
    const imgEl = card.querySelector('.card-img-top');
    const existingQty = parseInt(document.getElementById('qty-' + menuId)?.value) || 1;
    const existingNote = document.getElementById('hidden-note-' + menuId)?.value || '';

    activeModalMenuPrice = price;
    activeModalMaxStock = Math.max(1, Math.min(100, stock));

    document.getElementById('modalMenuId').value = menuId;
    document.getElementById('modalMenuName').textContent = name;
    document.getElementById('modalMenuCategory').textContent = category;
    document.getElementById('modalMenuSubCategory').textContent = subCategory || 'Reguler';
    document.getElementById('modalMenuPrice').textContent = 'Rp ' + Number(price).toLocaleString('id-ID');
    document.getElementById('modalMenuDesc').textContent = desc;
    
    const stockBadge = document.getElementById('modalMenuStock');
    if (stock <= 0) {
        stockBadge.className = 'badge bg-danger';
        stockBadge.textContent = 'Stok Habis';
    } else if (stock <= 5) {
        stockBadge.className = 'badge bg-warning text-dark';
        stockBadge.textContent = 'Sisa ' + stock + ' Porsi';
    } else {
        stockBadge.className = 'badge bg-success';
        stockBadge.textContent = 'Tersedia ' + stock + ' Porsi';
    }

    const modalImg = document.getElementById('modalMenuImg');
    if (imgEl && imgEl.src) {
        modalImg.src = imgEl.src;
        modalImg.style.display = 'block';
    } else {
        modalImg.style.display = 'none';
    }

    // Toggle drink/kuah sections
    const isDrink = category.toLowerCase().includes('minuman');
    document.getElementById('condimentDrinkSection').style.display = isDrink ? 'block' : 'none';
    document.getElementById('condimentKuahSection').style.display = (!isDrink) ? 'block' : 'none';

    // Parse existing notes if any
    document.getElementById('modalCustomNote').value = '';
    if (existingNote) {
        if (existingNote.includes('Tidak Pedas')) document.getElementById('spicy0').checked = true;
        else if (existingNote.includes('Ekstra')) document.getElementById('spicy3').checked = true;
        else if (existingNote.includes('Pedas')) document.getElementById('spicy2').checked = true;
        else document.getElementById('spicy1').checked = true;

        if (existingNote.includes('Sedikit Es')) document.getElementById('tempLessIce').checked = true;
        else if (existingNote.includes('Hangat')) document.getElementById('tempWarm').checked = true;
        else document.getElementById('tempIce').checked = true;

        if (existingNote.includes('Dipisah')) document.getElementById('kuahPisah').checked = true;
        else document.getElementById('kuahCampur').checked = true;
        
        document.getElementById('modalCustomNote').value = existingNote;
    } else {
        document.getElementById('spicy1').checked = true;
        document.getElementById('tempIce').checked = true;
        document.getElementById('kuahCampur').checked = true;
    }

    // Qty
    const qtyInput = document.getElementById('modalQtyInput');
    qtyInput.value = (existingQty > 0) ? existingQty : 1;
    updateModalSubtotal();

    const addBtn = document.getElementById('modalAddToCartBtn');
    if (stock <= 0) {
        addBtn.disabled = true;
        addBtn.innerHTML = '<i class="fas fa-ban me-1"></i> Stok Habis';
    } else {
        addBtn.disabled = false;
        addBtn.innerHTML = '<i class="fas fa-cart-plus me-1"></i> Simpan ke Pesanan';
    }

    const modal = new bootstrap.Modal(document.getElementById('menuDetailModal'));
    modal.show();
}

function adjustModalQty(delta) {
    const qtyInput = document.getElementById('modalQtyInput');
    let val = parseInt(qtyInput.value) || 1;
    val += delta;
    if (val < 1) val = 1;
    if (val > activeModalMaxStock) val = activeModalMaxStock;
    qtyInput.value = val;
    updateModalSubtotal();
}

function updateModalSubtotal() {
    const qty = parseInt(document.getElementById('modalQtyInput').value) || 1;
    const subtotal = activeModalMenuPrice * qty;
    document.getElementById('modalSubtotalText').textContent = 'Rp ' + Number(subtotal).toLocaleString('id-ID');
}

function submitModalCart() {
    const menuId = document.getElementById('modalMenuId').value;
    const qty = parseInt(document.getElementById('modalQtyInput').value) || 1;
    const category = document.getElementById('modalMenuCategory').textContent.trim();
    const isDrink = category.toLowerCase().includes('minuman');

    // Build condiment string
    const parts = [];
    const spicy = document.querySelector('input[name="modalSpicy"]:checked')?.value;
    if (spicy) parts.push(spicy);

    if (isDrink) {
        const temp = document.querySelector('input[name="modalDrinkTemp"]:checked')?.value;
        if (temp) parts.push(temp);
    } else {
        const kuah = document.querySelector('input[name="modalKuah"]:checked')?.value;
        if (kuah) parts.push(kuah);
    }

    const customText = document.getElementById('modalCustomNote').value.trim();
    if (customText) {
        parts.push(customText);
    }

    const fullNote = parts.join(', ');

    // Send via form/sync
    const form = document.getElementById('form-' + menuId);
    if (!form) return;

    const inputQty = document.getElementById('qty-' + menuId);
    if (inputQty) inputQty.value = qty;

    const hiddenNote = document.getElementById('hidden-note-' + menuId);
    if (hiddenNote) hiddenNote.value = fullNote;

    const formData = new FormData(form);
    formData.set('quantity', qty);
    formData.set('notes', fullNote);

    const submitBtn = document.getElementById('modalAddToCartBtn');
    submitBtn.disabled = true;

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            updateCartUI(data.cart_count, data.cart_total);
            
            // Update note badge on card
            const badge = document.getElementById('note-badge-' + menuId);
            const text = document.getElementById('note-text-' + menuId);
            if (badge && text) {
                if (fullNote) {
                    text.textContent = fullNote;
                    badge.style.display = 'block';
                } else {
                    badge.style.display = 'none';
                }
            }

            showToast('Item & Catatan berhasil disimpan!', '#DC2626');
            const modalEl = document.getElementById('menuDetailModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
        } else {
            alert(data.message || 'Gagal menambahkan pesanan');
        }
    })
    .catch(err => console.error('Submit modal error:', err))
    .finally(() => {
        submitBtn.disabled = false;
    });
}

function updateAndSyncQty(menuId, change) {
    const input = document.getElementById('qty-' + menuId);
    const card = document.getElementById('menu-card-' + menuId);
    const stock = card ? parseInt(card.getAttribute('data-stock')) || 100 : 100;
    
    let value = parseInt(input.value) || 0;
    let newValue = value + change;
    if (newValue < 0) newValue = 0;
    if (newValue > stock) {
        showToast('Maksimal stok tersedia ' + stock + ' porsi', '#DC2626');
        newValue = stock;
    }
    
    if (newValue !== value) {
        input.value = newValue;
        syncQty(menuId);
    }
}

function clearItem(menuId) {
    const input = document.getElementById('qty-' + menuId);
    if (parseInt(input.value) !== 0) {
        input.value = 0;
        const hiddenNote = document.getElementById('hidden-note-' + menuId);
        if (hiddenNote) hiddenNote.value = '';
        syncQty(menuId);
    }
}

function syncQty(menuId) {
    const form = document.getElementById('form-' + menuId);
    const card = document.getElementById('menu-card-' + menuId);
    const stock = card ? parseInt(card.getAttribute('data-stock')) || 100 : 100;
    const input = document.getElementById('qty-' + menuId);
    let value = parseInt(input.value);

    if (isNaN(value) || value < 0) {
        value = 0;
        input.value = 0;
    } else if (value > stock) {
        value = stock;
        input.value = stock;
        showToast('Maksimal stok ' + stock + ' porsi', '#DC2626');
    }
    
    const formData = new FormData(form);
    formData.set('quantity', value);
    
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
            
            // Hide note badge if qty 0
            const badge = document.getElementById('note-badge-' + menuId);
            if (badge && value === 0) {
                badge.style.display = 'none';
            }

            showToast(value > 0 ? 'Keranjang Diperbarui' : 'Item Dihapus', value > 0 ? '#DC2626' : '#64748B');
        } else {
            showToast(data.message || 'Gagal mengubah keranjang', '#DC2626');
        }
    })
    .catch(error => console.error("Sync Cart Error:", error))
    .finally(() => {
        buttons.forEach(b => b.disabled = false);
        input.disabled = false;
    });
}

function clearEntireCart() {
    if (!confirm('Yakin ingin mengosongkan keranjang?')) return;
    
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
        if (data.success) {
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.value = 0;
            });
            document.querySelectorAll('.item-note-badge').forEach(badge => {
                badge.style.display = 'none';
            });
            document.querySelectorAll('input[id^="hidden-note-"]').forEach(note => {
                note.value = '';
            });
            updateCartUI(0, 0);
            showToast('Keranjang Dikosongkan', '#DC2626');
        }
    })
    .catch(error => console.error('Clear Cart Error:', error));
}

function updateCartUI(count, total) {
    const navCount = document.getElementById('nav-cart-count');
    if (navCount) {
        navCount.textContent = count;
        navCount.style.transform = 'scale(1.35)';
        setTimeout(() => { navCount.style.transform = 'scale(1)'; }, 200);
    }
    
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
    
    const clearBtn = document.querySelector('.page-header .btn-outline-danger');
    if (clearBtn) {
        clearBtn.style.display = count > 0 ? 'inline-block' : 'none';
    } else if (count > 0) {
        const header = document.querySelector('.page-header');
        if (header) {
            const btnHtml = `<button type="button" class="btn btn-outline-danger btn-sm mt-2" onclick="clearEntireCart()"><i class="fas fa-trash-alt me-1"></i> Kosongkan Keranjang</button>`;
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
    toast.style.fontSize = '0.9rem';
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        setTimeout(() => toast.remove(), 350);
    }, 1800);
}
</script>
@endpush
@endsection
