@extends('layouts.app')

@section('title', 'Edit Kategori - AgriStock')
@section('header_title', 'Edit Kategori')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <div class="mb-4">
                <a href="{{ route('categories.index') }}" class="btn btn-sm btn-light text-muted">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama Kategori -->
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label font-weight-bold">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" value="{{ old('nama_kategori', $category->nama_kategori) }}" placeholder="Contoh: Pupuk, Pestisida, Benih" required>
                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted">Nama kategori harus unik di sistem.</div>
                </div>

                <!-- Deskripsi Kategori -->
                <div class="mb-4">
                    <label for="deskripsi" class="form-label font-weight-bold">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Tulis penjelasan singkat tentang kategori barang ini...">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('categories.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-green">
                        <i class="fa-regular fa-floppy-disk me-2"></i> Perbarui Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
