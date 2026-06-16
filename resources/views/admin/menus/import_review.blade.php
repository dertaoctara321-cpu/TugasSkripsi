@extends('layouts.admin')

@section('title', 'Review Hasil Import PDF')

@section('content')
<style>
    .review-table input, .review-table select {
        font-size: 0.92rem;
        padding: 6px 10px;
        border-radius: 8px;
        border: 1.5px solid #e0e0e0;
        width: 100%;
        transition: border-color 0.2s;
    }
    .review-table input:focus, .review-table select:focus {
        border-color: var(--admin-primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(255,140,66,0.15);
    }
    .review-table td {
        vertical-align: middle;
        padding: 8px 6px;
    }
    .review-table thead th {
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #555;
        background: #f8f8f8;
        padding: 12px 8px;
    }
    .row-delete-btn {
        background: none;
        border: none;
        color: #dc3545;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 6px;
        transition: background 0.2s;
    }
    .row-delete-btn:hover { background: rgba(220,53,69,0.1); }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #888;
    }
    .counter-badge {
        display: inline-block;
        background: var(--admin-primary);
        color: white;
        border-radius: 20px;
        padding: 2px 12px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-left: 8px;
    }
</style>

<div class="card" style="animation: fadeIn 0.5s ease;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="fas fa-file-pdf" style="color:#e53935;"></i>
            Review Hasil Import PDF
            <span class="counter-badge" id="rowCount">{{ count($items) }} item</span>
        </h3>
        <a href="{{ route('menus.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Batal
        </a>
    </div>

    <div class="card-body">
        @if(count($items) === 0)
            <div class="empty-state">
                <i class="fas fa-robot" style="font-size: 4rem; color:#ddd; display:block; margin-bottom:16px;"></i>
                <h5>OCR tidak menemukan item menu</h5>
                <p>Coba upload ulang PDF-nya, atau tambahkan menu secara manual.</p>
                <a href="{{ route('menus.index') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Menu
                </a>
            </div>
        @else
            <div class="alert alert-info mb-3" style="border-radius:10px;">
                <i class="fas fa-info-circle"></i>
                <strong>Hasil OCR mungkin tidak 100% akurat</strong> — silakan edit tiap baris sebelum menyimpan.
                Baris yang nama-nya kosong akan otomatis dilewati.
            </div>

            <form action="{{ route('menus.importPdfSave') }}" method="POST" id="importForm">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover review-table" id="reviewTable">
                        <thead>
                            <tr>
                                <th style="width:28%">Nama Menu</th>
                                <th style="width:10%">Harga (Rp)</th>
                                <th style="width:14%">Kategori</th>
                                <th style="width:18%">Sub Kategori</th>
                                <th style="width:25%">Deskripsi</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach($items as $i => $item)
                            <tr>
                                <td>
                                    <input type="text"
                                           name="names[]"
                                           value="{{ $item['name'] ?? '' }}"
                                           placeholder="Nama menu...">
                                </td>
                                <td>
                                    <input type="number"
                                           name="prices[]"
                                           value="{{ $item['price'] ?? 0 }}"
                                           placeholder="0"
                                           min="0"
                                           step="500">
                                </td>
                                <td>
                                    <select name="categories[]">
                                        <option value="Makanan" {{ ($item['category'] ?? '') === 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                        <option value="Minuman" {{ ($item['category'] ?? '') === 'Minuman' ? 'selected' : '' }}>Minuman</option>
                                        <option value="Camilan" {{ ($item['category'] ?? '') === 'Camilan' ? 'selected' : '' }}>Camilan</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text"
                                           name="sub_categories[]"
                                           value="{{ $item['sub_category'] ?? '' }}"
                                           placeholder="Cth: Menu Sarapan"
                                           list="subcat-list">
                                </td>
                                <td>
                                    <input type="text"
                                           name="descriptions[]"
                                           value="{{ $item['description'] ?? '' }}"
                                           placeholder="Deskripsi singkat...">
                                </td>
                                <td>
                                    <button type="button" class="row-delete-btn" onclick="deleteRow(this)" title="Hapus baris">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Datalist for sub_category autocomplete --}}
                <datalist id="subcat-list">
                    <option value="Menu Pakam">
                    <option value="Menu Sarapan">
                    <option value="Main Course">
                    <option value="Nasi Goreng">
                    <option value="Pasta & Mie">
                    <option value="Palembang Nian">
                    <option value="Snack">
                    <option value="Western & Fusion">
                    <option value="Little Coconut">
                    <option value="Coffee & Minuman">
                </datalist>

                <div class="d-flex justify-content-between align-items-center mt-3 pt-3" style="border-top:1px solid #eee;">
                    <button type="button" class="btn btn-outline-secondary" onclick="addRow()">
                        <i class="fas fa-plus"></i> Tambah Baris
                    </button>

                    <button type="submit" class="btn btn-primary btn-lg" style="padding: 12px 35px;">
                        <i class="fas fa-save"></i> Simpan Semua Menu
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
function updateCounter() {
    const count = document.querySelectorAll('#tableBody tr').length;
    document.getElementById('rowCount').textContent = count + ' item';
}

function deleteRow(btn) {
    btn.closest('tr').remove();
    updateCounter();
}

function addRow() {
    const tbody = document.getElementById('tableBody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input type="text" name="names[]" placeholder="Nama menu..."></td>
        <td><input type="number" name="prices[]" value="0" min="0" step="500"></td>
        <td>
            <select name="categories[]">
                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
                <option value="Camilan">Camilan</option>
            </select>
        </td>
        <td><input type="text" name="sub_categories[]" placeholder="Sub kategori..." list="subcat-list"></td>
        <td><input type="text" name="descriptions[]" placeholder="Deskripsi..."></td>
        <td><button type="button" class="row-delete-btn" onclick="deleteRow(this)"><i class="fas fa-times"></i></button></td>
    `;
    tbody.appendChild(tr);
    updateCounter();
    // Focus nama field
    tr.querySelector('input[name="names[]"]').focus();
}

// Confirm before submit
document.getElementById('importForm')?.addEventListener('submit', function(e) {
    const filled = [...document.querySelectorAll('input[name="names[]"]')]
        .filter(i => i.value.trim() !== '').length;
    if (filled === 0) {
        e.preventDefault();
        alert('Minimal isi 1 nama menu sebelum menyimpan.');
        return;
    }
});
</script>
@endpush
