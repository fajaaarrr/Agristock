<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AgriStock (Sistem Inventaris Gudang)</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: hsl(135, 45%, 33%);
            --primary-green-dark: hsl(135, 45%, 20%);
            --primary-green-light: hsl(135, 45%, 45%);
            --primary-green-soft: hsl(135, 45%, 96%);
            --accent-gold: hsl(38, 95%, 52%);
            --bg-light: #f4f7f4;
            --text-dark: hsl(135, 30%, 15%);
            --text-muted: hsl(135, 10%, 45%);
            --card-shadow: 0 15px 35px rgba(46, 125, 50, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-light);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
            width: 100vw;
        }

        /* Image Panel (Left) */
        .login-image-panel {
            flex: 1.2;
            position: relative;
            background-image: url('{{ asset("images/login-bg.jpg") }}');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
        }

        .login-image-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(20, 50, 25, 0.8) 0%, rgba(46, 125, 50, 0.3) 100%);
            z-index: 1;
        }

        .brand-overlay {
            position: relative;
            z-index: 2;
            color: white;
            max-width: 520px;
            animation: fadeInLeft 0.8s ease-out;
        }

        .brand-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--accent-gold);
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .brand-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 15px;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }

        .brand-desc {
            font-size: 1.1rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 40px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .quote-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        .quote-text {
            font-size: 1rem;
            font-style: italic;
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .quote-author {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--accent-gold);
        }

        /* Form Panel (Right) */
        .login-form-panel {
            flex: 1;
            background-color: var(--bg-light);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            position: relative;
        }

        .form-wrapper {
            width: 100%;
            max-width: 400px;
            animation: fadeInRight 0.8s ease-out;
        }

        .btn-back-home {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
            transition: all 0.2s ease;
        }

        .btn-back-home:hover {
            color: var(--primary-green);
            transform: translateX(-3px);
        }

        .form-card {
            background: white;
            border-radius: 24px;
            padding: 45px 35px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(46, 125, 50, 0.03);
            width: 100%;
        }

        .form-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-icon {
            background-color: var(--primary-green);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 15px;
            box-shadow: 0 6px 15px rgba(46, 125, 50, 0.25);
        }

        .form-header h3 {
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            font-size: 1.6rem;
        }

        .form-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-top: 5px;
        }

        .form-label {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .input-group {
            box-shadow: 0 2px 6px rgba(0,0,0,0.01);
            border-radius: 10px;
            overflow: hidden;
        }

        .input-group-text-custom {
            border: 1.5px solid #d0dbd2;
            border-right: none;
            background-color: white;
            color: var(--text-muted);
            padding-left: 15px;
            padding-right: 15px;
            display: flex;
            align-items: center;
        }

        .form-control-custom {
            border-radius: 0 10px 10px 0 !important;
            padding: 12px 16px;
            border: 1.5px solid #d0dbd2;
            border-left: none;
            background-color: white;
            color: var(--text-dark);
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control-custom:focus {
            border-color: var(--primary-green);
            box-shadow: none;
            background-color: white;
        }

        /* Focus state helper */
        .input-group:focus-within {
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.15);
        }
        .input-group:focus-within .input-group-text-custom,
        .input-group:focus-within .form-control-custom {
            border-color: var(--primary-green);
        }

        .btn-login {
            background-color: var(--primary-green);
            border: none;
            color: white;
            font-weight: 600;
            padding: 14px;
            border-radius: 10px;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.2);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background-color: var(--primary-green-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.3);
        }

        .alert-custom {
            border-radius: 10px;
            font-size: 0.85rem;
            border: none;
        }

        /* Keyframes */
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive */
        @media (max-width: 767.98px) {
            .login-container {
                flex-direction: column;
            }
            .login-image-panel {
                display: none !important;
            }
            .login-form-panel {
                padding: 30px 15px;
            }
            .form-card {
                padding: 35px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Left Panel: Graphic & Intro -->
        <div class="login-image-panel d-none d-md-flex">
            <div class="brand-overlay">
                <div class="brand-badge">
                    <i class="fa-solid fa-wheat-awn"></i> SYSTEM INVENTARIS GUDANG
                </div>
                <h1 class="brand-title">AgriStock</h1>
                <p class="brand-desc">Digitalisasi inventaris gudang tani Indonesia untuk akurasi data stok pangan, sarana produksi, dan distribusi komoditas yang transparan.</p>
                
                <div class="quote-card">
                    <p class="quote-text">"Pencatatan persediaan hasil tani yang terintegrasi, cepat, akurat, dan transparan."</p>
                    <span class="quote-author">— AgriStock Team</span>
                </div>
            </div>
        </div>
        
        <!-- Right Panel: Form -->
        <div class="login-form-panel">
            <div class="form-wrapper">
                <a href="{{ url('/') }}" class="btn-back-home">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                </a>
                
                <div class="form-card">
                    <div class="form-header">
                        <div class="logo-icon">
                            <i class="fa-solid fa-wheat-awn"></i>
                        </div>
                        <h3>Selamat Datang</h3>
                        <p>Masuk sebagai admin gudang</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-custom alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text-custom">
                                    <i class="fa-regular fa-envelope"></i>
                                </span>
                                <input type="email" id="email" name="email" class="form-control form-control-custom @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text-custom">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" id="password" name="password" class="form-control form-control-custom @error('password') is-invalid @enderror" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label text-muted" for="remember" style="font-size: 0.85rem; user-select: none;">Ingat Saya</label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-login">
                            Masuk <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
                        </button>
                    </form>
                </div>
                
                <div class="text-center mt-4 text-muted" style="font-size: 0.85rem;">
                    &copy; 2026 AgriStock. Seluruh hak cipta dilindungi.
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
