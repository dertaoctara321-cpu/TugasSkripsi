@extends('layouts.admin')

@section('title', 'Metode Pembayaran')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Metode Pembayaran</h3>
        <div class="card-tools">
            <a href="{{ route('payment-methods.create') }}" class="btn btn-primary btn-sm">Tambah Metode Baru</a>
        </div>
    </div>
    <div class="card-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Detail</th>
                        <th>QR Code</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentMethods as $method)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $method->name }}</td>
                        <td>
                            @if($method->type == 'bank_transfer')
                                <span class="badge badge-primary">Transfer Bank</span>
                            @elseif($method->type == 'qris')
                                <span class="badge badge-info">QRIS</span>
                            @else
                                <span class="badge badge-success">Cash</span>
                            @endif
                        </td>
                        <td>
                            @if($method->type == 'bank_transfer')
                                <strong>No. Rek:</strong> {{ $method->account_number }}<br>
                                <strong>Atas Nama:</strong> {{ $method->account_name }}
                            @elseif($method->type == 'qris')
                                QRIS {{ $method->name }}
                            @else
                                Bayar di Kasir
                            @endif
                        </td>
                        <td>
                            @if($method->qr_code_image)
                                <img src="{{ asset($method->qr_code_image) }}" width="80px" alt="QR Code">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($method->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('payment-methods.edit', $method->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('payment-methods.destroy', $method->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
