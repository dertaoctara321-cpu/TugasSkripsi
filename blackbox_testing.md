# DOKUMEN PENGUJIAN BLACK BOX (BLACK BOX TESTING)
## Sistem Informasi Pemesanan Menu Berbasis Web QR Code
**Studi Kasus:** Little Palembang Cafe  
**Versi Aplikasi:** 2.0 (Multi-Role & Red-White Modern Theme)  
**Tanggal Pengujian:** 20 Agustus 2026  
**Metode:** *Black Box Testing* (*Core Business Flow & Role-Based Testing*)

---

## 1. PENDAHULUAN
Pengujian *Black Box Testing* ini difokuskan pada **10 (sepuluh) skenario inti paling krusial** yang mencakup seluruh alur operasional utama kafe Little Palembang, mulai dari pemesanan mandiri oleh pelanggan (tanpa login via QR Code meja), alur pemrosesan pesanan di dapur, transaksi di kasir, monitoring performa oleh owner, hingga administrasi sistem oleh admin.

---

## 2. REKAPITULASI HASIL PENGUJIAN

| No | Modul / Fitur Utama | Hasil Pengujian | Status |
|:---:|:---|:---:|:---:|
| 1 | Autentikasi Multi-Role & Redirect Hak Akses | Sesuai Harapan | **PASS** |
| 2 | Pemilihan Menu Pelanggan via QR Meja (Tanpa Login) | Sesuai Harapan | **PASS** |
| 3 | Checkout & Pembuatan Pesanan Baru (*Place Order*) | Sesuai Harapan | **PASS** |
| 4 | Live Tracking Status Pesanan & Cetak Struk | Sesuai Harapan | **PASS** |
| 5 | Manajemen Antrean & Update Status Masak oleh Dapur | Sesuai Harapan | **PASS** |
| 6 | Verifikasi Pembayaran Transaksi oleh Kasir | Sesuai Harapan | **PASS** |
| 7 | Monitoring & Pengosongan Meja (*Clear Table*) oleh Kasir | Sesuai Harapan | **PASS** |
| 8 | Monitoring Omzet & Cetak Laporan Keuangan oleh Owner | Sesuai Harapan | **PASS** |
| 9 | Pengelolaan Menu & Generate QR Code Meja oleh Admin | Sesuai Harapan | **PASS** |
| 10 | Keamanan Otorisasi Role & Isolasi Keranjang Per Meja | Sesuai Harapan | **PASS** |

**Tingkat Keberhasilan:** **10 / 10 (100% PASS)**

---

## 3. MATRIKS 10 PENGUJIAN UTAMA (CORE TEST CASES)

| No | ID Test Case | Skenario Pengujian | Langkah / Data Uji | Hasil yang Diharapkan | Hasil Aktual | Kesimpulan |
|:---:|:---|:---|:---|:---|:---|:---:|
| **1** | **TC-01** | **Autentikasi Multi-Role & Redirect Hak Akses** | 1. Buka `/login`<br>2. Login bergantian: Admin, Kasir, Dapur, Owner dengan password valid. | Setiap peran berhasil login dan diarahkan tepat ke halaman operasionalnya (Admin/Owner ➔ Dashboard, Kasir/Dapur ➔ Antrean Pesanan). | Pengguna berhasil masuk dan dialihkan sesuai hak akses peran masing-masing. | **PASS** |
| **2** | **TC-02** | **Pemesanan Menu Pelanggan via QR (Tanpa Login)** | 1. Buka URL QR Meja `/order/{uuid}`<br>2. Filter kategori (*Makanan/Minuman*)<br>3. Tambah kuantitas item menu ke keranjang. | Menu tampil tanpa perlu login, filter kategori berjalan instan, angka kuantitas & floating cart badge terupdate secara real-time. | Pelanggan dapat memilih menu dan menambah item ke keranjang dengan lancar. | **PASS** |
| **3** | **TC-03** | **Checkout & Pembuatan Pesanan (*Place Order*)** | 1. Masuk ke halaman checkout<br>2. Isi Nama: "Budi", Lantai: "Lantai 1"<br>3. Pilih Pembayaran: "Cash/QRIS"<br>4. Klik *Pesan Sekarang*. | Pesanan tersimpan di database (`status: pending`), status meja otomatis berubah menjadi *Occupied* (Terisi), dialihkan ke halaman status pesanan. | Pesanan sukses dibuat dan status meja langsung tercatat terisi. | **PASS** |
| **4** | **TC-04** | **Live Tracking Pesanan & Cetak Struk Pelanggan** | 1. Buka halaman `/order/{uuid}/status/{id}`<br>2. Pantau timeline progres<br>3. Klik tombol *Cetak Struk*. | Timeline status (*Diterima ➔ Dimasak ➔ Disajikan ➔ Selesai*) terupdate live. Dialog print struk terbuka dengan format rapi. | Status live tracking sinkron dan struk pesanan berhasil dicetak. | **PASS** |
| **5** | **TC-05** | **Penerimaan & Update Status Masak oleh Dapur** | 1. Login sebagai Dapur (`dapur@gmail.com`)<br>2. Buka daftar antrean pesanan<br>3. Klik *Mulai Masak* ➔ *Siap Saji* ➔ *Selesaikan*. | Status pesanan di dapur dan status live pelanggan berubah secara berurutan (*pending ➔ cooking ➔ served ➔ completed*). | Dapur berhasil memperbarui seluruh tahapan memasak secara real-time. | **PASS** |
| **6** | **TC-06** | **Verifikasi Pembayaran oleh Kasir** | 1. Login sebagai Kasir (`kasir@gmail.com`)<br>2. Buka daftar pesanan<br>3. Klik *Verifikasi Lunas* pada pesanan terkait. | Status pembayaran berubah dari `unpaid/pending` menjadi `paid` (Lunas) dengan indikator badge hijau. | Pembayaran berhasil diverifikasi lunas oleh kasir. | **PASS** |
| **7** | **TC-07** | **Monitoring & Pengosongan Meja (*Clear Table*)** | 1. Login Kasir ➔ Buka menu *Status Meja* (`/admin/tables`)<br>2. Klik *Kosongkan* pada meja yang pesanannya telah selesai. | Status meja berubah dari *Occupied* (Terisi) menjadi *Available* (Tersedia), siap digunakan pelanggan berikutnya. | Meja berhasil dikosongkan dan siap menerima pelanggan baru. | **PASS** |
| **8** | **TC-08** | **Monitoring Omzet & Cetak Laporan oleh Owner** | 1. Login Owner (`owner@gmail.com`)<br>2. Lihat ringkasan omzet & grafik tren penjualan<br>3. Buka *Laporan Penjualan* ➔ Klik *Cetak Laporan*. | Dashboard menyajikan akumulasi omzet pesanan terbayar, visualisasi grafik interaktif, dan format cetak laporan keuangan bersih. | Owner dapat memantau data finansial dan mencetak laporan transaksi dengan akurat. | **PASS** |
| **9** | **TC-09** | **Kelola Menu & Generate QR Meja oleh Admin** | 1. Login Admin (`admin@gmail.com`)<br>2. Tambah menu baru beserta foto<br>3. Buka menu meja & klik *Unduh QR Code*. | Menu baru langsung muncul di katalog pemesanan pelanggan. Gambar QR Code meja beresolusi tinggi berhasil diunduh. | CRUD menu dan generator QR code meja berfungsi 100% optimal. | **PASS** |
| **10** | **TC-10** | **Keamanan Otorisasi Role & Isolasi Keranjang Meja** | 1. Dapur/Kasir mencoba membuka URL `/admin/users` atau `/admin/menus`<br>2. Buka Meja 1 & Meja 2 secara bersamaan di browser. | Akses URL tidak sah dicegat middleware (`Akses ditolak`). Keranjang belanja Meja 1 dan Meja 2 terisolasi terpisah (tidak tercampur). | Keamanan hak akses role dan isolasi data meja terbukti aman. | **PASS** |

---

## 4. KESIMPULAN

Dari hasil pengujian **10 Skenario Utama Black Box Testing**, disimpulkan bahwa:
1. **Alur Bisnis Utama**: Mulai dari pelanggan memindai QR meja, memesan tanpa login, proses memasak di dapur, pembayaran di kasir, hingga rekap omzet oleh owner berjalan secara **sempurna dan terintegrasi (End-to-End)**.
2. **Kinerja & Keamanan**: Pemisahan hak akses multi-role dan isolasi data pesanan per meja berjalan dengan handal tanpa error.
3. **Kesiapan Aplikasi**: Seluruh 10 kasus uji inti berstatus **PASS (100%)**, sehingga aplikasi dinyatakan **layak dan siap dioperasikan (Production Ready)**.
