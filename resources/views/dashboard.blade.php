@extends('layouts.app')

@section('title', 'Dashboard - AgriStock')
@section('header_title', 'Dashboard')

@section('styles')
<style>
    /* Custom premium styling for dashboard cards */
    .stat-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.01) !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    /* Specific glows/borders on hover */
    .stat-card-success:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(46, 125, 50, 0.08) !important;
        border-color: rgba(46, 125, 50, 0.2) !important;
    }
    .stat-card-primary:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(13, 110, 253, 0.08) !important;
        border-color: rgba(13, 110, 253, 0.2) !important;
    }
    .stat-card-info:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(8, 145, 178, 0.08) !important;
        border-color: rgba(8, 145, 178, 0.2) !important;
    }
    .stat-card-warning:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(217, 119, 6, 0.08) !important;
        border-color: rgba(217, 119, 6, 0.2) !important;
    }

    /* Icon wrappers */
    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        transition: transform 0.3s ease;
    }

    .stat-card:hover .stat-icon-wrapper {
        transform: scale(1.08) rotate(3deg);
    }

    .stat-success {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.12) 0%, rgba(46, 125, 50, 0.25) 100%);
        color: #2e7d32;
    }

    .stat-primary {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.12) 0%, rgba(13, 110, 253, 0.25) 100%);
        color: #0d6efd;
    }

    .stat-info {
        background: linear-gradient(135deg, rgba(8, 145, 178, 0.12) 0%, rgba(8, 145, 178, 0.25) 100%);
        color: #0891b2;
    }

    .stat-warning {
        background: linear-gradient(135deg, rgba(217, 119, 6, 0.12) 0%, rgba(217, 119, 6, 0.25) 100%);
        color: #d97706;
    }

    /* Label & values */
    .stat-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c7a70;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 6px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1a251c;
        margin: 0;
        line-height: 1.1;
    }

    .stat-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05) !important;
    }

    .stat-footer-text {
        font-size: 0.75rem;
        font-weight: 500;
        color: #8a9a8f !important;
        display: flex;
        align-items: center;
    }

    /* Background decorative glow */
    .stat-bg-glow {
        position: absolute;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        filter: blur(40px);
        opacity: 0.08;
        top: -50px;
        right: -50px;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-bg-glow {
        transform: scale(1.2);
        opacity: 0.15;
    }

    .glow-success { background-color: #2e7d32; }
    .glow-primary { background-color: #0d6efd; }
    .glow-info { background-color: #0891b2; }
    .glow-warning { background-color: #d97706; }

    @media (max-width: 576px) {
        /* Stat cards: 2 columns on mobile */
        .stat-card-col {
            width: 50% !important;
            flex: 0 0 50% !important;
            max-width: 50% !important;
            padding-left: 6px !important;
            padding-right: 6px !important;
        }
        .stat-card .card-body {
            padding: 12px 14px !important;
        }
        .stat-icon-wrapper {
            width: 38px;
            height: 38px;
            font-size: 1rem;
            border-radius: 8px;
        }
        .stat-label {
            font-size: 0.65rem;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .stat-value {
            font-size: 1.4rem;
        }
        .stat-footer-text {
            font-size: 0.68rem;
        }
        /* Chart smaller on mobile */
        #inventoryChart-wrapper {
            height: 220px !important;
        }
        /* Activity log wrapping */
        .activity-text {
            font-size: 0.82rem !important;
        }
        /* Dashboard row gap */
        .dashboard-stats-row {
            margin-left: -6px !important;
            margin-right: -6px !important;
        }
    }
</style>
@endsection

@section('content')
<!-- Row 1: Statistics Cards -->
<div class="row dashboard-stats-row">
    <!-- Total Barang -->
    <div class="col-xl-3 col-md-6 col-6 mb-4 stat-card-col">
        <div class="card stat-card stat-card-success border-0">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon-wrapper stat-success">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <div class="stat-bg-glow glow-success"></div>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Total Barang</span>
                    <h3 class="stat-value">{{ $total_items }}</h3>
                </div>
                <div class="stat-footer mt-3 pt-2">
                    <span class="stat-footer-text">
                        <i class="fa-solid fa-circle-check text-success me-1"></i> Terdaftar di sistem
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kategori -->
    <div class="col-xl-3 col-md-6 col-6 mb-4 stat-card-col">
        <div class="card stat-card stat-card-primary border-0">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon-wrapper stat-primary">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <div class="stat-bg-glow glow-primary"></div>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Total Kategori</span>
                    <h3 class="stat-value">{{ $total_categories }}</h3>
                </div>
                <div class="stat-footer mt-3 pt-2">
                    <span class="stat-footer-text">
                        <i class="fa-solid fa-folder-open text-primary me-1"></i> Klasifikasi barang
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Masuk Bulan Ini -->
    <div class="col-xl-3 col-md-6 col-6 mb-4 stat-card-col">
        <div class="card stat-card stat-card-info border-0">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon-wrapper stat-info">
                        <i class="fa-solid fa-cloud-arrow-down"></i>
                    </div>
                    <div class="stat-bg-glow glow-info"></div>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Masuk Bulan Ini</span>
                    <h3 class="stat-value">{{ $total_incoming_this_month }}</h3>
                </div>
                <div class="stat-footer mt-3 pt-2">
                    <span class="stat-footer-text">
                        <i class="fa-solid fa-circle-arrow-down text-info me-1"></i> Transaksi masuk
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Keluar Bulan Ini -->
    <div class="col-xl-3 col-md-6 col-6 mb-4 stat-card-col">
        <div class="card stat-card stat-card-warning border-0">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon-wrapper stat-warning">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <div class="stat-bg-glow glow-warning"></div>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Keluar Bulan Ini</span>
                    <h3 class="stat-value">{{ $total_outgoing_this_month }}</h3>
                </div>
                <div class="stat-footer mt-3 pt-2">
                    <span class="stat-footer-text">
                        <i class="fa-solid fa-circle-arrow-up text-warning me-1"></i> Transaksi keluar
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Charts and Low Stock Widget -->
<div class="row">
    <!-- Chart Column -->
    <div class="col-xl-8 col-lg-7 col-12">
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="m-0 font-weight-bold text-green" style="font-size: 0.95rem;"><i class="fa-solid fa-chart-column me-2"></i> Grafik Aliran Barang (Tahun {{ date('Y') }})</h5>
            </div>
            <div id="inventoryChart-wrapper" style="position: relative; height: 320px;">
                <canvas id="inventoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert Widget -->
    <div class="col-xl-4 col-lg-5 col-12">
        <div class="card card-custom h-100 p-4">
            <h5 class="mb-3 font-weight-bold text-danger d-flex align-items-center" style="font-size: 0.95rem;">
                <i class="fa-solid fa-triangle-exclamation me-2 animate-bounce"></i>
                Stok Menipis ({{ $low_stock_items->count() }})
            </h5>
            <div class="overflow-auto" style="max-height: 320px;">
                @if($low_stock_items->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($low_stock_items as $lowItem)
                            <div class="list-group-item px-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="m-0 font-weight-bold text-dark" style="font-size: 0.9rem;">{{ $lowItem->nama_barang }}</h6>
                                    <small class="text-muted">Kode: {{ $lowItem->kode_barang }} | Rak: {{ $lowItem->lokasi_rak ?? '-' }}</small>
                                </div>
                                <div class="text-end ms-2">
                                    <span class="badge badge-low-stock p-2 rounded-pill mb-1">
                                        {{ $lowItem->stok }} {{ $lowItem->satuan }}
                                    </span>
                                    <small class="text-muted d-block text-danger font-weight-bold" style="font-size: 0.75rem;">Batas: {{ $lowItem->stok_minimum }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fa-regular fa-circle-check text-success fs-1 mb-3"></i>
                        <p class="mb-0">Semua barang memiliki stok yang cukup.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Row 3: Recently Added and Recent Activities -->
<div class="row mt-4">
    <!-- Recently Added Items -->
    <div class="col-lg-6 col-12 mb-4">
        <div class="card card-custom h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="m-0 font-weight-bold text-green" style="font-size: 0.9rem;"><i class="fa-solid fa-plus-circle me-2"></i> Barang Terbaru Ditambahkan</h5>
                <a href="{{ route('items.index') }}" class="btn btn-sm btn-outline-success border-0">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-custom m-0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th class="d-none d-md-table-cell">Kategori</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($recent_items->count() > 0)
                            @foreach($recent_items as $recentItem)
                                <tr>
                                    <td><code class="text-dark" style="font-size: 0.8rem;">{{ $recentItem->kode_barang }}</code></td>
                                    <td>
                                        <a href="{{ route('items.show', $recentItem->id) }}" class="text-decoration-none text-dark font-weight-bold" style="font-size: 0.9rem;">
                                            {{ $recentItem->nama_barang }}
                                        </a>
                                    </td>
                                    <td class="d-none d-md-table-cell"><span class="badge bg-secondary-subtle text-dark">{{ $recentItem->category->nama_kategori }}</span></td>
                                    <td>
                                        <span class="badge {{ $recentItem->is_low_stock ? 'bg-danger' : 'bg-success' }}">
                                            {{ $recentItem->stok }} {{ $recentItem->satuan }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada data barang.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Activity Log (Incoming + Outgoing combined) -->
    <div class="col-lg-6 col-12 mb-4">
        <div class="card card-custom h-100 p-4">
            <h5 class="mb-3 font-weight-bold text-green" style="font-size: 0.9rem;"><i class="fa-solid fa-clock-rotate-left me-2"></i> Aktivitas Terakhir</h5>
            <div class="timeline" style="max-height: 320px; overflow-y: auto;">
                @if(count($recent_activities) > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recent_activities as $act)
                            <div class="list-group-item px-0 py-3 border-bottom d-flex align-items-start">
                                <div class="activity-icon me-3 bg-{{ $act['type'] == 'incoming' ? 'success' : 'danger' }}-subtle text-{{ $act['type'] == 'incoming' ? 'success' : 'danger' }} p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; flex-shrink: 0;">
                                    <i class="fa-solid fa-{{ $act['type'] == 'incoming' ? 'arrow-down-long' : 'arrow-up-long' }}" style="font-size: 0.85rem;"></i>
                                </div>
                                <div class="flex-grow-1" style="min-width: 0;">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                                        <strong class="text-dark" style="font-size: 0.88rem;">{{ $act['type'] == 'incoming' ? 'Barang Masuk' : 'Barang Keluar' }}</strong>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($act['tanggal'])->translatedFormat('d M Y') }}</small>
                                    </div>
                                    <p class="mb-1 text-muted activity-text" style="font-size: 0.85rem;">
                                        <strong class="text-dark">{{ $act['nama_barang'] }}</strong> — 
                                        <span class="badge bg-{{ $act['type'] == 'incoming' ? 'success' : 'danger' }}-subtle text-{{ $act['type'] == 'incoming' ? 'success' : 'danger' }}">
                                            {{ $act['jumlah'] }} {{ $act['satuan'] }}
                                        </span>
                                    </p>
                                    <small class="text-muted d-block" style="font-size: 0.78rem;">
                                        No: <code>{{ $act['nomor_transaksi'] }}</code>
                                        @if(!empty($act['keterangan']))
                                            | {{ $act['keterangan'] }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-list-check fs-1 mb-3 text-secondary"></i>
                        <p class="mb-0">Belum ada riwayat aktivitas transaksi.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('inventoryChart').getContext('2d');
        const chartData = @json($chart_data);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: chartData.incoming,
                        backgroundColor: 'rgba(46, 125, 50, 0.85)',
                        borderColor: '#2e7d32',
                        borderWidth: 1.5,
                        borderRadius: 6,
                    },
                    {
                        label: 'Barang Keluar',
                        data: chartData.outgoing,
                        backgroundColor: 'rgba(220, 53, 69, 0.85)',
                        borderColor: '#dc3545',
                        borderWidth: 1.5,
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                family: 'Outfit',
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        titleFont: {
                            family: 'Outfit'
                        },
                        bodyFont: {
                            family: 'Outfit'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                family: 'Outfit'
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                family: 'Outfit'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
