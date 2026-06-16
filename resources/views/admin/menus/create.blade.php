@extends('layouts.admin')

@section('title', 'Tambah Menu Baru')

@section('content')
<style>
    .form-card {
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

    .form-control, .form-select {
        font-size: 1.1rem;
        padding: 12px 15px;
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        min-height: 50px;
        line-height: 1.5;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.2);
    }

    .form-select option {
        font-size: 1.1rem;
        padding: 12px;
        line-height: 2;
        min-height: 45px;
    }

    .form-label {
        font-weight: 600;
        color: var(--admin-secondary);
        margin-bottom: 8px;
        font-size: 1rem;
    }

    .image-preview {
        max-width: 300px;
        max-height: 300px;
        border-radius: 10px;
        margin-top: 10px;
        display: none;
    }
</style>

<div class="card form-card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus-circle"></i> Tambah Menu Baru</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> <strong>Ups!</strong> Ada masalah dengan input Anda.
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-utensils"></i> Nama Menu</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Cappuccino" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-money-bill-wave"></i> Harga</label>
                        <input type="number" name="price" class="form-control" placeholder="Contoh: 20000" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fas fa-align-left"></i> Deskripsi</label>
                <textarea class="form-control" style="height:120px; resize: vertical;" name="description" placeholder="Deskripsi menu..."></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-list"></i> Kategori</label>
                        <select name="category" class="form-control form-select" required>
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Camilan">Camilan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-tag"></i> Sub Kategori <small class="text-muted">(opsional)</small></label>
                        <input type="text" name="sub_category" class="form-control"
                               placeholder="Cth: Menu Sarapan, Main Course, dll"
                               list="subcat-list">
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
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-check-circle"></i> Ketersediaan</label>
                        <select name="is_available" class="form-control form-select" required>
                            <option value="1">Tersedia</option>
                            <option value="0">Tidak Tersedia</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label"><i class="fas fa-image"></i> Gambar Menu</label>
                <input type="file" name="image" class="form-control" accept="image/*" id="imageInput">
                <img id="imagePreview" class="image-preview" alt="Preview">
            </div>

            <hr style="margin: 25px 0;">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-lg" style="padding: 12px 30px;">
                    <i class="fas fa-save"></i> Simpan Menu
                </button>
                <a class="btn btn-secondary btn-lg" href="{{ route('menus.index') }}" style="padding: 12px 30px;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
// Image preview
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
