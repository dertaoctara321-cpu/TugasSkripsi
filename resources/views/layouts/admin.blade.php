<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin Dashboard') | Little Palembang</title>

  <!-- Google Font: Outfit -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Custom Admin Style (Merah Putih) -->
  <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  
  <style>
    /* Gold Star Global Styles */
    .star-gold, .text-gold, .text-warning, .fa-star, .fa-star.text-warning {
      color: #FFB800 !important;
      text-shadow: 0 0 2px rgba(255, 184, 0, 0.4);
    }
  </style>

  <!-- PWA  -->
  <meta name="theme-color" content="#DC2626"/>
  <link rel="apple-touch-icon" href="{{ asset('images/logo.jpeg') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">

  @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <span class="nav-link font-weight-bold" style="color: #ffffff;">
          <i class="fas fa-utensils mr-1"></i> Little Palembang Cafe
        </span>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      @auth
      <li class="nav-item d-flex align-items-center mr-3">
        <span class="badge" style="background: rgba(255, 255, 255, 0.2); color: white; padding: 6px 12px; font-size: 0.85rem; border: 1px solid rgba(255,255,255,0.3);">
          @if(Auth::user()->isAdmin())
            👑 Administrator
          @elseif(Auth::user()->isKasir())
            💰 Kasir
          @elseif(Auth::user()->isDapur())
            🍳 Dapur
          @elseif(Auth::user()->isOwner())
            📊 Owner
          @else
            👤 {{ Auth::user()->role_label }}
          @endif
        </span>
      </li>
      @endauth
      <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
          @csrf
          <button type="submit" class="nav-link btn btn-link" style="border: none; background: none; color: white;">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link" style="display: flex; align-items: center; padding: 12px 16px;">
      <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; margin-right: 12px; border: 2px solid #DC2626;">
      <div>
        <span class="brand-text" style="font-size: 1.05rem; display: block; line-height: 1.2;">Little Palembang</span>
        <small class="text-muted" style="font-size: 0.75rem; color: #FCA5A5 !important;">
          {{ Auth::user()->name ?? 'User' }}
        </small>
      </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          @if(Auth::user()->isAdmin() || Auth::user()->isOwner())
          <!-- Dashboard (Admin & Owner) -->
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          @endif

          <!-- Pesanan (Semua Role) -->
          <li class="nav-item">
            <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-receipt"></i>
              <p>
                @if(Auth::user()->isDapur())
                  Antrean Dapur
                @elseif(Auth::user()->isKasir())
                  Kasir & Pesanan
                @else
                  Pesanan Masuk
                @endif
              </p>
            </a>
          </li>

          @if(Auth::user()->isAdmin())
          <!-- Menu (Admin) -->
          <li class="nav-item">
            <a href="{{ route('menus.index') }}" class="nav-link {{ request()->routeIs('menus.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-utensils"></i>
              <p>Kelola Menu</p>
            </a>
          </li>

          <!-- Meja & QR (Admin) -->
          <li class="nav-item">
            <a href="{{ route('tables.index') }}" class="nav-link {{ request()->routeIs('tables.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-qrcode"></i>
              <p>Meja & QR Code</p>
            </a>
          </li>

          <!-- Metode Pembayaran (Admin) -->
          <li class="nav-item">
            <a href="{{ route('payment-methods.index') }}" class="nav-link {{ request()->routeIs('payment-methods.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Metode Pembayaran</p>
            </a>
          </li>
          @endif

          @if(Auth::user()->isKasir())
          <!-- Meja untuk Kasir (monitoring) -->
          <li class="nav-item">
            <a href="{{ route('tables.index') }}" class="nav-link {{ request()->routeIs('tables.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chair"></i>
              <p>Status Meja</p>
            </a>
          </li>
          @endif

          @if(Auth::user()->isAdmin() || Auth::user()->isOwner())
          <!-- Laporan Penjualan (Admin & Owner) -->
          <li class="nav-item">
            <a href="{{ route('admin.reports') }}" class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>Laporan Penjualan</p>
            </a>
          </li>
          @endif

          @if(Auth::user()->isAdmin())
          <!-- Kelola Pengguna / Staf (Admin only) -->
          <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>Kelola Pengguna</p>
            </a>
          </li>
          @endif

        </ul>
      </nav>
      <!-- /.sidebar-menu -->

      <!-- Dark Mode Toggle Button -->
      <div class="p-3" style="position: absolute; bottom: 70px; left: 0; right: 0; border-top: 1px solid rgba(255,255,255,0.1);">
        <button id="darkModeToggle" class="btn btn-block" style="background: rgba(255,255,255,0.1); color: white; border-radius: 10px; font-weight: 600; padding: 10px; font-size: 0.9rem;">
          <i class="fas fa-moon" id="darkModeIcon"></i>
          <span id="darkModeText" class="ml-1">Dark Mode</span>
        </button>
      </div>

      <!-- Logout Button at Bottom -->
      <div class="p-3" style="position: absolute; bottom: 0; left: 0; right: 0;">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-block" style="background: linear-gradient(135deg, #EF4444, #DC2626); color: white; border-radius: 10px; font-weight: 600; padding: 10px; font-size: 0.9rem;">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </form>
      </div>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header pt-3 pb-2">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>@yield('title')</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content pb-4">
      <div class="container-fluid">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif

        @yield('content')
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer text-center">
    <strong>Copyright &copy; 2026 Little Palembang Cafe.</strong> All rights reserved.
    <br><small class="text-muted">Lorok Pakjo, Kec. Ilir Bar. I, Kota Palembang, Sumatera Selatan.</small>
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Global SweetAlert2 Configuration -->
<script>
const swalTheme = {
    confirmButtonColor: '#DC2626',
    cancelButtonColor: '#64748B',
    background: '#fff',
    color: '#0F172A',
    iconColor: '#DC2626'
};

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[onclick*="confirm"]').forEach(function(element) {
        const onclickAttr = element.getAttribute('onclick');
        const match = onclickAttr.match(/confirm\(['"](.+?)['"]\)/);
        if (match) {
            const message = match[1].replace(/\\n/g, '<br>');
            element.removeAttribute('onclick');
            element.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi',
                    html: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-check"></i> Ya',
                    cancelButtonText: '<i class="fas fa-times"></i> Batal',
                    ...swalTheme,
                    customClass: {
                        confirmButton: 'btn btn-danger btn-lg',
                        cancelButton: 'btn btn-secondary btn-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (element.tagName === 'BUTTON' && element.type === 'submit') {
                            element.closest('form').submit();
                        } else if (element.tagName === 'A') {
                            window.location.href = element.href;
                        }
                    }
                });
            });
        }
    });
});

// Dark Mode Toggle
const darkModeToggle = document.getElementById('darkModeToggle');
const darkModeIcon = document.getElementById('darkModeIcon');
const darkModeText = document.getElementById('darkModeText');
const body = document.body;

const isDarkMode = localStorage.getItem('adminDarkMode') === 'true';
if (isDarkMode) {
    body.classList.add('dark-mode');
    if (darkModeIcon) {
        darkModeIcon.classList.remove('fa-moon');
        darkModeIcon.classList.add('fa-sun');
    }
    if (darkModeText) darkModeText.textContent = 'Light Mode';
}

if (darkModeToggle) {
    darkModeToggle.addEventListener('click', function() {
        body.classList.toggle('dark-mode');
        if (body.classList.contains('dark-mode')) {
            darkModeIcon.classList.remove('fa-moon');
            darkModeIcon.classList.add('fa-sun');
            darkModeText.textContent = 'Light Mode';
            localStorage.setItem('adminDarkMode', 'true');
        } else {
            darkModeIcon.classList.remove('fa-sun');
            darkModeIcon.classList.add('fa-moon');
            darkModeText.textContent = 'Dark Mode';
            localStorage.setItem('adminDarkMode', 'false');
        }
    });
}
</script>

@stack('js')

<!-- PWA Service Worker Registration -->
<script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function(reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script>
</body>
</html>
