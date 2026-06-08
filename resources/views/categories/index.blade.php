@extends('layouts.app')

@section('title', 'Kategori Barang - AgriStock')
@section('header_title', 'Kategori Barang')

@section('content')
<div class="card card-custom p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <!-- Search form -->
        <form action="{{ route('categories.index') }}" method="GET" class="d-flex flex-grow-1 max-width-md" style="max-width: 400px;">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari nama kategori..." value="{{ $search }}">
                <button class="btn btn-green" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari
                </button>
                @if(!empty($search))
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
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
                                        <i class="fa-regular fa-pen-to-square"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Penghapusan akan gagal jika terdapat barang dalam kategori ini.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Kategori">
                                            <i class="fa-regular fa-trash-can"></i> Hapus
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
