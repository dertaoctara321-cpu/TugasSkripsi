@extends('layouts.admin')

@section('title', Auth::user()->isKasir() ? 'Status Meja Kafe' : 'Meja & QR Code')

@section('content')
<div class="card card-red">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title text-white mb-0">
            <i class="fas fa-chair mr-2"></i> 
            {{ Auth::user()->isKasir() ? 'Status Ketersediaan Meja' : 'Daftar Meja & QR Code Pemesanan' }}
        </h3>
        @if(Auth::user()->isAdmin())
        <div class="card-tools ml-auto">
            <a href="{{ route('tables.create') }}" class="btn btn-light btn-sm" style="color: #DC2626; font-weight: 700;">
                <i class="fas fa-plus mr-1"></i> Tambah Meja Baru
            </a>
        </div>
        @endif
    </div>
    <div class="card-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle mr-1"></i> {{ $message }}
            </div>
        @endif
        
        <!-- Desktop Table View -->
        <div class="d-none d-lg-block">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nomor Meja</th>
                            <th>QR Code</th>
                            <th>Link Pemesanan Pelanggan</th>
                            <th>Status Meja</th>
                            <th class="text-center" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tables as $table)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong style="font-size: 1.1rem;"><i class="fas fa-chair text-danger mr-1"></i> Meja {{ $table->table_number }}</strong></td>
                            <td class="text-center">
                                @php
                                    $orderUrl = $baseUrl . '/order/' . $table->uuid;
                                    $qrImgUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($orderUrl);
                                @endphp
                                <div class="text-center p-2 rounded" style="display: inline-block; background: #FFF1F2; border: 1px solid #FECDD3;">
                                    <img src="{{ $qrImgUrl }}" width="90px" alt="QR Meja {{ $table->table_number }}" class="rounded">
                                </div>
                                <br>
                                <button type="button" onclick="downloadQR('{{ $qrImgUrl }}', '{{ $table->table_number }}', this)" class="btn btn-sm btn-outline-danger mt-1">
                                    <i class="fas fa-download"></i> Unduh QR
                                </button>
                            </td>
                            <td>
                                <a href="{{ $orderUrl }}" target="_blank" class="btn btn-sm btn-primary mb-1">
                                    <i class="fas fa-external-link-alt"></i> Buka Menu Pelanggan
                                </a>
                                <br>
                                <small class="text-muted">{{ $orderUrl }}</small>
                            </td>
                            <td>
                                @if($table->status == 'occupied')
                                    <span class="badge badge-danger p-2"><i class="fas fa-user-check mr-1"></i> Terisi (Occupied)</span>
                                @else
                                    <span class="badge badge-success p-2"><i class="fas fa-check mr-1"></i> Tersedia (Available)</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    @if($table->status == 'occupied')
                                        <form action="{{ route('tables.clear', $table->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm font-weight-bold" onclick="return confirm('Kosongkan meja {{ $table->table_number }}?')">
                                                <i class="fas fa-broom mr-1"></i> Kosongkan
                                            </button>
                                        </form>
                                    @endif

                                    @if(Auth::user()->isAdmin())
                                    <form action="{{ route('tables.destroy', $table->id) }}" method="POST" style="display:inline; margin-left: 4px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus meja ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada meja yang terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="d-lg-none">
            @forelse ($tables as $table)
            <div class="card mb-3" style="border-left: 5px solid #DC2626;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title font-weight-bold text-danger mb-0">
                            <i class="fas fa-chair mr-1"></i> Meja {{ $table->table_number }}
                        </h5>
                        @if($table->status == 'occupied')
                            <span class="badge badge-danger">Terisi</span>
                        @else
                            <span class="badge badge-success">Tersedia</span>
                        @endif
                    </div>
                    
                    <div class="mb-3 text-center">
                        @php
                            $orderUrl = $baseUrl . '/order/' . $table->uuid;
                            $qrImgUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($orderUrl);
                        @endphp
                        <div class="text-center p-2 rounded mb-2" style="display: inline-block; background: #FFF1F2; border: 1px solid #FECDD3;">
                            <img src="{{ $qrImgUrl }}" width="130px" class="img-fluid rounded" alt="QR Meja {{ $table->table_number }}">
                        </div>
                        <br>
                        <button type="button" onclick="downloadQR('{{ $qrImgUrl }}', '{{ $table->table_number }}', this)" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-download mr-1"></i> Unduh QR Code
                        </button>
                    </div>

                    <div class="mb-3">
                        <a href="{{ $orderUrl }}" target="_blank" class="btn btn-primary btn-block">
                            <i class="fas fa-external-link-alt mr-1"></i> Buka Menu Pelanggan
                        </a>
                    </div>

                    <div class="btn-group btn-block" role="group">
                        @if($table->status == 'occupied')
                            <form action="{{ route('tables.clear', $table->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-block font-weight-bold" onclick="return confirm('Kosongkan meja {{ $table->table_number }}?')">
                                    <i class="fas fa-broom mr-1"></i> Kosongkan
                                </button>
                            </form>
                        @endif
                        @if(Auth::user()->isAdmin())
                        <form action="{{ route('tables.destroy', $table->id) }}" method="POST" style="flex: 1; margin-left: 4px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Yakin ingin menghapus meja ini?')">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-4 text-muted">Belum ada meja.</div>
            @endforelse
        </div>
    </div>
</div>

@push('js')
<script>
function downloadQR(qrUrl, tableNumber, btn) {
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    btn.disabled = true;

    const img = new Image();
    img.crossOrigin = "Anonymous";
    img.onload = function() {
        const canvas = document.createElement("canvas");
        const ctx = canvas.getContext("2d");
        
        const padding = 20;
        const textHeight = 40;
        const width = img.width + (padding * 2);
        const height = img.height + textHeight + (padding * 2);

        canvas.width = width;
        canvas.height = height;

        // Draw white background
        ctx.fillStyle = "#ffffff";
        ctx.fillRect(0, 0, width, height);

        // Draw text
        ctx.fillStyle = "#000000";
        ctx.font = "bold 24px Arial, sans-serif";
        ctx.textAlign = "center";
        ctx.textBaseline = "top";
        ctx.fillText("Meja " + tableNumber, width / 2, padding);

        // Draw image
        ctx.drawImage(img, padding, padding + textHeight);

        // Convert and download
        const dataUrl = canvas.toDataURL("image/png");
        const a = document.createElement("a");
        a.href = dataUrl;
        a.download = "QR_Meja_" + tableNumber + ".png";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);

        btn.innerHTML = originalText;
        btn.disabled = false;
    };
    img.onerror = function() {
        alert("Gagal memuat QR Code. Silakan coba lagi.");
        btn.innerHTML = originalText;
        btn.disabled = false;
    };
    
    // Cache buster for CORS
    img.src = qrUrl + "&_t=" + new Date().getTime(); 
}
</script>
@endpush
@endsection
