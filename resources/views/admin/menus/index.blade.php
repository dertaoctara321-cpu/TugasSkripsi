@extends('layouts.admin')

@section('title', 'Daftar Menu')

@section('content')
<style>
    .menu-grid {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .menu-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        height: 100%;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .menu-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .menu-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--admin-primary);
    }

    .menu-category {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
        color: white;
    }

    .stock-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
    }
</style>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-utensils"></i> Daftar Menu</h3>
        <div class="card-tools d-flex gap-2">
            {{-- PDF Import: hidden form + button --}}
            <form action="{{ route('menus.importPdfProcess') }}" method="POST" enctype="multipart/form-data" id="pdfImportForm">
                @csrf
                <input type="file" id="pdfFileInput" name="file" accept=".pdf" style="display:none;"
                       onchange="this.form.submit()">
                <button type="button"
                        onclick="document.getElementById('pdfFileInput').click()"
                        class="btn btn-success"
                        id="importPdfBtn">
                    <i class="fas fa-file-pdf"></i> Import dari PDF
                </button>
            </form>

            <a href="{{ route('menus.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Menu Baru
            </a>

            {{-- Bulk Image Upload: hidden form + button --}}
            <form action="{{ route('menus.bulkImageUpload') }}" method="POST" enctype="multipart/form-data" id="bulkImageForm">
                @csrf
                <input type="file" id="bulkImageInput" name="images[]" multiple accept="image/*" style="display:none;"
                       onchange="this.form.submit()">
                <button type="button" 
                        onclick="document.getElementById('bulkImageInput').click()" 
                        class="btn btn-warning" 
                        title="Upload gambar (Nama file wajib ID menu. Misal: 25.jpg untuk menu ID 25)">
                    <i class="fas fa-images"></i> Bulk Upload Gambar
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ $message }}
            </div>
        @endif
        @if ($message = Session::get('warning'))
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-3">
                <select id="filterCategory" class="form-control" onchange="filterMenus()">
                    <option value="all">Semua Kategori</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Camilan">Camilan</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterSubCategory" class="form-control" onchange="filterMenus()">
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
            <div class="col-md-6 text-right">
                <small class="text-muted d-block mt-2">Gunakan fitur <b>Bulk Upload Gambar</b> di atas. Ubah nama gambar PDF dengan angka ID Menu.</small>
            </div>
        </div>

        <div class="row menu-grid" id="menuGrid">
            @forelse ($menus as $menu)
            <div class="col-md-4 mb-4 menu-item-container" data-category="{{ $menu->category }}" data-subcategory="{{ $menu->sub_category }}">
                <div class="card menu-card">
                    <div style="position: relative;">
                        @if($menu->image)
                            <img src="/images/{{ $menu->image }}" class="menu-image" alt="{{ $menu->name }}">
                        @else
                            <div class="menu-image" style="background: linear-gradient(135deg, #e0e0e0, #bdbdbd); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-utensils" style="font-size: 4rem; color: #999;"></i>
                            </div>
                        @endif
                        
                        <span class="stock-badge badge-{{ $menu->is_available ? 'success' : 'danger' }}">
                            {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                        </span>
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title" style="font-weight: 700; margin-bottom: 10px;">{{ $menu->name }}</h5>
                        
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="menu-category">{{ $menu->category }}</span>
                            <span class="badge badge-secondary">ID: {{ $menu->id }}</span>
                        </div>
                        
                        <div class="menu-price mb-3">
                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-info btn-sm flex-fill">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-block" onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Belum ada menu. Silakan tambah menu baru.
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
function filterMenus() {
    const cat = document.getElementById('filterCategory').value;
    const subSelect = document.getElementById('filterSubCategory');
    let sub = subSelect.value;
    
    // Filter subcategory dropdown choices
    Array.from(subSelect.options).forEach(opt => {
        if (opt.value === 'all') return;
        
        if (cat === 'all' || opt.getAttribute('data-category') === cat) {
            opt.style.display = '';
        } else {
            opt.style.display = 'none';
            // If the active subcategory is now hidden, reset to 'all'
            if (sub === opt.value) {
                subSelect.value = 'all';
                sub = 'all';
            }
        }
    });
    
    // Filter cards
    document.querySelectorAll('.menu-item-container').forEach(el => {
        const rowCat = el.getAttribute('data-category');
        const rowSub = el.getAttribute('data-subcategory');
        
        let matchCat = (cat === 'all' || rowCat === cat);
        let matchSub = (sub === 'all' || rowSub === sub);
        
        if (matchCat && matchSub) {
            el.style.display = 'block';
        } else {
            el.style.display = 'none';
        }
    });
}

// Show loading state when PDF is submitted (OCR can take 1–2 min)
document.getElementById('pdfFileInput').addEventListener('change', function () {
    if (!this.files.length) return;
    const btn = document.getElementById('importPdfBtn');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses PDF...';
    btn.disabled = true;
});

// Show loading state when Bulk Image is selected
document.getElementById('bulkImageInput').addEventListener('change', function () {
    if (!this.files.length) return;
    const btn = document.querySelector('button[title*="Upload gambar"]');
    if(btn) {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
        btn.disabled = true;
    }
});
</script>
@endpush
