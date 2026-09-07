@extends('layouts.customer')

@section('title', 'Informasi Pembayaran')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4">
            <i class="fas fa-credit-card"></i> Informasi Pembayaran
        </h4>

        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Silakan lakukan pembayaran sesuai metode yang Anda pilih
        </div>

        @foreach($paymentMethods as $method)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">
                    @if($method->type == 'bank_transfer')
                        <i class="fas fa-university text-primary"></i>
                    @elseif($method->type == 'qris')
                        <i class="fas fa-qrcode text-info"></i>
                    @else
                        <i class="fas fa-money-bill text-success"></i>
                    @endif
                    {{ $method->name }}
                </h5>

                @if($method->type == 'bank_transfer')
                    <div class="mt-3">
                        <p class="mb-2"><strong>Nomor Rekening:</strong></p>
                        <h4 class="text-primary">{{ $method->account_number }}</h4>
                        <p class="mb-2"><strong>Atas Nama:</strong></p>
                        <p class="text-muted">{{ $method->account_name }}</p>
                    </div>
                @elseif($method->type == 'qris')
                    @if($method->qr_code_image)
                    <div class="text-center mt-3">
                        <p class="mb-2"><strong>Scan QR Code:</strong></p>
                        <img src="{{ asset($method->qr_code_image) }}" alt="{{ $method->name }}" class="img-fluid" style="max-width: 300px;">
                    </div>
                    @endif
                @else
                    <p class="text-muted">Bayar langsung di kasir</p>
                @endif

                @if($method->instructions)
                <div class="alert alert-light mt-3">
                    <small><i class="fas fa-info-circle"></i> {{ $method->instructions }}</small>
                </div>
                @endif
            </div>
        </div>
        @endforeach

        <div class="d-grid gap-2 mt-4">
            <a href="{{ route('order.index', request()->route('uuid')) }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali ke Menu
            </a>
        </div>
    </div>
</div>
@endsection
