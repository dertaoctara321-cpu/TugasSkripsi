@extends('layouts.admin')

@section('title', 'Tambah Meja Baru')

@section('content')
<div class="card">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Ups!</strong> Ada masalah dengan input Anda.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tables.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nomor Meja:</label>
                <input type="text" name="table_number" class="form-control" placeholder="contoh: 1, 2, A1" required>
            </div>
            
            <button type="submit" class="btn btn-primary mt-3">Generate QR & Simpan</button>
            <a class="btn btn-secondary mt-3" href="{{ route('tables.index') }}">Kembali</a>
        </form>
    </div>
</div>
@endsection
