@extends('layouts.app')

@section('title', 'Daftar Barang - AgriStock')
@section('header_title', 'Stok Barang')

@section('content')
<div class="card card-custom p-4">
    <!-- Search and Filters Form -->
    <form action="{{ route('items.index') }}" method="GET" class="row g-3 mb-4 align-items-center">
        <!-- Search bar -->
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Cari Kode, Nama Barang, atau Rak..." value="{{ $search }}">
            </div>
        </div>

        <!-- Category Filter -->
        <div class="col-md-4">
            <select name="category_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Semua Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                        {{ $category->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Search button & Reset -->
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-green w-100" type="submit">Filter</button>
            @if(!empty($search) || !empty($categoryId))
                <a href="{{ route('items.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center p-2" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>

    <!-- Header Actions -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="text-muted m-0">Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} barang</h6>
        <a href="{{ route('items.create') }}" class="btn btn-green">
            <i class="fa-solid fa-plus-circle me-2"></i> Tambah Barang
        </a>
    </div>

    <!-- Items Table -->
    <div class="table-responsive">
        <table class="table table-hover table-custom align-middle">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Lokasi Rak</th>
                    <th>Stok</th>
                    <th>Stok Min</th>
                    <th style="width: 240px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($items->count() > 0)
                    @foreach($items as $item)
                        <tr class="{{ $item->is_low_stock ? 'table-danger-subtle' : '' }}">
                            <td><code class="text-dark font-weight-bold">{{ $item->kode_barang }}</code></td>
                            <td>
                                <div>
                                    <strong class="text-dark">{{ $item->nama_barang }}</strong>
                                    @if($item->is_low_stock)
                                        <span class="badge bg-danger ms-2" style="font-size: 0.65rem; animation: pulse 2s infinite;">Stok Menipis</span>
                                    @endif
                                </div>
                                <small class="text-muted" style="font-size: 0.8rem;">{{ $item->satuan }}</small>
                            </td>
                            <td><span class="badge bg-secondary-subtle text-dark">{{ $item->category->nama_kategori }}</span></td>
                            <td>
                                <span class="text-dark">
                                    <i class="fa-solid fa-box text-muted me-1"></i> {{ $item->lokasi_rak ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $item->is_low_stock ? 'badge-low-stock' : 'bg-success' }} p-2 fs-7">
                                    {{ $item->stok }}
                                </span>
                            </td>
                            <td><span class="text-muted">{{ $item->stok_minimum }}</span></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('items.show', $item->id) }}" class="btn btn-sm btn-outline-info" title="Detail Barang">
                                        <i class="fa-regular fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Barang">
                                        <i class="fa-regular fa-pen-to-square"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini? Penghapusan akan gagal jika terdapat riwayat transaksi.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Barang">
                                            <i class="fa-regular fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-boxes-stacked fs-1 mb-3 d-block text-secondary"></i>
                            Tidak ada data barang ditemukan.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination links -->
    <div class="mt-4 d-flex justify-content-end">
        {{ $items->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
