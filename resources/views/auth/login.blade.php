<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Staff & Admin - Little Palembang</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
</head>
<body class="login-page">
    
    <!-- Floating particles background -->
    <div class="login-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Login container -->
    <div class="login-container">
        <div class="login-card">
            <!-- Logo section -->
            <div class="login-logo">
                <div class="logo-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <h1 class="login-title">Little Palembang</h1>
                <p class="login-subtitle">Portal Manajemen & Staf Kafe</p>
            </div>

            <!-- Role Quick Fill Section (Convenience for testing) -->
            <div class="role-quick-login">
                <div class="role-quick-title">
                    <i class="fas fa-bolt"></i> Pilih Akun Cepat (Demo):
                </div>
                <div class="role-chips">
                    <button type="button" class="role-chip" onclick="fillCredentials('admin@gmail.com', 'password')">
                        👑 Admin
                    </button>
                    <button type="button" class="role-chip" onclick="fillCredentials('kasir@gmail.com', 'password')">
                        💰 Kasir
                    </button>
                    <button type="button" class="role-chip" onclick="fillCredentials('dapur@gmail.com', 'password')">
                        🍳 Dapur
                    </button>
                    <button type="button" class="role-chip" onclick="fillCredentials('owner@gmail.com', 'password')">
                        📊 Owner
                    </button>
                </div>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <div><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Login form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email field -->
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Alamat Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="contoh: admin@gmail.com"
                        required 
                        autofocus
                        autocomplete="username"
                    >
                </div>

                <!-- Password field -->
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Kata Sandi</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        placeholder="Masukkan password Anda"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <!-- Remember me -->
                <div class="remember-me">
                    <input type="checkbox" id="remember_me" name="remember">
                    <label for="remember_me" style="margin-bottom: 0; cursor: pointer;">Ingat Saya</label>
                </div>

                <!-- Submit button -->
                <button type="submit" class="submit-btn" id="submitBtn">
                    <span><i class="fas fa-sign-in-alt"></i> Masuk ke Sistem</span>
                </button>
            </form>
        </div>
    </div>

    <script>
        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.querySelector('span').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        });
    </script>
</body>
</html>
