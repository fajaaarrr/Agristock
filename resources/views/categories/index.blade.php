@extends('layouts.app')

@section('title', 'Kategori Barang - AgriStock')
@section('header_title', 'Kategori Barang')

@section('styles')
<style>
    @media (max-width: 576px) {
        .btn-action-text { display: none; }
        .cat-header { flex-direction: column !important; gap: 10px !important; }
        .cat-header .btn-green { width: 100%; text-align: center; }
        .cat-search-form { max-width: 100% !important; width: 100% !important; }
        .cat-search-form .input-group { flex-wrap: nowrap; }
        .cat-search-form .form-control { flex: 1; min-width: 0; }
        .cat-search-form .btn { flex-shrink: 0; }
    }
</style>
@endsection

@section('content')
<div class="card card-custom p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 cat-header">
        <!-- Search form -->
        <form action="{{ route('categories.index') }}" method="GET" class="d-flex flex-grow-1 cat-search-form" style="max-width: 400px;">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari nama kategori..." value="{{ $search }}">
                <button class="btn btn-green" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i> <span class="d-none d-sm-inline">Cari</span>
                </button>
                @if(!empty($search))
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center px-3">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>
        </form>

        <!-- Add Category button -->
        <a href="{{ route('categories.create') }}" class="btn btn-green">
            <i class="fa-solid fa-plus-circle me-2"></i> Tambah Kategori
        </a>
    </div>

    <!-- Categories Table -->
    <div class="table-responsive">
        <table class="table table-hover table-custom align-middle">
            <thead>
                <tr>
                    <th style="width: 80px;">No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th style="width: 200px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($categories->count() > 0)
                    @foreach($categories as $index => $category)
                        <tr>
                            <td>{{ $categories->firstItem() + $index }}</td>
                            <td><strong>{{ $category->nama_kategori }}</strong></td>
                            <td class="text-muted">{{ $category->deskripsi ?? 'Tidak ada deskripsi.' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Kategori">
                                        <i class="fa-regular fa-pen-to-square"></i> <span class="btn-action-text">Edit</span>
                                    </a>
                                    
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Penghapusan akan gagal jika terdapat barang dalam kategori ini.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Kategori">
                                            <i class="fa-regular fa-trash-can"></i> <span class="btn-action-text">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-tags fs-1 mb-3 d-block text-secondary"></i>
                            Tidak ada data kategori ditemukan.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination links -->
    <div class="mt-4 d-flex justify-content-end">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
