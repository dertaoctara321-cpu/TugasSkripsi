@extends('layouts.admin')

@section('title', 'Meja & QR')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Meja</h3>
        <div class="card-tools">
            <a href="{{ route('tables.create') }}" class="btn btn-primary btn-sm">Tambah Meja Baru</a>
        </div>
    </div>
    <div class="card-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        
        <!-- Desktop Table View -->
        <div class="d-none d-lg-block">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Meja</th>
                        <th>QR Code</th>
                        <th>URL Testing</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tables as $table)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $table->table_number }}</td>
                        <td>
                            @php
                                $orderUrl = $baseUrl . '/order/' . $table->uuid;
                                $qrImgUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($orderUrl);
                            @endphp
                            <div class="text-center" style="display: inline-block;">
                                <strong>Meja {{ $table->table_number }}</strong>
                                <br>
                                <img src="{{ $qrImgUrl }}" width="100px" alt="QR Meja {{ $table->table_number }}">
                            </div>
                            <br>
                            <button type="button" onclick="downloadQR('{{ $qrImgUrl }}', '{{ $table->table_number }}', this)" class="btn btn-sm btn-info mt-1">
                                <i class="fas fa-download"></i> Download QR
                            </button>
                        </td>
                        <td>
                            <a href="{{ $orderUrl }}" target="_blank" class="btn btn-sm btn-success">
                                <i class="fas fa-external-link-alt"></i> Buka Halaman Pemesanan
                            </a>
                            <br>
                            <small class="text-muted">{{ $orderUrl }}</small>
                        </td>
                        <td>
                            @if($table->status == 'occupied')
                                <span class="badge badge-danger">Terisi</span>
                            @else
                                <span class="badge badge-success">Tersedia</span>
                            @endif
                        </td>
                        <td>
                            @if($table->status == 'occupied')
                                <form action="{{ route('tables.clear', $table->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Kosongkan meja ini?')">
                                        <i class="fas fa-broom"></i> Kosongkan
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('tables.destroy',$table->id) }}" method="POST" style="display:inline;">
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

        <!-- Mobile Card View -->
        <div class="d-lg-none">
            @foreach ($tables as $table)
            <div class="card mb-3" style="border-left: 4px solid var(--admin-primary);">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-chair"></i> Meja {{ $table->table_number }}
                        @if($table->status == 'occupied')
                            <span class="badge badge-danger float-right">Terisi</span>
                        @else
                            <span class="badge badge-success float-right">Tersedia</span>
                        @endif
                    </h5>
                    
                    <div class="mb-3 text-center">
                        @php
                            $orderUrl = $baseUrl . '/order/' . $table->uuid;
                            $qrImgUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($orderUrl);
                        @endphp
                        <div class="text-center" style="display: inline-block;">
                            <strong>Meja {{ $table->table_number }}</strong>
                            <br>
                            <img src="{{ $qrImgUrl }}" width="150px" class="img-fluid" alt="QR Meja {{ $table->table_number }}">
                        </div>
                        <br>
                        <button type="button" onclick="downloadQR('{{ $qrImgUrl }}', '{{ $table->table_number }}', this)" class="btn btn-sm btn-info mt-2">
                            <i class="fas fa-download"></i> Download QR
                        </button>
                    </div>

                    <div class="mb-3">
                        <a href="{{ $orderUrl }}" target="_blank" class="btn btn-success btn-block">
                            <i class="fas fa-external-link-alt"></i> Buka Halaman Pemesanan
                        </a>
                    </div>

                    <div class="btn-group btn-block" role="group">
                        @if($table->status == 'occupied')
                            <form action="{{ route('tables.clear', $table->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-block" onclick="return confirm('Kosongkan meja ini?')">
                                    <i class="fas fa-broom"></i> Kosongkan
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('tables.destroy',$table->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
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
