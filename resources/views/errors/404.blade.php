<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Little Palembang</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #DC2626 0%, #7F1D1D 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Floating Sate Sticks Background */
        .cafe-decoration {
            position: absolute;
            font-size: 3rem;
            color: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
            pointer-events: none;
        }

        .cafe-decoration:nth-child(1) {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .cafe-decoration:nth-child(2) {
            top: 60%;
            left: 80%;
            animation-delay: 1s;
        }

        .cafe-decoration:nth-child(3) {
            top: 80%;
            left: 20%;
            animation-delay: 2s;
        }

        .cafe-decoration:nth-child(4) {
            top: 30%;
            right: 15%;
            animation-delay: 3s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-30px) rotate(10deg);
            }
        }

        .container {
            text-align: center;
            z-index: 10;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-code {
            font-size: 12rem;
            font-weight: 900;
            color: white;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            line-height: 1;
            margin-bottom: 20px;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .error-icon {
            font-size: 8rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
            animation: shake 3s ease-in-out infinite;
        }

        @keyframes shake {
            0%, 100% {
                transform: rotate(0deg);
            }
            25% {
                transform: rotate(-10deg);
            }
            75% {
                transform: rotate(10deg);
            }
        }

        h1 {
            font-size: 3rem;
            color: white;
            margin-bottom: 15px;
            font-weight: 700;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        p {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 40px;
            font-weight: 400;
        }

        .btn-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 18px 40px;
            font-size: 1.2rem;
            font-weight: 700;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: white;
            color: #8B4513;
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            background: #f5f5f5;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 8rem;
            }

            .error-icon {
                font-size: 5rem;
            }

            h1 {
                font-size: 2rem;
            }

            p {
                font-size: 1.1rem;
            }

            .btn {
                padding: 15px 30px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Decorations -->
    <i class="fas fa-fire cafe-decoration"></i>
    <i class="fas fa-fire cafe-decoration"></i>
    <i class="fas fa-fire cafe-decoration"></i>
    <i class="fas fa-fire cafe-decoration"></i>

    <div class="container">
        <div class="error-icon">
            <i class="fas fa-utensils"></i>
        </div>
        <div class="error-code">404</div>
        <h1>Halaman Tidak Ditemukan</h1>
        <p>Maaf, halaman yang Anda cari tidak ada di menu kami!</p>
        
        <div class="btn-container">
            <a href="{{ url('/login') }}" class="btn btn-primary">
                <i class="fas fa-home"></i>
                Kembali ke Login
            </a>
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Halaman Sebelumnya
            </a>
        </div>
    </div>
</body>
</html>
