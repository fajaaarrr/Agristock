<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AgriStock (Sistem Inventaris Gudang)</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #2e7d32;
            --primary-green-dark: #1b5e20;
            --bg-glass: rgba(255, 255, 255, 0.9);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #1b5e20 0%, #4caf50 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Agricultural Pattern Overlays */
        body::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            z-index: 0;
        }

        body::after {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
            z-index: 0;
        }

        .login-card {
            background-color: var(--bg-glass);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 420px;
            padding: 40px 30px;
            position: relative;
            z-index: 10;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header .logo-icon {
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
            box-shadow: 0 4px 10px rgba(46, 125, 50, 0.3);
        }

        .login-header h3 {
            font-weight: 700;
            color: var(--primary-green-dark);
            margin: 0;
        }

        .login-header p {
            color: #556b58;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .form-label {
            font-weight: 600;
            color: #3e5040;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 16px;
            border: 1.5px solid #d0dbd2;
            background-color: rgba(255, 255, 255, 0.8);
            color: #2c3e2e;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.15);
            background-color: white;
        }

        .btn-login {
            background-color: var(--primary-green);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            margin-top: 15px;
            transition: all 0.2s;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background-color: var(--primary-green-dark);
            box-shadow: 0 4px 15px rgba(27, 94, 32, 0.3);
        }

        .alert-custom {
            border-radius: 8px;
            font-size: 0.85rem;
            border: none;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <div class="logo-icon">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <h3>AgriStock</h3>
            <p>Sistem Manajemen Inventaris Gudang</p>
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
                    <span class="input-group-text bg-white border-end-0 text-muted" style="border: 1.5px solid #d0dbd2; border-radius: 8px 0 0 8px;">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" class="form-control border-start-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" style="border-radius: 0 8px 8px 0;" required autofocus>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted" style="border: 1.5px solid #d0dbd2; border-radius: 8px 0 0 8px;">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" id="password" name="password" class="form-control border-start-0 @error('password') is-invalid @enderror" style="border-radius: 0 8px 8px 0;" required>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check d-flex justify-content-between align-items-center">
                <div>
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label text-muted" for="remember" style="font-size: 0.85rem; user-select: none;">Ingat Saya</label>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-login">
                Masuk <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
            </button>
        </form>
        
        <div class="text-center mt-4 text-muted" style="font-size: 0.8rem;">
            &copy; 2026 AgriStock. All Rights Reserved.
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
