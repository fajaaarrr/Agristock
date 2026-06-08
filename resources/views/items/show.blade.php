@extends('layouts.app')

@section('title', 'Detail Barang - AgriStock')
@section('header_title', 'Detail Barang')

@section('content')
<div class="row">
    <!-- Item Info Panel -->
    <div class="col-lg-4 mb-4">
        <div class="card card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('items.index') }}" class="btn btn-sm btn-light text-muted">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-green">
                    <i class="fa-regular fa-pen-to-square me-1"></i> Edit
                </a>
            </div>

            <div class="text-center pb-4 border-bottom">
                <div class="bg-success-subtle text-success p-4 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-box fs-1"></i>
                </div>
                <h4 class="font-weight-bold text-dark mb-1">{{ $item->nama_barang }}</h4>
                <code class="text-dark fs-6 font-weight-bold">{{ $item->kode_barang }}</code>
            </div>

            <!-- Details List -->
            <div class="mt-4">
                <div class="mb-3">
                    <span class="text-muted d-block" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Kategori</span>
                    <strong class="text-dark">{{ $item->category->nama_kategori }}</strong>
                </div>

                <div class="mb-3">
                    <span class="text-muted d-block" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Satuan Ukuran</span>
                    <strong class="text-dark">{{ $item->satuan }}</strong>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <span class="text-muted d-block" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Stok Saat Ini</span>
                        <span class="badge {{ $item->is_low_stock ? 'badge-low-stock' : 'bg-success' }} fs-6 px-3 py-2 mt-1">
                            {{ $item->stok }}
                        </span>
                    </div>
                    <div class="col-6">
                        <span class="text-muted d-block" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Stok Minimum</span>
                        <strong class="text-dark fs-5">{{ $item->stok_minimum }}</strong>
                    </div>
                </div>

                <div class="mb-3">
                    <span class="text-muted d-block" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Lokasi Rak</span>
                    <strong class="text-dark"><i class="fa-solid fa-location-dot me-1 text-secondary"></i> {{ $item->lokasi_rak ?? 'Belum ditentukan' }}</strong>
                </div>

                <div class="mb-3">
                    <span class="text-muted d-block" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">Keterangan / Deskripsi</span>
                    <p class="text-dark mb-0" style="font-size: 0.95rem;">{{ $item->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                </div>

                @if($item->is_low_stock)
                    <div class="alert alert-danger border-0 p-3 mt-4 mb-0" style="border-left: 4px solid #d32f2f !important; font-size: 0.85rem;">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        <strong>Peringatan!</strong> Stok barang ini telah menyentuh atau berada di bawah batas minimum ({{ $item->stok_minimum }}). Harap segera lakukan pemesanan ulang.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Transaction Histories -->
    <div class="col-lg-8 mb-4">
        <div class="card card-custom p-4 h-100">
            <h5 class="font-weight-bold text-green mb-4"><i class="fa-solid fa-clock-rotate-left me-2"></i> Riwayat Transaksi Barang</h5>

            <!-- Tabs Navigation -->
            <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-incoming-tab" data-bs-toggle="pill" data-bs-target="#pills-incoming" type="button" role="tab" aria-controls="pills-incoming" aria-selected="true">
                        <i class="fa-solid fa-arrow-down-long text-success me-2"></i> Barang Masuk ({{ $item->incomingGoods->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-outgoing-tab" data-bs-toggle="pill" data-bs-target="#pills-outgoing" type="button" role="tab" aria-controls="pills-outgoing" aria-selected="false">
                        <i class="fa-solid fa-arrow-up-long text-danger me-2"></i> Barang Keluar ({{ $item->outgoingGoods->count() }})
                    </button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content" id="pills-tabContent">
                <!-- Incoming goods history -->
                <div class="tab-pane fade show active" id="pills-incoming" role="tabpanel" aria-labelledby="pills-incoming-tab">
                    <div class="table-responsive">
                        <table class="table table-hover table-custom align-middle">
                            <thead>
                                <tr>
                                    <th>No Transaksi</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Jumlah</th>
                                    <th>Supplier</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($item->incomingGoods->count() > 0)
                                    @foreach($item->incomingGoods as $inc)
                                        <tr>
                                            <td><code class="text-dark font-weight-bold">{{ $inc->nomor_transaksi }}</code></td>
                                            <td>{{ \Carbon\Carbon::parse($inc->tanggal_masuk)->translatedFormat('d M Y') }}</td>
                                            <td><span class="badge bg-success-subtle text-success p-2 rounded">{{ $inc->jumlah }}</span></td>
                                            <td><strong>{{ $inc->supplier }}</strong></td>
                                            <td class="text-muted" style="font-size: 0.85rem;">{{ $inc->keterangan ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat masuk.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Outgoing goods history -->
                <div class="tab-pane fade" id="pills-outgoing" role="tabpanel" aria-labelledby="pills-outgoing-tab">
                    <div class="table-responsive">
                        <table class="table table-hover table-custom align-middle">
                            <thead>
                                <tr>
                                    <th>No Transaksi</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Jumlah</th>
                                    <th>Tujuan Penggunaan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($item->outgoingGoods->count() > 0)
                                    @foreach($item->outgoingGoods as $out)
                                        <tr>
                                            <td><code class="text-dark font-weight-bold">{{ $out->nomor_transaksi }}</code></td>
                                            <td>{{ \Carbon\Carbon::parse($out->tanggal_keluar)->translatedFormat('d M Y') }}</td>
                                            <td><span class="badge bg-danger-subtle text-danger p-2 rounded">{{ $out->jumlah }}</span></td>
                                            <td><strong>{{ $out->tujuan_penggunaan }}</strong></td>
                                            <td class="text-muted" style="font-size: 0.85rem;">{{ $out->keterangan ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat keluar.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
