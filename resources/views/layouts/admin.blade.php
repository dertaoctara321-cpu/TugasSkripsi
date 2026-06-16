<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard | Little Palembang</title>

  <!-- Google Font: Outfit -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Custom Admin Style -->
  <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  
  <!-- PWA  -->
  <meta name="theme-color" content="#FF8C42"/>
  <link rel="apple-touch-icon" href="{{ asset('images/logo.jpeg') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">

  @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
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
    <a href="{{ route('admin.dashboard') }}" class="brand-link" style="display: flex; align-items: center; padding: 10px 15px;">
      <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px;">
      <span class="brand-text" style="font-size: 1.1rem;">Administrator</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('menus.index') }}" class="nav-link">
              <i class="nav-icon fas fa-utensils"></i>
              <p>Menu</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('tables.index') }}" class="nav-link">
              <i class="nav-icon fas fa-qrcode"></i>
              <p>Meja & QR</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('payment-methods.index') }}" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Metode Pembayaran</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('orders.index') }}" class="nav-link">
              <i class="nav-icon fas fa-receipt"></i>
              <p>Pesanan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.reports') }}" class="nav-link">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>Laporan</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->

      <!-- Dark Mode Toggle Button -->
      <div class="p-3" style="position: absolute; bottom: 70px; left: 0; right: 0; border-top: 1px solid rgba(255,255,255,0.1);">
        <button id="darkModeToggle" class="btn btn-block" style="background: linear-gradient(135deg, #4a4a4a, #2d2d2d); color: white; border-radius: 10px; font-weight: 600; padding: 12px;">
          <i class="fas fa-moon" id="darkModeIcon"></i>
          <span id="darkModeText">Dark Mode</span>
        </button>
      </div>

      <!-- Logout Button at Bottom -->
      <div class="p-3" style="position: absolute; bottom: 0; left: 0; right: 0;">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-block" style="background: linear-gradient(135deg, #F44336, #D32F2F); color: white; border-radius: 10px; font-weight: 600; padding: 12px;">
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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>@yield('title')</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer text-center">
    <strong>Copyright &copy; 2025 Little Palembang.</strong> All rights reserved.
    <br>Lorok Pakjo, Kec. Ilir Bar. I, Kota Palembang, Sumatera Selatan.
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
// Custom SweetAlert2 theme for all pages
const swalTheme = {
    confirmButtonColor: '#FF8C42',
    cancelButtonColor: '#9E9E9E',
    background: '#fff',
    color: '#333',
    iconColor: '#FF8C42'
};

// Replace all onclick="return confirm()" with SweetAlert2
document.addEventListener('DOMContentLoaded', function() {
    // Find all elements with onclick confirm
    document.querySelectorAll('[onclick*="confirm"]').forEach(function(element) {
        const onclickAttr = element.getAttribute('onclick');
        
        // Extract confirm message
        const match = onclickAttr.match(/confirm\(['"](.+?)['"]\)/);
        if (match) {
            const message = match[1].replace(/\\n/g, '<br>');
            
            // Remove onclick attribute
            element.removeAttribute('onclick');
            
            // Add click event with SweetAlert2
            element.addEventListener('click', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Konfirmasi',
                    html: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-check"></i> Ya',
                    cancelButtonText: '<i class="fas fa-times"></i> Tidak',
                    ...swalTheme,
                    customClass: {
                        confirmButton: 'btn btn-danger btn-lg',
                        cancelButton: 'btn btn-secondary btn-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If it's a form button, submit the form
                        if (element.tagName === 'BUTTON' && element.type === 'submit') {
                            element.closest('form').submit();
                        }
                        // If it's a link, follow the link
                        else if (element.tagName === 'A') {
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

// Check for saved dark mode preference
const isDarkMode = localStorage.getItem('adminDarkMode') === 'true';
if (isDarkMode) {
    body.classList.add('dark-mode');
    darkModeIcon.classList.remove('fa-moon');
    darkModeIcon.classList.add('fa-sun');
    darkModeText.textContent = 'Light Mode';
}

// Toggle dark mode
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
