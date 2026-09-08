@extends('layouts.customer')

@section('title', 'Checkout Pesanan - Little Palembang')

@section('content')
<style>
    .checkout-card {
        animation: fadeInUp 0.5s ease-out;
        border-radius: 18px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .checkout-card .card-title {
        font-weight: 800;
        background: linear-gradient(135deg, #DC2626, #991B1B);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .total-amount {
        font-size: 1.35rem;
        font-weight: 800;
        color: #DC2626 !important;
    }

    .form-control, .form-select {
        border-radius: 12px;
        border: 1.5px solid #E2E8F0;
        padding: 12px 16px;
        transition: all 0.25s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #DC2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
    }

    .btn-submit {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 50%, #B91C1C 100%) !important;
        border: none;
        border-radius: 12px;
        padding: 15px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.25s ease;
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(220, 38, 38, 0.55);
    }

    /* Payment guide cards */
    .payment-guide-box {
        border-radius: 14px;
        padding: 16px;
        margin-top: 14px;
        transition: all 0.3s ease;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .payment-guide-cash {
        background: #F0FDF4;
        border: 1.5px solid #BBF7D0;
        color: #166534;
    }

    .payment-guide-qris {
        background: #FEF2F2;
        border: 1.5px solid #FECDD3;
        color: #991B1B;
    }

    .payment-guide-transfer {
        background: #EFF6FF;
        border: 1.5px solid #BFDBFE;
        color: #1E40AF;
    }

    .qris-display-frame {
        background: #ffffff;
        padding: 14px;
        border-radius: 12px;
        border: 2px solid #DC2626;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.15);
    }

    .copy-acc-btn {
        transition: all 0.2s ease;
    }
    .copy-acc-btn:hover {
        transform: scale(1.05);
    }

    /* Mobile responsiveness */
    @media (max-width: 576px) {
        .checkout-card {
            border-radius: 14px;
        }
        .checkout-card .card-body {
            padding: 14px !important;
        }
        .checkout-table th, .checkout-table td {
            padding: 8px 6px !important;
            font-size: 0.85rem;
        }
        .total-amount {
            font-size: 1.15rem;
        }
        .qris-display-frame {
            padding: 10px;
            max-width: 100%;
        }
        .qris-display-frame img, .qris-display-frame svg {
            max-width: 220px !important;
            max-height: 220px !important;
        }
        .btn-submit {
            padding: 12px;
            font-size: 1rem;
        }
    }
</style>

<div class="card checkout-card">
    <div class="card-body p-4">
        <h4 class="card-title mb-4"><i class="fas fa-shopping-bag text-danger me-2"></i> Konfirmasi Pesanan Anda</h4>
        
        @if(!empty($cart))
            @php 
                $activeOrder = null;
                if ($table->status == 'occupied') {
                    $activeOrder = \App\Models\Order::where('table_id', $table->id)->latest()->first();
                }
            @endphp

            @if($activeOrder)
            <div class="alert alert-info mb-4" style="border-radius: 12px; border-left: 4px solid #DC2626; background: #FFF1F2; color: #991B1B;">
                <i class="fas fa-info-circle me-1"></i> <strong>Pesanan Aktif:</strong> Anda sudah memiliki pesanan yang sedang berjalan. 
                Menu baru yang Anda checkout akan ditambahkan ke pesanan meja Anda.
            </div>
            @endif

            <div class="table-responsive">
                <table class="table checkout-table">
                    <thead>
                        <tr style="background: #FFF1F2; color: #991B1B;">
                            <th>Item Menu & Catatan</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0 @endphp
                        @foreach($cart as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr>
                                <td>
                                    <strong class="d-block" style="font-size: 1rem;">{{ $details['name'] }}</strong>
                                    @if(!empty($details['notes']))
                                        <div class="small text-danger fw-semibold mt-1">
                                            <i class="fas fa-pen-nib me-1"></i> Catatan: {{ $details['notes'] }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center font-weight-bold">{{ $details['quantity'] }}x</td>
                                <td class="text-end">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                <td class="text-end font-weight-bold" style="color: #DC2626;">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">{{ $activeOrder ? 'Total Item Baru' : 'Grand Total' }}</td>
                            <td class="total-amount text-end">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                        @if($activeOrder)
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total Pesanan Sebelumnya</td>
                            <td class="fw-bold text-end">Rp {{ number_format($activeOrder->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr style="background: #FFF1F2;">
                            <td colspan="3" class="text-end fw-bold" style="color: #991B1B; font-size: 1.15rem;">TOTAL KESELURUHAN</td>
                            <td class="total-amount text-end">Rp {{ number_format($total + $activeOrder->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    </tfoot>
                </table>
            </div>

            <form action="{{ route('order.placeOrder', request()->route('uuid')) }}" method="POST" class="mt-4" id="checkoutOrderForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Pemesan <span class="text-danger">*</span></label>
                    <input type="text" name="customer_name" class="form-control" 
                           placeholder="Contoh: Budi" 
                           value="{{ $activeOrder ? $activeOrder->customer_name : '' }}"
                           {{ $activeOrder ? 'readonly' : 'required' }}>
                    @if($activeOrder)
                    <small class="text-muted">Nama disesuaikan dengan pesanan aktif sebelumnya</small>
                    @endif
                </div>

                <!-- Lokasi Meja & Lantai Otomatis -->
                <div class="mb-3 p-3 rounded" style="background: #FFF1F2; border: 1.5px solid #FECDD3;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Lokasi Meja Pemesanan</small>
                            <h5 class="mb-0 fw-bold text-danger">
                                <i class="fas fa-chair me-1"></i> Meja {{ $table->table_number }}
                            </h5>
                        </div>
                        <div>
                            <span class="badge {{ (int)$table->table_number <= 18 ? 'bg-info' : 'bg-primary' }} p-2" style="font-size: 0.9rem; font-weight: 700;">
                                <i class="fas fa-layer-group me-1"></i> {{ $table->floor }}
                            </span>
                        </div>
                    </div>
                    <input type="hidden" name="floor" value="{{ $table->floor }}">
                </div>

                <!-- Metode Pembayaran & Panduan Lengkap -->
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        Pilihan Metode Pembayaran <span class="text-danger">*</span>
                    </label>
                    
                    <select name="payment_method_id" id="paymentMethodSelect" class="form-select" {{ $activeOrder ? 'disabled' : 'required' }} onchange="renderPaymentGuide()">
                        @if($paymentMethods->count() > 0)
                            @foreach($paymentMethods as $pm)
                                <option value="{{ $pm->id }}" 
                                        data-type="{{ $pm->type }}"
                                        data-account-number="{{ $pm->account_number }}"
                                        data-account-name="{{ $pm->account_name }}"
                                        data-instructions="{{ $pm->instructions }}"
                                        data-qr-image="{{ $pm->qr_code_image ? asset($pm->qr_code_image) : '' }}"
                                        {{ $activeOrder && strtolower($activeOrder->payment_method) == strtolower($pm->name) ? 'selected' : '' }}>
                                    {{ $pm->name }} ({{ strtoupper(str_replace('_', ' ', $pm->type)) }})
                                </option>
                            @endforeach
                        @else
                            <option value="" data-type="cash">Cash (Bayar di Kasir / Waiter)</option>
                        @endif
                    </select>

                    @if($activeOrder)
                    <small class="text-muted d-block mt-1">Metode pembayaran mengikuti pesanan aktif meja Anda</small>
                    @endif

                    <!-- Kotak Panduan Pembayaran Dinamis (Cash / QRIS / Transfer) -->
                    <div id="paymentGuideContainer"></div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg btn-submit text-white">
                        <i class="fas fa-check-circle me-1"></i> {{ $activeOrder ? 'Tambahkan ke Pesanan' : 'Konfirmasi & Pesan Sekarang' }}
                    </button>
                    <a href="{{ route('order.index', request()->route('uuid')) }}" class="btn btn-outline-secondary" style="border-radius: 12px; font-weight: 600; padding: 10px;">
                        <i class="fas fa-arrow-left me-1"></i> Kembali Pilih Menu
                    </a>
                </div>
            </form>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-bag fa-3x mb-3 text-muted"></i>
                <p class="text-muted">Keranjang Anda kosong.</p>
                <a href="{{ route('order.index', request()->route('uuid')) }}" class="btn btn-primary">
                    <i class="fas fa-utensils me-1"></i> Lihat Daftar Menu
                </a>
            </div>
        @endif
    </div>
</div>

@push('js')
<script>
const currentGrandTotal = {{ $activeOrder ? ($total + $activeOrder->total_amount) : $total }};
const tableNumber = "{{ $table->table_number }}";

function renderPaymentGuide() {
    const select = document.getElementById('paymentMethodSelect');
    if (!select) return;

    const selectedOption = select.options[select.selectedIndex];
    if (!selectedOption) return;

    const type = selectedOption.getAttribute('data-type') || 'cash';
    const accNum = selectedOption.getAttribute('data-account-number') || '';
    const accName = selectedOption.getAttribute('data-account-name') || 'Little Palembang Cafe';
    const instructions = selectedOption.getAttribute('data-instructions') || '';
    const qrImage = selectedOption.getAttribute('data-qr-image') || '';
    const container = document.getElementById('paymentGuideContainer');
    
    if (!container) return;

    let html = '';

    if (type === 'cash') {
        html = `
        <div class="payment-guide-box payment-guide-cash">
            <div class="d-flex align-items-center mb-2">
                <i class="fas fa-money-bill-wave fa-2x me-3 text-success"></i>
                <div>
                    <h6 class="fw-bold mb-0 text-success">💵 Petunjuk Pembayaran Tunai (Cash)</h6>
                    <small class="text-muted">Dapat dibayar di kasir atau ke pelayan</small>
                </div>
            </div>
            <ul class="mb-0 ps-3" style="font-size: 0.88rem; line-height: 1.5;">
                <li>Pesanan akan langsung diproses oleh koki dapur setelah Anda menekan tombol <strong>Pesan Sekarang</strong>.</li>
                <li>Silakan menuju meja kasir Little Palembang dengan menyebutkan <strong>Meja ${tableNumber}</strong>.</li>
                <li>Atau bayar dengan uang pas langsung ke Pelayan (Waiter) saat pesanan diantarkan ke meja Anda.</li>
            </ul>
        </div>
        `;
    } else if (type === 'qris') {
        const qrDisplayContent = qrImage ? `
            <div class="my-2 p-2 bg-white rounded border d-inline-block shadow-sm">
                <img src="${qrImage}" alt="QRIS ${accName}" class="img-fluid rounded" style="max-width: 260px; max-height: 280px; object-fit: contain; display: block; margin: 0 auto;">
            </div>
        ` : `
            <!-- Standard QR Code SVG representation for Little Palembang -->
            <svg width="180" height="180" viewBox="0 0 180 180" fill="none" xmlns="http://www.w3.org/2000/svg" class="img-fluid my-2">
                <rect width="180" height="180" fill="white"/>
                <!-- Finder top-left -->
                <rect x="15" y="15" width="45" height="45" fill="#000000" rx="6"/>
                <rect x="23" y="23" width="29" height="29" fill="#ffffff" rx="3"/>
                <rect x="30" y="30" width="15" height="15" fill="#DC2626" rx="2"/>
                <!-- Finder top-right -->
                <rect x="120" y="15" width="45" height="45" fill="#000000" rx="6"/>
                <rect x="128" y="23" width="29" height="29" fill="#ffffff" rx="3"/>
                <rect x="135" y="30" width="15" height="15" fill="#DC2626" rx="2"/>
                <!-- Finder bottom-left -->
                <rect x="15" y="120" width="45" height="45" fill="#000000" rx="6"/>
                <rect x="23" y="128" width="29" height="29" fill="#ffffff" rx="3"/>
                <rect x="30" y="135" width="15" height="15" fill="#DC2626" rx="2"/>
                <!-- QR Data patterns -->
                <rect x="70" y="20" width="10" height="10" fill="#000000"/>
                <rect x="90" y="20" width="10" height="10" fill="#000000"/>
                <rect x="80" y="35" width="10" height="10" fill="#000000"/>
                <rect x="100" y="35" width="10" height="10" fill="#000000"/>
                <rect x="70" y="50" width="20" height="10" fill="#000000"/>
                <rect x="20" y="70" width="10" height="20" fill="#000000"/>
                <rect x="35" y="80" width="15" height="10" fill="#000000"/>
                <rect x="55" y="70" width="10" height="10" fill="#000000"/>
                <rect x="75" y="70" width="30" height="30" fill="#DC2626" rx="4"/>
                <circle cx="90" cy="85" r="8" fill="#ffffff"/>
                <rect x="115" y="75" width="20" height="10" fill="#000000"/>
                <rect x="145" y="70" width="15" height="15" fill="#000000"/>
                <rect x="120" y="95" width="10" height="15" fill="#000000"/>
                <rect x="70" y="110" width="15" height="10" fill="#000000"/>
                <rect x="95" y="110" width="20" height="15" fill="#000000"/>
                <rect x="130" y="120" width="15" height="10" fill="#000000"/>
                <rect x="150" y="135" width="10" height="20" fill="#000000"/>
                <rect x="70" y="135" width="25" height="10" fill="#000000"/>
                <rect x="105" y="145" width="20" height="10" fill="#000000"/>
                <rect x="80" y="155" width="15" height="10" fill="#000000"/>
            </svg>
        `;

        html = `
        <div class="payment-guide-box payment-guide-qris text-center">
            <div class="d-flex align-items-center justify-content-center mb-2">
                <i class="fas fa-qrcode fa-2x me-2 text-danger"></i>
                <h6 class="fw-bold mb-0 text-danger">📱 Scan QRIS Resmi ${accName || 'Little Palembang'}</h6>
            </div>
            <p class="small text-muted mb-3">${instructions || 'Mendukung semua aplikasi e-wallet & mobile banking (GoPay, OVO, Dana, ShopeePay, BCA Mobile, Livin, BRImo, dll)'}</p>

            <div class="qris-display-frame mb-3">
                <div class="text-center mb-1">
                    <span class="badge bg-danger text-white fw-bold px-3 py-1" style="letter-spacing: 1px; font-size: 0.82rem;">QRIS STANDAR ASPI / BI</span>
                </div>
                ${qrDisplayContent}
                <div class="fw-bold text-dark" style="font-size: 0.95rem;">${accName ? accName.toUpperCase() : 'LITTLE PALEMBANG CAFE'}</div>
                ${accNum ? `<div class="text-muted small">NMID / ID: ${accNum}</div>` : ''}
                <div class="fw-bold text-danger mt-1">Total Tagihan: Rp ${Number(currentGrandTotal).toLocaleString('id-ID')}</div>
            </div>

            <div class="text-start p-3 bg-white rounded border" style="font-size: 0.85rem;">
                <strong>Panduan Pembayaran QRIS:</strong>
                <ol class="mb-0 ps-3 mt-1">
                    <li>Buka aplikasi perbankan atau e-wallet di ponsel Anda.</li>
                    <li>Pindai (Scan) QR Code di atas.</li>
                    <li>Pastikan nama merchant: <strong>${accName || 'Little Palembang Cafe'}</strong> dan nominal sesuai total belanja: <strong>Rp ${Number(currentGrandTotal).toLocaleString('id-ID')}</strong>.</li>
                    <li>Simpan bukti bayar untuk ditunjukkan saat verifikasi.</li>
                </ol>
            </div>
        </div>
        `;
    } else {
        // Bank transfer / lainnya
        const bankTitle = selectedOption.text.split('(')[0].trim();
        html = `
        <div class="payment-guide-box payment-guide-transfer">
            <div class="d-flex align-items-center mb-3">
                <i class="fas fa-university fa-2x me-3 text-primary"></i>
                <div>
                    <h6 class="fw-bold mb-0 text-primary">💳 Panduan Transfer ${bankTitle}</h6>
                    <small class="text-muted">${instructions || 'Transfer resmi rekening Little Palembang'}</small>
                </div>
            </div>

            <div class="p-3 bg-white rounded-3 border mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <span class="text-muted small">Metode / Bank:</span>
                    <strong class="text-dark">${bankTitle}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <span class="text-muted small">Nomor Rekening:</span>
                    <div>
                        <strong class="fs-5 text-primary me-2" id="copyAccTarget">${accNum}</strong>
                        <button type="button" class="btn btn-sm btn-outline-primary copy-acc-btn py-0 px-2" onclick="copyAccNumber('${accNum}')">
                            <i class="fas fa-copy me-1"></i> Salin
                        </button>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <span class="text-muted small">Atas Nama:</span>
                    <strong class="text-dark">${accName}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Nominal Transfer:</span>
                    <strong class="text-danger fs-5">Rp ${Number(currentGrandTotal).toLocaleString('id-ID')}</strong>
                </div>
            </div>

            <div style="font-size: 0.85rem;">
                <i class="fas fa-info-circle me-1"></i> Silakan transfer tepat hingga digit terakhir, lalu perlihatkan bukti mutasi/transfer ke kasir atau waiter saat mengantar pesanan.
            </div>
        </div>
        `;
    }

    container.innerHTML = html;
}

function copyAccNumber(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Nomor rekening ' + text + ' berhasil disalin!');
        });
    } else {
        const temp = document.createElement('input');
        temp.value = text;
        document.body.appendChild(temp);
        temp.select();
        document.execCommand('copy');
        document.body.removeChild(temp);
        alert('Nomor rekening ' + text + ' berhasil disalin!');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    renderPaymentGuide();
});
</script>
@endpush
@endsection
