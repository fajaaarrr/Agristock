@extends('layouts.app')

@section('title', 'Barang Masuk - AgriStock')
@section('header_title', 'Barang Masuk')

@section('styles')
<style>
    @media (max-width: 576px) {
        .btn-action-text { display: none; }
        .tbl-hide-mobile { display: none; }
        .page-header-row { flex-direction: column !important; align-items: stretch !important; gap: 10px !important; }
        .page-header-row .btn-green { width: 100%; text-align: center; }
        .page-header-row .d-flex { max-width: 100% !important; }
        .page-header-row .input-group { flex-wrap: nowrap; }
        .page-header-row .form-control { flex: 1; min-width: 0; }
        .page-header-row .input-group .btn { flex-shrink: 0; }
    }
</style>
@endsection

@section('content')
<div class="card card-custom p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 page-header-row">
        <!-- Search form -->
        <form action="{{ route('incoming-goods.index') }}" method="GET" class="d-flex flex-grow-1" style="max-width: 400px;">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari No. Transaksi, Barang, Supplier..." value="{{ $search }}">
                <button class="btn btn-green" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i> <span class="d-none d-sm-inline">Cari</span>
                </button>
                @if(!empty($search))
                    <a href="{{ route('incoming-goods.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center px-3">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>
        </form>

        <!-- Record Incoming button -->
        <a href="{{ route('incoming-goods.create') }}" class="btn btn-green">
            <i class="fa-solid fa-plus-circle me-2"></i> Catat Barang Masuk
        </a>
    </div>

    <!-- Incoming Goods Table -->
    <div class="table-responsive">
        <table class="table table-hover table-custom align-middle">
            <thead>
                <tr>
                    <th>No Transaksi</th>
                    <th>Tanggal Masuk</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th class="tbl-hide-mobile">Supplier</th>
                    <th class="tbl-hide-mobile">Keterangan</th>
                    <th style="width: 80px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($incomingGoods->count() > 0)
                    @foreach($incomingGoods as $incoming)
                        <tr>
                            <td><code class="text-dark font-weight-bold">{{ $incoming->nomor_transaksi }}</code></td>
                            <td>{{ \Carbon\Carbon::parse($incoming->tanggal_masuk)->translatedFormat('d M Y') }}</td>
                            <td>
                                <a href="{{ route('items.show', $incoming->item_id) }}" class="text-decoration-none text-dark font-weight-bold">
                                    {{ $incoming->item->nama_barang }}
                                </a>
                                <small class="text-muted d-block" style="font-size: 0.8rem;">Kode: {{ $incoming->item->kode_barang }}</small>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success fs-7 p-2 rounded">
                                    +{{ $incoming->jumlah }} {{ $incoming->item->satuan }}
                                </span>
                            </td>
                            <td class="tbl-hide-mobile"><strong>{{ $incoming->supplier }}</strong></td>
                            <td class="tbl-hide-mobile text-muted" style="font-size: 0.9rem;">{{ $incoming->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                <form action="{{ route('incoming-goods.destroy', $incoming->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini? Stok barang bersangkutan akan dikurangi kembali sesuai jumlah transaksi ini.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Batalkan Transaksi / Hapus">
                                        <i class="fa-regular fa-trash-can"></i> <span class="btn-action-text">Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-arrow-down-long fs-1 mb-3 d-block text-secondary"></i>
                            Tidak ada data transaksi barang masuk ditemukan.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination links -->
    <div class="mt-4 d-flex justify-content-end">
        {{ $incomingGoods->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
