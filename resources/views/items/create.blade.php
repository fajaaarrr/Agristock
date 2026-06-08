@extends('layouts.app')

@section('title', 'Tambah Barang - AgriStock')
@section('header_title', 'Tambah Barang Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card card-custom p-4">
            <div class="mb-4">
                <a href="{{ route('items.index') }}" class="btn btn-sm btn-light text-muted">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <form action="{{ route('items.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Kode Barang -->
                    <div class="col-md-6 mb-3">
                        <label for="kode_barang" class="form-label font-weight-bold">Kode Barang <span class="text-danger">*</span></label>
                        <input type="text" name="kode_barang" id="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror" value="{{ old('kode_barang') }}" placeholder="Contoh: BRG-PUP-001" required autofocus>
                        @error('kode_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Kode barang bersifat unik sebagai pengidentifikasi utama.</div>
                    </div>

                    <!-- Nama Barang -->
                    <div class="col-md-6 mb-3">
                        <label for="nama_barang" class="form-label font-weight-bold">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ old('nama_barang') }}" placeholder="Contoh: Pupuk Urea Kaltim" required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Kategori -->
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label font-weight-bold">Kategori Barang <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Satuan -->
                    <div class="col-md-6 mb-3">
                        <label for="satuan" class="form-label font-weight-bold">Satuan <span class="text-danger">*</span></label>
                        <input type="text" name="satuan" id="satuan" class="form-control @error('satuan') is-invalid @enderror" value="{{ old('satuan') }}" placeholder="Contoh: Bag (50kg), Kg, Liter, Pcs, Unit" required>
                        @error('satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Stok Awal -->
                    <div class="col-md-4 mb-3">
                        <label for="stok" class="form-label font-weight-bold">Stok Awal <span class="text-danger">*</span></label>
                        <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', 0) }}" min="0" required>
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Jumlah persediaan fisik saat ini.</div>
                    </div>

                    <!-- Stok Minimum -->
                    <div class="col-md-4 mb-3">
                        <label for="stok_minimum" class="form-label font-weight-bold">Stok Minimum <span class="text-danger">*</span></label>
                        <input type="number" name="stok_minimum" id="stok_minimum" class="form-control @error('stok_minimum') is-invalid @enderror" value="{{ old('stok_minimum', 10) }}" min="0" required>
                        @error('stok_minimum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Batas peringatan untuk restock barang.</div>
                    </div>

                    <!-- Lokasi Rak -->
                    <div class="col-md-4 mb-3">
                        <label for="lokasi_rak" class="form-label font-weight-bold">Lokasi Rak / Gudang</label>
                        <input type="text" name="lokasi_rak" id="lokasi_rak" class="form-control @error('lokasi_rak') is-invalid @enderror" value="{{ old('lokasi_rak') }}" placeholder="Contoh: Rak A-1, Gudang Utama">
                        @error('lokasi_rak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi Barang -->
                <div class="mb-4">
                    <label for="deskripsi" class="form-label font-weight-bold">Deskripsi Barang</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Tuliskan spesifikasi, deskripsi, atau keterangan tambahan tentang barang ini...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('items.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-green">
                        <i class="fa-regular fa-floppy-disk me-2"></i> Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
