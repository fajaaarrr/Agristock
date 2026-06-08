@extends('layouts.app')

@section('title', 'Dashboard - AgriStock')
@section('header_title', 'Dashboard')

@section('content')
<!-- Row 1: Statistics Cards -->
<div class="row">
    <!-- Total Barang -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-custom border-start border-success border-4 h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            Total Barang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 1.8rem; font-weight: 700;">{{ $total_items }}</div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-success-subtle p-3 rounded-circle text-success" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-boxes-stacked fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kategori -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-custom border-start border-primary border-4 h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            Total Kategori</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 1.8rem; font-weight: 700;">{{ $total_categories }}</div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-primary-subtle p-3 rounded-circle text-primary" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-tags fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Masuk Bulan Ini -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-custom border-start border-info border-4 h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            Masuk Bulan Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 1.8rem; font-weight: 700;">{{ $total_incoming_this_month }}</div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-info-subtle p-3 rounded-circle text-info" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-cloud-arrow-down fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Keluar Bulan Ini -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-custom border-start border-warning border-4 h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            Keluar Bulan Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 1.8rem; font-weight: 700;">{{ $total_outgoing_this_month }}</div>
                    </div>
                    <div class="col-auto">
                        <div class="bg-warning-subtle p-3 rounded-circle text-warning" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-cloud-arrow-up fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Charts and Low Stock Widget -->
<div class="row">
    <!-- Chart Column -->
    <div class="col-xl-8 col-lg-7">
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="m-0 font-weight-bold text-green"><i class="fa-solid fa-chart-column me-2"></i> Grafik Aliran Barang (Tahun {{ date('Y') }})</h5>
            </div>
            <div style="position: relative; height: 320px;">
                <canvas id="inventoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert Widget -->
    <div class="col-xl-4 col-lg-5">
        <div class="card card-custom h-100 p-4">
            <h5 class="mb-3 font-weight-bold text-danger d-flex align-items-center">
                <i class="fa-solid fa-triangle-exclamation me-2 animate-bounce"></i>
                Stok Menipis ({{ $low_stock_items->count() }})
            </h5>
            <div class="overflow-auto" style="max-height: 320px;">
                @if($low_stock_items->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($low_stock_items as $lowItem)
                            <div class="list-group-item px-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="m-0 font-weight-bold text-dark">{{ $lowItem->nama_barang }}</h6>
                                    <small class="text-muted">Kode: {{ $lowItem->kode_barang }} | Rak: {{ $lowItem->lokasi_rak ?? '-' }}</small>
                                </div>
                                <div class="text-end">
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
    <div class="col-lg-6 mb-4">
        <div class="card card-custom h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="m-0 font-weight-bold text-green"><i class="fa-solid fa-plus-circle me-2"></i> Barang Terbaru Ditambahkan</h5>
                <a href="{{ route('items.index') }}" class="btn btn-sm btn-outline-success border-0">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-custom m-0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($recent_items->count() > 0)
                            @foreach($recent_items as $recentItem)
                                <tr>
                                    <td><code class="text-dark">{{ $recentItem->kode_barang }}</code></td>
                                    <td>
                                        <a href="{{ route('items.show', $recentItem->id) }}" class="text-decoration-none text-dark font-weight-bold">
                                            {{ $recentItem->nama_barang }}
                                        </a>
                                    </td>
                                    <td><span class="badge bg-secondary-subtle text-dark">{{ $recentItem->category->nama_kategori }}</span></td>
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
    <div class="col-lg-6 mb-4">
        <div class="card card-custom h-100 p-4">
            <h5 class="mb-3 font-weight-bold text-green"><i class="fa-solid fa-clock-rotate-left me-2"></i> Aktivitas Terakhir</h5>
            <div class="timeline" style="max-height: 320px; overflow-y: auto;">
                @if(count($recent_activities) > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recent_activities as $act)
                            <div class="list-group-item px-0 py-3 border-bottom d-flex align-items-start">
                                <div class="activity-icon me-3 bg-{{ $act['type'] == 'incoming' ? 'success' : 'danger' }}-subtle text-{{ $act['type'] == 'incoming' ? 'success' : 'danger' }} p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                                    <i class="fa-solid fa-{{ $act['type'] == 'incoming' ? 'arrow-down-long' : 'arrow-up-long' }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong class="text-dark">{{ $act['type'] == 'incoming' ? 'Barang Masuk' : 'Barang Keluar' }}</strong>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($act['tanggal'])->translatedFormat('d M Y') }}</small>
                                    </div>
                                    <p class="mb-1 text-muted" style="font-size: 0.9rem;">
                                        Barang <strong class="text-dark">{{ $act['nama_barang'] }}</strong> sebanyak 
                                        <span class="badge bg-{{ $act['type'] == 'incoming' ? 'success' : 'danger' }}-subtle text-{{ $act['type'] == 'incoming' ? 'success' : 'danger' }}">
                                            {{ $act['jumlah'] }} {{ $act['satuan'] }}
                                        </span> 
                                        {{ $act['type'] == 'incoming' ? 'diterima dari' : 'digunakan untuk' }} 
                                        <strong>{{ $act['label'] }}</strong>.
                                    </p>
                                    <small class="text-muted d-block" style="font-size: 0.8rem;">
                                        No Transaksi: <code>{{ $act['nomor_transaksi'] }}</code> 
                                        @if(!empty($act['keterangan']))
                                            | Keterangan: {{ $act['keterangan'] }}
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
