<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - Little Palembang</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
                    <i class="fas fa-fire"></i>
                </div>
                <h1 class="login-title">Little Palembang</h1>
                <p class="login-subtitle">Admin Dashboard</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="success-message">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Login form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email field -->
                <div class="form-group">
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder=" "
                        required 
                        autofocus
                        autocomplete="username"
                    >
                    <label for="email">Email Address</label>
                </div>

                <!-- Password field -->
                <div class="form-group">
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        placeholder=" "
                        required
                        autocomplete="current-password"
                    >
                    <label for="password">Password</label>
                </div>

                <!-- Remember me -->
                <div class="remember-me">
                    <input type="checkbox" id="remember_me" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>

                <!-- Submit button -->
                <button type="submit" class="submit-btn" id="submitBtn">
                    <span>Login</span>
                </button>

                <!-- Forgot password -->
                @if (Route::has('password.request'))
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script>
        // Add loading state on form submit
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            btn.querySelector('span').textContent = 'Logging in...';
        });

        // Simple form validation animation
        const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('invalid', function(e) {
                e.preventDefault();
                this.parentElement.style.animation = 'shake 0.5s ease';
                setTimeout(() => {
                    this.parentElement.style.animation = '';
                }, 500);
            });
        });
    </script>
</body>
</html>
