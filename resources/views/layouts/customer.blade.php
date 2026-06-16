<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Little Palembang')</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- PWA  -->
    <meta name="theme-color" content="#FF8C42"/>
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpeg') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <style>
        :root {
            --primary-color: #FF8C42;
            --secondary-color: #8B4513;
            --cafe-brown: #8B4513;
            --cafe-orange: #FF8C42;
            --cafe-dark: #3E2723;
            --cafe-light: #FFECB3;
        }
        
        body {
            font-family: 'Outfit', sans-serif;
            padding-bottom: 80px;
            transition: background-color 0.3s, color 0.3s;
            position: relative;
        }

        /* Decorative background pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.03;
            background-image: 
                repeating-linear-gradient(45deg, var(--cafe-brown) 0px, var(--cafe-brown) 2px, transparent 2px, transparent 10px),
                repeating-linear-gradient(-45deg, var(--cafe-orange) 0px, var(--cafe-orange) 2px, transparent 2px, transparent 10px);
        }

        /* Floating sate sticks decoration */
        .cafe-decoration {
            position: fixed;
            font-size: 3rem;
            opacity: 0.05;
            z-index: 0;
            pointer-events: none;
            animation: floatCafe 20s ease-in-out infinite;
        }

        @keyframes floatCafe {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-30px) rotate(10deg);
            }
        }

        .cafe-decoration:nth-child(1) {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .cafe-decoration:nth-child(2) {
            top: 60%;
            right: 15%;
            animation-delay: 3s;
        }

        .cafe-decoration:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: 6s;
        }

        .cafe-decoration:nth-child(4) {
            top: 30%;
            right: 25%;
            animation-delay: 9s;
        }

        /* Light Mode (Default) */
        body.light-mode {
            background-color: #F5F5F5;
            color: #1A1A1A;
        }

        body.light-mode .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid #e0e0e0;
        }

        body.light-mode .navbar-brand,
        body.light-mode .btn-light {
            color: #1A1A1A !important;
        }

        body.light-mode .card {
            background-color: white;
            border: 1px solid #e0e0e0;
            color: #1A1A1A;
        }

        body.light-mode .card-title,
        body.light-mode .card-text,
        body.light-mode h1, body.light-mode h2, body.light-mode h3,
        body.light-mode h4, body.light-mode h5, body.light-mode h6,
        body.light-mode p, body.light-mode td, body.light-mode th,
        body.light-mode label, body.light-mode .text-muted {
            color: #1A1A1A !important;
        }

        body.light-mode .table {
            color: #1A1A1A;
        }

        body.light-mode .form-control,
        body.light-mode .form-select {
            background-color: white;
            color: #1A1A1A;
            border: 1px solid #ced4da;
        }

        /* Dark Mode */
        body.dark-mode {
            background-color: #1A1A1A;
            color: #F7F7F7;
        }

        body.dark-mode .navbar {
            background-color: rgba(45, 45, 45, 0.95);
        }

        body.dark-mode .navbar-brand,
        body.dark-mode .btn-light {
            color: #F7F7F7 !important;
        }

        body.dark-mode .card {
            background-color: #2D2D2D;
            border: 1px solid #444;
            color: #F7F7F7;
        }

        body.dark-mode .card-title,
        body.dark-mode .card-text,
        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3,
        body.dark-mode h4, body.dark-mode h5, body.dark-mode h6,
        body.dark-mode p, body.dark-mode td, body.dark-mode th,
        body.dark-mode label {
            color: #F7F7F7 !important;
        }

        body.dark-mode .text-muted {
            color: #B0B0B0 !important;
        }

        body.dark-mode .table {
            color: #F7F7F7;
            background-color: transparent;
        }

        body.dark-mode .table th,
        body.dark-mode .table td {
            color: #F7F7F7 !important;
            border-color: #555 !important;
        }

        body.dark-mode .table-bordered {
            border-color: #555 !important;
        }

        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background-color: #1A1A1A;
            color: #F7F7F7;
            border: 1px solid #444;
        }

        .navbar {
            backdrop-filter: blur(10px);
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: transform 0.2s;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--cafe-orange), var(--cafe-brown));
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white !important;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 69, 19, 0.4);
            color: white !important;
        }

        .theme-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--cafe-orange), var(--cafe-brown));
            border: none;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 15px rgba(139, 69, 19, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle:hover {
            transform: scale(1.15) rotate(15deg);
            box-shadow: 0 6px 20px rgba(139, 69, 19, 0.6);
        }

        .theme-toggle i {
            transition: transform 0.3s ease;
        }

        .theme-toggle:active {
            transform: scale(1.05);
        }

        /* Cart button animation */
        .cart-btn {
            border-radius: 10px;
            padding: 8px 15px;
            transition: all 0.3s ease;
            background: white !important;
            border: 2px solid var(--cafe-orange) !important;
            color: var(--cafe-brown) !important;
        }

        .cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
            background: linear-gradient(135deg, var(--cafe-orange), var(--cafe-brown)) !important;
            color: white !important;
        }

        .cart-btn .badge {
            animation: pulse 2s ease-in-out infinite;
            background: linear-gradient(135deg, var(--cafe-orange), var(--cafe-brown)) !important;
        }

        body.dark-mode .cart-btn {
            background: #2D2D2D !important;
            border: 2px solid var(--cafe-orange) !important;
            color: var(--cafe-orange) !important;
        }

        body.dark-mode .cart-btn:hover {
            background: linear-gradient(135deg, var(--cafe-orange), var(--cafe-brown)) !important;
            color: white !important;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }


        @media print {
            body {
                background: white;
                color: black;
            }
            .no-print {
                display: none !important;
            }
            .navbar, .theme-toggle {
                display: none !important;
            }
        }
    </style>
    
    <!-- Dark Mode Table Fix - Must be after Bootstrap -->
    <style>
        /* CRITICAL: Dark mode table styling */
        body.dark-mode .card {
            background-color: #2D2D2D !important;
            border-color: #444 !important;
        }

        body.dark-mode .card-body {
            background-color: #2D2D2D !important;
        }

        body.dark-mode .table {
            color: #F7F7F7 !important;
            background-color: #2D2D2D !important;
            --bs-table-bg: #2D2D2D !important;
            --bs-table-striped-bg: #2D2D2D !important;
            --bs-table-active-bg: #2D2D2D !important;
            --bs-table-hover-bg: #333 !important;
        }

        body.dark-mode .table th,
        body.dark-mode .table td {
            color: #F7F7F7 !important;
            background-color: #2D2D2D !important;
            border-color: #000 !important;
        }

        body.dark-mode .table thead th {
            color: #F7F7F7 !important;
            background-color: #2D2D2D !important;
            border-color: #000 !important;
        }

        body.dark-mode .table tbody tr {
            background-color: #2D2D2D !important;
        }

        body.dark-mode .table tbody td,
        body.dark-mode .table tbody th {
            color: #F7F7F7 !important;
            background-color: #2D2D2D !important;
            border-color: #000 !important;
        }

        body.dark-mode .table tfoot th,
        body.dark-mode .table tfoot td {
            color: #F7F7F7 !important;
            background-color: #2D2D2D !important;
            border-color: #000 !important;
        }

        body.dark-mode .table-bordered {
            border-color: #000 !important;
        }

        body.dark-mode .table-bordered th,
        body.dark-mode .table-bordered td {
            border-color: #000 !important;
        }

        body.dark-mode .table-sm th,
        body.dark-mode .table-sm td {
            color: #F7F7F7 !important;
            background-color: #2D2D2D !important;
            border-color: #000 !important;
        }
    </style>
    
    @stack('css')
</head>
<body class="light-mode">
    <!-- Floating Sate Sticks Decoration -->
    <i class="fas fa-fire cafe-decoration"></i>
    <i class="fas fa-fire cafe-decoration"></i>
    <i class="fas fa-fire cafe-decoration"></i>
    <i class="fas fa-fire cafe-decoration"></i>



    <nav class="navbar navbar-expand-lg fixed-top no-print">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ request()->route('uuid') ? route('order.index', request()->route('uuid')) : '#' }}" style="font-weight: 700; font-size: 1.3rem; display: flex; align-items: center;">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; margin-right: 12px;">
                <span style="background: linear-gradient(135deg, var(--cafe-brown), var(--cafe-orange)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Little Palembang</span>
            </a>
            @php $cartCount = session('cart') ? collect(session('cart'))->sum('quantity') : 0; @endphp
            <a href="{{ route('order.checkout', request()->route('uuid')) }}" class="btn btn-sm position-relative cart-btn" id="nav-cart-btn" style="{{ $cartCount > 0 ? 'inline-flex' : 'display: none;' }}">
                <i class="fas fa-shopping-cart"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill cart-pulse" style="{{ $cartCount > 0 ? 'inline-block' : 'display: none;' }}">
                    {{ $cartCount }}
                </span>
            </a>
        </div>
    </nav>

    <button class="theme-toggle no-print" onclick="toggleTheme()" id="themeToggle">
        <i class="fas fa-moon"></i>
    </button>

    <div class="container mt-5 pt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
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
