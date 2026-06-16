<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriStock - Sistem Inventaris Gudang Pertanian Indonesia</title>

    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Premium Styles -->
    <style>
        :root {
            --primary-green: hsl(135, 45%, 33%);
            --primary-green-dark: hsl(135, 45%, 20%);
            --primary-green-light: hsl(135, 45%, 45%);
            --primary-green-soft: hsl(135, 45%, 96%);
            --accent-gold: hsl(38, 95%, 52%);
            --accent-gold-dark: hsl(38, 95%, 40%);
            --bg-light: #f4f7f4;
            --text-dark: hsl(135, 30%, 15%);
            --text-muted: hsl(135, 10%, 45%);
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.4);
            --card-shadow: 0 10px 30px rgba(46, 125, 50, 0.08);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Navbar Styling */
        .custom-navbar {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--glass-border);
            padding: 15px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar-brand-custom {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-green-dark);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .navbar-brand-custom:hover {
            transform: scale(1.02);
            color: var(--primary-green);
        }

        .navbar-brand-custom i {
            color: var(--accent-gold);
        }

        .nav-link-custom {
            color: var(--text-dark);
            font-weight: 500;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link-custom:hover {
            color: var(--primary-green);
            background: rgba(46, 125, 50, 0.05);
        }

        .btn-nav-action {
            background-color: var(--primary-green);
            color: white;
            font-weight: 600;
            border-radius: 30px;
            padding: 8px 24px;
            border: none;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.2);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            display: inline-block;
        }

        .btn-nav-action:hover {
            background-color: var(--primary-green-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46, 125, 50, 0.3);
            color: white;
        }

        /* Hero Section Styling */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 100px;
            padding-bottom: 80px;
            background-image: linear-gradient(135deg, rgba(20, 50, 25, 0.85) 0%, rgba(200, 220, 200, 0.25) 100%), url('{{ asset("images/hero.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: scroll;
            color: white;
        }

        /* Ambient subtle fog layer for realistic depth */
        .hero-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background: linear-gradient(to top, var(--bg-light), transparent);
            z-index: 1;
        }

        .hero-container {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--accent-gold);
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            animation: fadeInUp 0.8s ease-out;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease-out;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .hero-title span {
            color: var(--accent-gold);
        }

        .hero-description {
            font-size: 1.25rem;
            font-weight: 400;
            line-height: 1.6;
            margin-bottom: 35px;
            color: rgba(255, 255, 255, 0.9);
            max-w: 650px;
            animation: fadeInUp 1.2s ease-out;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .hero-buttons {
            animation: fadeInUp 1.4s ease-out;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            background-color: var(--accent-gold);
            color: var(--primary-green-dark);
            font-weight: 700;
            border-radius: 30px;
            padding: 14px 35px;
            border: none;
            box-shadow: 0 8px 25px rgba(255, 152, 0, 0.35);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-hero-primary:hover {
            background-color: white;
            color: var(--primary-green-dark);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(255, 255, 255, 0.4);
        }

        .btn-hero-secondary {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: 600;
            border-radius: 30px;
            padding: 14px 35px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-hero-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: white;
            color: white;
            transform: translateY(-2px);
        }

        /* Stats Cards Styling */
        .stats-wrapper {
            margin-top: -60px;
            position: relative;
            z-index: 10;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(46, 125, 50, 0.05);
            text-align: center;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-gold));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(46, 125, 50, 0.15);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-icon {
            font-size: 2.5rem;
            color: var(--primary-green);
            margin-bottom: 15px;
            background: var(--primary-green-soft);
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.5s ease;
        }

        .stat-card:hover .stat-icon {
            transform: rotateY(360deg);
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 1rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Features Section */
        .features-section {
            padding: 100px 0;
            background-color: var(--bg-light);
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-badge {
            background-color: var(--primary-green-soft);
            color: var(--primary-green);
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-dark);
        }

        .feature-card {
            background: white;
            border-radius: 24px;
            padding: 40px 30px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(46, 125, 50, 0.03);
            height: 100%;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 45px rgba(46, 125, 50, 0.12);
        }

        .feature-icon-box {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary-green-soft) 0%, rgba(46, 125, 50, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary-green);
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon-box {
            background: var(--primary-green);
            color: white;
            transform: scale(1.05);
        }

        .feature-card h3 {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--text-dark);
        }

        .feature-card p {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin: 0;
        }

        /* Timeline Section */
        .timeline-section {
            padding: 100px 0;
            background-color: white;
        }

        .step-item {
            text-align: center;
            position: relative;
            padding: 0 20px;
        }

        .step-number {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary-green-soft);
            color: var(--primary-green);
            font-size: 1.5rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 0 0 6px #fff, 0 4px 15px rgba(46, 125, 50, 0.1);
            position: relative;
            z-index: 2;
        }

        .step-item::after {
            content: '';
            position: absolute;
            top: 30px;
            left: 50%;
            width: 100%;
            height: 2px;
            background: dashed rgba(46, 125, 50, 0.2);
            z-index: 1;
        }

        .col-md-3:last-child .step-item::after {
            display: none;
        }

        .step-item h4 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .step-item p {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Banner CTA */
        .banner-cta {
            background-image: linear-gradient(rgba(20, 50, 25, 0.9), rgba(20, 50, 25, 0.9)), url('{{ asset("images/hero.jpg") }}');
            background-size: cover;
            background-position: center;
            border-radius: 30px;
            padding: 80px 40px;
            color: white;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .banner-cta h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .banner-cta p {
            font-size: 1.15rem;
            max-w: 700px;
            margin: 0 auto 35px;
            color: rgba(255, 255, 255, 0.85);
        }

        /* Footer Styling */
        .custom-footer {
            background-color: var(--text-dark);
            color: rgba(255, 255, 255, 0.75);
            padding: 60px 0 30px;
        }

        .footer-logo {
            font-weight: 700;
            color: white;
            font-size: 1.6rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .footer-logo i {
            color: var(--accent-gold);
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.95rem;
        }

        .footer-link:hover {
            color: var(--accent-gold);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 25px;
            margin-top: 50px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Keyframes */
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

        /* Responsive Improvements */
        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 2.8rem;
            }
            .step-item::after {
                display: none;
            }
            .step-item {
                margin-bottom: 30px;
            }
            .stats-wrapper {
                margin-top: -30px;
            }
        }

        @media (max-width: 575.98px) {
            .hero-title {
                font-size: 2.2rem;
            }
            .hero-description {
                font-size: 1.05rem;
            }
            .btn-hero-primary, .btn-hero-secondary {
                width: 100%;
                justify-content: center;
            }
            .hero-buttons {
                flex-direction: column;
            }
            .banner-cta {
                padding: 60px 20px;
                border-radius: 20px;
            }
            .banner-cta h2 {
                font-size: 1.8rem;
            }
            .custom-navbar {
                padding: 10px 0;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation Header -->
    <nav class="navbar custom-navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand-custom" href="{{ url('/') }}">
                <i class="fa-solid fa-wheat-awn"></i> AgriStock
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center gap-3 mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link-custom" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="#alur">Alur Kerja</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-nav-action">
                                <i class="fa-solid fa-chart-line me-2"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-nav-action">
                                <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk Admin
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-badge">
                        <i class="fa-solid fa-seedling"></i> MODERN WAREHOUSE SYSTEM
                    </div>
                    <h1 class="hero-title">
                        Kelola Stok Hasil Tani & Inventaris Gudang <span>Lebih Efisien</span>
                    </h1>
                    <p class="hero-description">
                        Platform manajemen inventaris pertanian terintegrasi. Pantau ketersediaan beras, sayur, buah, pupuk, dan sarana produksi pertanian Anda secara real-time dengan akurasi tinggi.
                    </p>
                    <div class="hero-buttons">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-hero-primary">
                                <i class="fa-solid fa-gauge-high"></i> Masuk ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-hero-primary">
                                <i class="fa-solid fa-right-to-bracket"></i> Mulai Sekarang (Login)
                            </a>
                        @endauth
                        <a href="#fitur" class="btn-hero-secondary">
                            Pelajari Fitur <i class="fa-solid fa-arrow-down"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-overlay"></div>
    </section>

    <!-- Stats Section -->
    <div class="container stats-wrapper">
        <div class="row g-4 justify-content-center">
            <div class="col-md-4 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-cubes"></i>
                    </div>
                    <div class="stat-number">Real-Time</div>
                    <div class="stat-label">Pencatatan Stok Barang</div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                    </div>
                    <div class="stat-number">Otomatis</div>
                    <div class="stat-label">Laporan Keluar Masuk</div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="stat-number">Keamanan</div>
                    <div class="stat-label">Akses Multi-Gudang Terenkripsi</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="features-section" id="fitur">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Solusi Kami</span>
                <h2 class="section-title">Fitur Utama AgriStock</h2>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <h3>Manajemen Barang</h3>
                        <p>Catat data hasil tani, pupuk, benih, dan alat pertanian lengkap dengan kategori, satuan, dan jumlah stok ter-update secara instan.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="fa-solid fa-circle-arrow-down text-success"></i>
                        </div>
                        <h3>Transaksi Masuk</h3>
                        <p>Kelola barang masuk dari petani lokal atau produsen. Catat tanggal masuk, volume, dan supplier dengan form yang terstruktur.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="fa-solid fa-circle-arrow-up text-danger"></i>
                        </div>
                        <h3>Transaksi Keluar</h3>
                        <p>Catat pengeluaran barang untuk distribusi ke pasar, agen, atau kebutuhan lahan pertanian untuk menghindari selisih stok.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                        <h3>Laporan Berkala</h3>
                        <p>Hasilkan laporan ketersediaan stok, riwayat masuk-keluar barang berdasarkan rentang tanggal tertentu yang siap dicetak.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="fa-solid fa-tags"></i>
                        </div>
                        <h3>Kategori Kustom</h3>
                        <p>Atur pengelompokan barang secara rapi berdasarkan komoditas pangan, perkebunan, hortikultura, hingga kategori alat tani.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="fa-solid fa-mobile-screen-button"></i>
                        </div>
                        <h3>Responsif Mobile</h3>
                        <p>Akses inventaris gudang langsung dari smartphone Anda di lapangan dengan tampilan antarmuka yang ramah pengguna.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Work Flow Section -->
    <section class="timeline-section" id="alur">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Alur Kerja</span>
                <h2 class="section-title">Bagaimana AgriStock Bekerja?</h2>
            </div>
            <div class="row mt-5">
                <div class="col-md-3">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <h4>Login Admin</h4>
                        <p>Autentikasi admin gudang secara aman untuk masuk ke dasbor manajemen.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <h4>Input Barang</h4>
                        <p>Masukkan master data komoditas pertanian dan kelola kategorinya.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <h4>Catat Transaksi</h4>
                        <p>Catat setiap mutasi barang yang masuk (incoming) atau keluar (outgoing).</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <h4>Unduh Laporan</h4>
                        <p>Pantau rekap stok akhir dan unduh laporan berkala secara berkala.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Banner -->
    <section class="container my-5">
        <div class="banner-cta">
            <h2>Siap Mengotomatiskan Inventaris Gudang Tani?</h2>
            <p>
                Bergabunglah dengan pengelola gudang tani modern lainnya dan nikmati kemudahan memantau komoditas pertanian secara real-time.
            </p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn-hero-primary">
                    <i class="fa-solid fa-gauge-high"></i> Masuk Dasbor Utama
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-hero-primary">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk ke Sistem Sekarang
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="custom-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <a class="footer-logo" href="#">
                        <i class="fa-solid fa-wheat-awn"></i> AgriStock
                    </a>
                    <p class="pe-lg-5" style="color: rgba(255,255,255,0.6);">
                        Platform inventaris gudang pertanian terpercaya di Indonesia. Membantu digitalisasi pencatatan logistik pertanian nasional demi ketahanan pangan yang lebih baik.
                    </p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-3 font-semibold">Tautan Cepat</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="#fitur" class="footer-link">Fitur Solusi</a></li>
                        <li><a href="#alur" class="footer-link">Alur Kerja</a></li>
                        <li><a href="{{ route('login') }}" class="footer-link">Login Admin</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white mb-3 font-semibold">Informasi Kontak</h5>
                    <p class="mb-2" style="color: rgba(255,255,255,0.6);"><i class="fa-solid fa-location-dot me-2 text-warning"></i> Jl. Pertanian Raya No. 45, Cianjur, Jawa Barat</p>
                    <p class="mb-2" style="color: rgba(255,255,255,0.6);"><i class="fa-solid fa-envelope me-2 text-warning"></i> support@agristock.co.id</p>
                    <p style="color: rgba(255,255,255,0.6);"><i class="fa-solid fa-phone me-2 text-warning"></i> +62 21-8899-7766</p>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p class="mb-0">&copy; 2026 AgriStock. Seluruh hak cipta dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
