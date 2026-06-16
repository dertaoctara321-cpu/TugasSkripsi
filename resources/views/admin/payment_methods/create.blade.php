@extends('layouts.admin')

@section('title', 'Tambah Metode Pembayaran')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Metode Pembayaran Baru</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('payment-methods.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label>Nama Metode Pembayaran</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Bank BCA, QRIS Dana" required>
                <small class="text-muted">Contoh: "Bank BCA", "QRIS Dana", "GoPay"</small>
            </div>

            <div class="form-group">
                <label>Tipe</label>
                <select name="type" id="payment_type" class="form-control" required>
                    <option value="bank_transfer">Transfer Bank</option>
                    <option value="qris">QRIS</option>
                    <option value="cash">Cash</option>
                </select>
            </div>

            <div class="form-group" id="bank_fields">
                <label>Nomor Rekening</label>
                <input type="text" name="account_number" class="form-control" placeholder="1234567890">
            </div>

            <div class="form-group" id="account_name_field">
                <label>Atas Nama</label>
                <input type="text" name="account_name" class="form-control" placeholder="PT Little Palembang">
            </div>

            <div class="form-group" id="qr_field">
                <label>Upload QR Code (Opsional)</label>
                <input type="file" name="qr_code_image" class="form-control" accept="image/*">
                <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
            </div>

            <div class="form-group">
                <label>Instruksi Tambahan (Opsional)</label>
                <textarea name="instructions" class="form-control" rows="3" placeholder="Contoh: Silakan transfer ke rekening di atas dan konfirmasi ke kasir"></textarea>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('payment-methods.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
document.getElementById('payment_type').addEventListener('change', function() {
    const type = this.value;
    const bankFields = document.getElementById('bank_fields');
    const accountNameField = document.getElementById('account_name_field');
    const qrField = document.getElementById('qr_field');
    
    if (type === 'bank_transfer') {
        bankFields.style.display = 'block';
        accountNameField.style.display = 'block';
        qrField.style.display = 'none';
    } else if (type === 'qris') {
        bankFields.style.display = 'none';
        accountNameField.style.display = 'none';
        qrField.style.display = 'block';
    } else {
        bankFields.style.display = 'none';
        accountNameField.style.display = 'none';
        qrField.style.display = 'none';
    }
});
</script>
@endsection
