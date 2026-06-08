@extends('layouts.app')

@section('title', 'Laporan Inventaris - AgriStock')
@section('header_title', 'Laporan Inventaris')

@section('content')
<!-- Filter Panel Card -->
<div class="card card-custom p-4 mb-4">
    <h5 class="font-weight-bold text-green mb-3"><i class="fa-solid fa-filter me-2"></i> Filter Periode Laporan</h5>
    <form action="{{ route('reports.index') }}" method="GET" class="row g-3 align-items-end" id="filterForm">
        <!-- Preserve active tab state -->
        <input type="hidden" name="tab" id="activeTabInput" value="{{ $activeTab }}">

        <!-- Filter Type Selector -->
        <div class="col-md-3">
            <label for="filter_type" class="form-label font-weight-bold" style="font-size: 0.85rem;">Periode</label>
            <select name="filter_type" id="filter_type" class="form-select" onchange="toggleCustomDates()">
                <option value="all" {{ $filterType == 'all' ? 'selected' : '' }}>Semua Riwayat</option>
                <option value="today" {{ $filterType == 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="week" {{ $filterType == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="month" {{ $filterType == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="custom" {{ $filterType == 'custom' ? 'selected' : '' }}>Kustom Rentang Tanggal</option>
            </select>
        </div>

        <!-- Start Date -->
        <div class="col-md-3 custom-date-field" style="display: none;">
            <label for="start_date" class="form-label font-weight-bold" style="font-size: 0.85rem;">Tanggal Mulai</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
        </div>

        <!-- End Date -->
        <div class="col-md-3 custom-date-field" style="display: none;">
            <label for="end_date" class="form-label font-weight-bold" style="font-size: 0.85rem;">Tanggal Selesai</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
        </div>

        <!-- Filter Actions -->
        <div class="col-md-3">
            <button type="submit" class="btn btn-green w-100">
                <i class="fa-solid fa-sync me-2"></i> Terapkan Filter
            </button>
        </div>
    </form>
</div>

<!-- Reports View Workspace -->
<div class="card card-custom p-4">
    <!-- Tab Navigation Headers -->
    <ul class="nav nav-tabs mb-4" id="reportTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab == 'stock' ? 'active text-green border-bottom border-success border-2' : 'text-muted' }}" id="stock-tab" data-bs-toggle="tab" data-bs-target="#stock-pane" type="button" role="tab" aria-controls="stock-pane" aria-selected="true" onclick="changeTab('stock')">
                <i class="fa-solid fa-boxes-stacked me-2"></i> Laporan Stok Barang
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab == 'incoming' ? 'active text-green border-bottom border-success border-2' : 'text-muted' }}" id="incoming-tab" data-bs-toggle="tab" data-bs-target="#incoming-pane" type="button" role="tab" aria-controls="incoming-pane" aria-selected="false" onclick="changeTab('incoming')">
                <i class="fa-solid fa-arrow-down-long text-success me-2"></i> Laporan Barang Masuk
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab == 'outgoing' ? 'active text-green border-bottom border-success border-2' : 'text-muted' }}" id="outgoing-tab" data-bs-toggle="tab" data-bs-target="#outgoing-pane" type="button" role="tab" aria-controls="outgoing-pane" aria-selected="false" onclick="changeTab('outgoing')">
                <i class="fa-solid fa-arrow-up-long text-danger me-2"></i> Laporan Barang Keluar
            </button>
        </li>
    </ul>

    <!-- Tabs Workspace content -->
    <div class="tab-content" id="reportTabsContent">
        <!-- 1. Stock levels report pane -->
        <div class="tab-pane fade show {{ $activeTab == 'stock' ? 'active' : '' }}" id="stock-pane" role="tabpanel" aria-labelledby="stock-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="m-0 font-weight-bold text-dark">Laporan Stok Barang Saat Ini</h5>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()"><i class="fa-solid fa-print"></i> Cetak Laporan</button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle m-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Lokasi Rak</th>
                            <th>Batas Min. Stok</th>
                            <th>Stok Aktual</th>
                            <th>Status Keamanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($stockReport->count() > 0)
                            @foreach($stockReport as $idx => $item)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td><code>{{ $item->kode_barang }}</code></td>
                                    <td><strong>{{ $item->nama_barang }}</strong></td>
                                    <td>{{ $item->category->nama_kategori }}</td>
                                    <td>{{ $item->lokasi_rak ?? '-' }}</td>
                                    <td>{{ $item->stok_minimum }} {{ $item->satuan }}</td>
                                    <td>
                                        <span class="badge {{ $item->is_low_stock ? 'bg-danger' : 'bg-success' }} p-2">
                                            {{ $item->stok }} {{ $item->satuan }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->is_low_stock)
                                            <span class="text-danger font-weight-bold"><i class="fa-solid fa-circle-exclamation me-1 animate-pulse"></i> Stok Menipis</span>
                                        @else
                                            <span class="text-success font-weight-bold"><i class="fa-solid fa-circle-check me-1"></i> Aman</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada data barang terdaftar.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. Goods receipt report pane -->
        <div class="tab-pane fade show {{ $activeTab == 'incoming' ? 'active' : '' }}" id="incoming-pane" role="tabpanel" aria-labelledby="incoming-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="m-0 font-weight-bold text-dark">Laporan Transaksi Barang Masuk</h5>
                    <small class="text-muted">Periode: 
                        <strong>
                            @if($filterType == 'all')
                                Semua Riwayat
                            @elseif($filterType == 'today')
                                Hari Ini
                            @elseif($filterType == 'week')
                                Minggu Ini (Senin s/d Hari Ini)
                            @elseif($filterType == 'month')
                                Bulan Ini
                            @else
                                {{ !empty($startDate) ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Awal' }} - {{ !empty($endDate) ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Sekarang' }}
                            @endif
                        </strong>
                    </small>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()"><i class="fa-solid fa-print"></i> Cetak Laporan</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle m-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>No Transaksi</th>
                            <th>Barang</th>
                            <th>Jumlah Masuk</th>
                            <th>Supplier</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($incomingReport->count() > 0)
                            @foreach($incomingReport as $idx => $inc)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($inc->tanggal_masuk)->translatedFormat('d M Y') }}</td>
                                    <td><code>{{ $inc->nomor_transaksi }}</code></td>
                                    <td>
                                        <strong>{{ $inc->item->nama_barang }}</strong>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">Kode: {{ $inc->item->kode_barang }}</small>
                                    </td>
                                    <td><span class="badge bg-success p-2">+{{ $inc->jumlah }} {{ $inc->item->satuan }}</span></td>
                                    <td><strong>{{ $inc->supplier }}</strong></td>
                                    <td class="text-muted" style="font-size: 0.85rem;">{{ $inc->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Tidak ada riwayat transaksi barang masuk untuk periode ini.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. Goods release report pane -->
        <div class="tab-pane fade show {{ $activeTab == 'outgoing' ? 'active' : '' }}" id="outgoing-pane" role="tabpanel" aria-labelledby="outgoing-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="m-0 font-weight-bold text-dark">Laporan Transaksi Barang Keluar</h5>
                    <small class="text-muted">Periode: 
                        <strong>
                            @if($filterType == 'all')
                                Semua Riwayat
                            @elseif($filterType == 'today')
                                Hari Ini
                            @elseif($filterType == 'week')
                                Minggu Ini (Senin s/d Hari Ini)
                            @elseif($filterType == 'month')
                                Bulan Ini
                            @else
                                {{ !empty($startDate) ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Awal' }} - {{ !empty($endDate) ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Sekarang' }}
                            @endif
                        </strong>
                    </small>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()"><i class="fa-solid fa-print"></i> Cetak Laporan</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle m-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>No Transaksi</th>
                            <th>Barang</th>
                            <th>Jumlah Keluar</th>
                            <th>Tujuan Penggunaan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($outgoingReport->count() > 0)
                            @foreach($outgoingReport as $idx => $out)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($out->tanggal_keluar)->translatedFormat('d M Y') }}</td>
                                    <td><code>{{ $out->nomor_transaksi }}</code></td>
                                    <td>
                                        <strong>{{ $out->item->nama_barang }}</strong>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">Kode: {{ $out->item->kode_barang }}</small>
                                    </td>
                                    <td><span class="badge bg-danger p-2">-{{ $out->jumlah }} {{ $out->item->satuan }}</span></td>
                                    <td><strong>{{ $out->tujuan_penggunaan }}</strong></td>
                                    <td class="text-muted" style="font-size: 0.85rem;">{{ $out->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Tidak ada riwayat transaksi barang keluar untuk periode ini.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleCustomDates() {
        const select = document.getElementById('filter_type');
        const customFields = document.querySelectorAll('.custom-date-field');
        
        if (select.value === 'custom') {
            customFields.forEach(field => field.style.display = 'block');
            document.getElementById('start_date').required = true;
            document.getElementById('end_date').required = true;
        } else {
            customFields.forEach(field => field.style.display = 'none');
            document.getElementById('start_date').required = false;
            document.getElementById('end_date').required = false;
        }
    }

    function changeTab(tabName) {
        document.getElementById('activeTabInput').value = tabName;
    }

    // Run custom dates check on load
    window.addEventListener('DOMContentLoaded', toggleCustomDates);
</script>
<style>
    /* Styling specifically for printing reports */
    @media print {
        #sidebar, .navbar-custom, .alert, #filterForm, .nav-tabs, button, a.btn {
            display: none !important;
        }
        #content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .main-container {
            padding: 0 !important;
        }
        .card-custom {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
        }
        .table-responsive {
            overflow: visible !important;
        }
        .table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
    }
</style>
@endsection
