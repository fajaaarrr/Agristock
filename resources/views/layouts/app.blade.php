<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AgriStock - Sistem Inventaris Gudang Pertanian')</title>
    
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
            --primary-green: #2e7d32;
            --primary-green-dark: #1b5e20;
            --primary-green-light: #4caf50;
            --primary-green-soft: #e8f5e9;
            --accent-orange: #ff9800;
            --bg-light: #f8faf7;
            --text-dark: #2c3e2e;
            --text-muted: #6c7a70;
            --sidebar-width: 260px;
        }

        /* Mobile Viewport Fix */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        #sidebar .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
        }

        #sidebar .sidebar-header h3 {
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 0;
        }

        #sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 12px 24px;
            font-weight: 500;
            border-radius: 0;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            border-left: 4px solid transparent;
        }

        #sidebar .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            border-left-color: var(--primary-green-light);
        }

        #sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.15);
            border-left-color: var(--primary-green-light);
            font-weight: 600;
        }

        #sidebar .nav-link i {
            width: 24px;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* Main Content Panel */
        #content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s;
        }

        .navbar-custom {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 16px 24px;
        }

        .main-container {
            padding: 30px 24px;
        }

        /* Sidebar Overlay Backdrop */
        #sidebarOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        #sidebarOverlay.active {
            display: block;
        }

        /* Cards & Components */
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            background-color: white;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 24px;
        }

        .card-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        }

        .btn-green {
            background-color: var(--primary-green);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            transition: all 0.2s;
        }

        .btn-green:hover {
            background-color: var(--primary-green-dark);
            color: white;
            box-shadow: 0 4px 10px rgba(46, 125, 50, 0.2);
        }

        .badge-low-stock {
            background-color: #dc3545;
            color: white;
            font-weight: 600;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4);
            }
            70% {
                box-shadow: 0 0 0 8px rgba(220, 53, 69, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }

        .text-green {
            color: var(--primary-green) !important;
        }

        /* Table custom styling */
        .table-custom th {
            font-weight: 600;
            color: var(--text-muted);
            border-bottom: 2px solid var(--primary-green-soft);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .table-custom td {
            vertical-align: middle;
        }

        /* Hide hamburger button on desktop */
        @media (min-width: 769px) {
            #sidebarCollapse {
                display: none !important;
            }
        }

        /* Sidebar toggle on mobile */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
                z-index: 1050;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                margin-left: 0 !important;
            }
            .navbar-custom {
                padding: 12px 16px;
            }
            .main-container {
                padding: 16px 12px;
            }
            /* Notification dropdown full width on mobile */
            .dropdown-menu[aria-labelledby="notificationDropdown"] {
                width: calc(100vw - 24px) !important;
                max-width: 320px;
                right: -60px !important;
            }
            /* Page title always visible on mobile */
            .navbar-page-title {
                display: block !important;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 576px) {
            .main-container {
                padding: 12px 10px;
            }
            .card-custom {
                padding: 16px !important;
            }
            .card-custom.p-4 {
                padding: 16px !important;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <nav id="sidebar">
        <div class="sidebar-header d-flex align-items-center">
            <i class="fa-solid fa-wheat-awn text-warning me-2 fs-4"></i>
            <h3>AgriStock</h3>
        </div>
        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('categories.index') }}" class="nav-link {{ Route::is('categories.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Kategori Barang
            </a>
            <a href="{{ route('items.index') }}" class="nav-link {{ Route::is('items.*') ? 'active' : '' }}">
                <i class="fa-solid fa-boxes-stacked"></i> Stok Barang
            </a>
            <a href="{{ route('incoming-goods.index') }}" class="nav-link {{ Route::is('incoming-goods.*') ? 'active' : '' }}">
                <i class="fa-solid fa-arrow-down-long text-success"></i> Barang Masuk
            </a>
            <a href="{{ route('outgoing-goods.index') }}" class="nav-link {{ Route::is('outgoing-goods.*') ? 'active' : '' }}">
                <i class="fa-solid fa-arrow-up-long text-danger"></i> Barang Keluar
            </a>
            <a href="{{ route('reports.index') }}" class="nav-link {{ Route::is('reports.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice"></i> Laporan
            </a>
        </div>
    </nav>

    <!-- Sidebar Overlay Backdrop (Mobile) -->
    <div id="sidebarOverlay"></div>

    <!-- Main Content wrapper -->
    <div id="content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-custom navbar-light d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button type="button" id="sidebarCollapse" class="btn btn-outline-secondary border-0 me-2 me-md-3" style="border-radius: 8px;">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h5 class="m-0 font-weight-bold navbar-page-title" style="font-size: 1rem;">
                    @yield('header_title', 'Sistem Inventaris Gudang')
                </h5>
            </div>

            <div class="d-flex align-items-center">
                <!-- Notifications Dropdown (Low Stock Warning) -->
                <div class="dropdown me-4">
                    <button class="btn btn-light position-relative rounded-circle p-2" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="width: 40px; height: 40px;">
                        <i class="fa-regular fa-bell text-secondary"></i>
                        @if(isset($allLowStockItems) && $allLowStockItems->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                                {{ $allLowStockItems->count() }}
                            </span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-0" aria-labelledby="notificationDropdown" style="width: 320px; border-radius: 12px; overflow: hidden;">
                        <div class="bg-danger text-white p-3 d-flex align-items-center justify-content-between">
                            <h6 class="m-0"><i class="fa-solid fa-triangle-exclamation me-2"></i> Peringatan Stok Menipis</h6>
                            <span class="badge bg-white text-danger">{{ isset($allLowStockItems) ? $allLowStockItems->count() : 0 }} Barang</span>
                        </div>
                        <div class="list-group list-group-flush" style="max-height: 250px; overflow-y: auto;">
                            @if(isset($allLowStockItems) && $allLowStockItems->count() > 0)
                                @foreach($allLowStockItems as $notifItem)
                                    <a href="{{ route('items.show', $notifItem->id) }}" class="list-group-item list-group-item-action p-3">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <strong class="text-dark">{{ $notifItem->nama_barang }}</strong>
                                            <span class="badge bg-danger-subtle text-danger rounded-pill">{{ $notifItem->stok }} {{ $notifItem->satuan }}</span>
                                        </div>
                                        <small class="text-muted d-block mt-1">Kode: {{ $notifItem->kode_barang }} | Rak: {{ $notifItem->lokasi_rak ?? '-' }}</small>
                                        <small class="text-danger d-block mt-1 font-weight-bold">Minimum: {{ $notifItem->stok_minimum }}</small>
                                    </a>
                                @endforeach
                            @else
                                <div class="p-4 text-center text-muted">
                                    <i class="fa-regular fa-circle-check text-success fs-3 mb-2 d-block"></i>
                                    Semua stok barang dalam kondisi aman.
                                </div>
                            @endif
                        </div>
                        <div class="bg-light p-2 text-center">
                            <a href="{{ route('items.index', ['search' => '']) }}" class="text-decoration-none text-green font-weight-bold" style="font-size: 0.85rem;">Lihat Semua Barang</a>
                        </div>
                    </ul>
                </div>

                <!-- Admin Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center px-3 py-2 border-0 bg-transparent" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar bg-success text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: 700;">
                            A
                        </div>
                        <span class="d-none d-md-inline text-dark" style="font-weight: 500;">Admin Gudang</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="profileDropdown" style="border-radius: 10px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="font-weight-bold text-dark">{{ Auth::user()->name ?? 'Admin Gudang' }}</div>
                            <small class="text-muted">{{ Auth::user()->email ?? 'admin@agristock.com' }}</small>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger d-flex align-items-center py-2">
                                    <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Workspace -->
        <div class="main-container">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 5px solid #2e7d32 !important; border-radius: 8px;">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-circle-check text-success fs-4 me-3"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 5px solid #d32f2f !important; border-radius: 8px;">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-circle-exclamation text-danger fs-4 me-3"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sidebar mobile toggler script -->
    <script>
        const sidebarCollapseBtn = document.getElementById('sidebarCollapse');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        sidebarCollapseBtn.addEventListener('click', function () {
            if (sidebar.classList.contains('active')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        overlay.addEventListener('click', closeSidebar);

        // Close sidebar on nav link click (mobile)
        document.querySelectorAll('#sidebar .nav-link').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
