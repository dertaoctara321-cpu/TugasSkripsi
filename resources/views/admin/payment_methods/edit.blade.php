@extends('layouts.admin')

@section('title', 'Edit Metode Pembayaran')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Metode Pembayaran</h3>
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

        <form action="{{ route('payment-methods.update', $paymentMethod->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Nama Metode Pembayaran</label>
                <input type="text" name="name" class="form-control" value="{{ $paymentMethod->name }}" required>
            </div>

            <div class="form-group">
                <label>Tipe</label>
                <select name="type" id="payment_type" class="form-control" required>
                    <option value="bank_transfer" {{ $paymentMethod->type == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="qris" {{ $paymentMethod->type == 'qris' ? 'selected' : '' }}>QRIS</option>
                    <option value="cash" {{ $paymentMethod->type == 'cash' ? 'selected' : '' }}>Cash</option>
                </select>
            </div>

            <div class="form-group" id="bank_fields" style="display: {{ $paymentMethod->type == 'bank_transfer' ? 'block' : 'none' }}">
                <label>Nomor Rekening</label>
                <input type="text" name="account_number" class="form-control" value="{{ $paymentMethod->account_number }}">
            </div>

            <div class="form-group" id="account_name_field" style="display: {{ $paymentMethod->type == 'bank_transfer' ? 'block' : 'none' }}">
                <label>Atas Nama</label>
                <input type="text" name="account_name" class="form-control" value="{{ $paymentMethod->account_name }}">
            </div>

            <div class="form-group" id="qr_field" style="display: {{ $paymentMethod->type == 'qris' ? 'block' : 'none' }}">
                <label>Upload QR Code Baru (Opsional)</label>
                @if($paymentMethod->qr_code_image)
                    <div class="mb-2">
                        <img src="{{ asset($paymentMethod->qr_code_image) }}" width="150px" alt="Current QR">
                        <p class="text-muted">QR Code saat ini</p>
                    </div>
                @endif
                <input type="file" name="qr_code_image" class="form-control" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
            </div>

            <div class="form-group">
                <label>Instruksi Tambahan (Opsional)</label>
                <textarea name="instructions" class="form-control" rows="3">{{ $paymentMethod->instructions }}</textarea>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1" {{ $paymentMethod->is_active ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$paymentMethod->is_active ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
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
