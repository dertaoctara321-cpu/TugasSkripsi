<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Little Palembang')</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- PWA  -->
    <meta name="theme-color" content="#DC2626"/>
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpeg') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <style>
        :root {
            --primary-color: #DC2626;
            --secondary-color: #991B1B;
            --ruby-red: #B91C1C;
            --coral-red: #EF4444;
            --cafe-brown: #991B1B;
            --cafe-orange: #DC2626;
            --cafe-dark: #18181B;
            --cafe-light: #FEE2E2;
            --pure-white: #FFFFFF;
            --soft-white: #F8FAFC;
        }
        
        body {
            font-family: 'Outfit', sans-serif;
            padding-bottom: 80px;
            transition: background-color 0.3s, color 0.3s;
            position: relative;
        }

        /* Decorative background pattern (Merah-Putih subtle geometric) */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.04;
            background-image: 
                repeating-linear-gradient(45deg, #DC2626 0px, #DC2626 2px, transparent 2px, transparent 12px),
                repeating-linear-gradient(-45deg, #991B1B 0px, #991B1B 2px, transparent 2px, transparent 12px);
        }

        /* Floating decoration */
        .cafe-decoration {
            position: fixed;
            font-size: 3rem;
            color: #DC2626;
            opacity: 0.04;
            z-index: 0;
            pointer-events: none;
            animation: floatCafe 20s ease-in-out infinite;
        }

        @keyframes floatCafe {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-25px) rotate(10deg); }
        }

        .cafe-decoration:nth-child(1) { top: 10%; left: 8%; animation-delay: 0s; }
        .cafe-decoration:nth-child(2) { top: 60%; right: 10%; animation-delay: 3s; }
        .cafe-decoration:nth-child(3) { bottom: 20%; left: 15%; animation-delay: 6s; }
        .cafe-decoration:nth-child(4) { top: 30%; right: 20%; animation-delay: 9s; }

        /* Light Mode (Default) */
        body.light-mode {
            background-color: #F8FAFC;
            color: #0F172A;
        }

        body.light-mode .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            border-bottom: 1.5px solid #FEE2E2;
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.06);
        }

        body.light-mode .navbar-brand {
            color: #0F172A !important;
        }

        body.light-mode .card {
            background-color: #ffffff;
            border: 1px solid #E2E8F0;
            color: #0F172A;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        }

        body.light-mode .card-title,
        body.light-mode .card-text,
        body.light-mode h1, body.light-mode h2, body.light-mode h3,
        body.light-mode h4, body.light-mode h5, body.light-mode h6,
        body.light-mode p, body.light-mode td, body.light-mode th,
        body.light-mode label {
            color: #0F172A !important;
        }

        body.light-mode .text-muted {
            color: #64748B !important;
        }

        body.light-mode .table {
            color: #0F172A;
        }

        body.light-mode .form-control,
        body.light-mode .form-select {
            background-color: #ffffff;
            color: #0F172A;
            border: 1.5px solid #E2E8F0;
        }

        body.light-mode .form-control:focus,
        body.light-mode .form-select:focus {
            border-color: #DC2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
        }

        /* Dark Mode */
        body.dark-mode {
            background-color: #0F172A;
            color: #F8FAFC;
        }

        body.dark-mode .navbar {
            background-color: rgba(15, 23, 42, 0.95);
            border-bottom: 1.5px solid #334155;
        }

        body.dark-mode .navbar-brand {
            color: #F8FAFC !important;
        }

        body.dark-mode .card {
            background-color: #1E293B;
            border: 1px solid #334155;
            color: #F8FAFC;
        }

        body.dark-mode .card-title,
        body.dark-mode .card-text,
        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3,
        body.dark-mode h4, body.dark-mode h5, body.dark-mode h6,
        body.dark-mode p, body.dark-mode td, body.dark-mode th,
        body.dark-mode label {
            color: #F8FAFC !important;
        }

        body.dark-mode .text-muted {
            color: #94A3B8 !important;
        }

        body.dark-mode .table {
            color: #F8FAFC;
            background-color: transparent;
        }

        body.dark-mode .table th,
        body.dark-mode .table td {
            color: #F8FAFC !important;
            border-color: #334155 !important;
        }

        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background-color: #0F172A;
            color: #F8FAFC;
            border: 1.5px solid #334155;
        }

        .navbar {
            backdrop-filter: blur(12px);
        }

        .card {
            border-radius: 16px;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 50%, #B91C1C 100%) !important;
            border: none;
            border-radius: 12px;
            padding: 10px 22px;
            font-weight: 700;
            transition: all 0.25s ease;
            color: white !important;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.55);
            color: white !important;
        }

        .theme-toggle {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 1000;
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: linear-gradient(135deg, #EF4444, #DC2626);
            border: 2px solid #ffffff;
            color: white;
            font-size: 1.3rem;
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.45);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle:hover {
            transform: scale(1.1) rotate(15deg);
            box-shadow: 0 8px 24px rgba(220, 38, 38, 0.6);
        }

        /* Cart button */
        .cart-btn {
            border-radius: 12px;
            padding: 9px 16px;
            transition: all 0.25s ease;
            background: #ffffff !important;
            border: 2px solid #DC2626 !important;
            color: #DC2626 !important;
            font-weight: 700;
        }

        .cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.35);
            background: linear-gradient(135deg, #EF4444, #DC2626) !important;
            color: white !important;
        }

        .cart-btn .badge {
            background: #DC2626 !important;
            color: white !important;
            font-weight: 800;
        }

        body.dark-mode .cart-btn {
            background: #1E293B !important;
            border: 2px solid #DC2626 !important;
            color: #EF4444 !important;
        }

        body.dark-mode .cart-btn:hover {
            background: linear-gradient(135deg, #EF4444, #DC2626) !important;
            color: white !important;
        }

        @media print {
            body { background: white; color: black; }
            .no-print { display: none !important; }
            .navbar, .theme-toggle { display: none !important; }
        }
    </style>
    
    @stack('css')
</head>
<body class="light-mode">
    <!-- Floating Decoration Icons -->
    <i class="fas fa-utensils cafe-decoration"></i>
    <i class="fas fa-mug-hot cafe-decoration"></i>
    <i class="fas fa-utensils cafe-decoration"></i>
    <i class="fas fa-fire cafe-decoration"></i>

    <nav class="navbar navbar-expand-lg fixed-top no-print py-2">
        <div class="container-fluid px-3">
            <a class="navbar-brand" href="{{ request()->route('uuid') ? route('order.index', request()->route('uuid')) : '#' }}" style="font-weight: 800; font-size: 1.25rem; display: flex; align-items: center;">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; margin-right: 10px; border: 2px solid #DC2626;">
                <span style="background: linear-gradient(135deg, #DC2626, #991B1B); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; letter-spacing: -0.5px;">Little Palembang</span>
            </a>
            @php 
                $cartCount = session('cart_' . (request()->route('uuid') ?? '')) ? collect(session('cart_' . (request()->route('uuid') ?? '')))->sum('quantity') : 0; 
            @endphp
            <a href="{{ request()->route('uuid') ? route('order.checkout', request()->route('uuid')) : '#' }}" class="btn btn-sm position-relative cart-btn" id="nav-cart-btn" style="display: inline-flex; align-items: center; text-decoration: none;" title="Lihat Keranjang Belanja">
                <i class="fas fa-shopping-bag mr-1"></i>
                <span class="ms-1 d-none d-sm-inline">Keranjang</span>
                <span class="badge rounded-pill ms-2" id="nav-cart-count" style="background: #DC2626; color: white; min-width: 22px; font-weight: 800; transition: transform 0.2s ease;">
                    {{ $cartCount }}
                </span>
            </a>
        </div>
    </nav>

    <button class="theme-toggle no-print" onclick="toggleTheme()" id="themeToggle" title="Ganti Tema (Dark/Light)">
        <i class="fas fa-moon"></i>
    </button>

    <div class="container mt-5 pt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" style="border-radius: 12px; background: #ECFDF5; border-left: 4px solid #10B981; color: #065F46; font-weight: 600;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" style="border-radius: 12px; background: #FFF1F2; border-left: 4px solid #EF4444; color: #9F1239; font-weight: 600;">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @yield('content')
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Theme Toggle
        function toggleTheme() {
            const body = document.body;
            const icon = document.querySelector('#themeToggle i');
            
            if (body.classList.contains('light-mode')) {
                body.classList.remove('light-mode');
                body.classList.add('dark-mode');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.remove('dark-mode');
                body.classList.add('light-mode');
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
                localStorage.setItem('theme', 'light');
            }
        }

        // Load saved theme
        window.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const body = document.body;
            const icon = document.querySelector('#themeToggle i');
            
            if (savedTheme === 'dark') {
                body.classList.remove('light-mode');
                body.classList.add('dark-mode');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
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
