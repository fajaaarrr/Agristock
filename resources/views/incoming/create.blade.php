@extends('layouts.app')

@section('title', 'Catat Barang Masuk - AgriStock')
@section('header_title', 'Catat Barang Masuk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <div class="mb-4">
                <a href="{{ route('incoming-goods.index') }}" class="btn btn-sm btn-light text-muted">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <form action="{{ route('incoming-goods.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Nomor Transaksi -->
                    <div class="col-md-6 mb-3">
                        <label for="nomor_transaksi" class="form-label font-weight-bold">Nomor Transaksi <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_transaksi" id="nomor_transaksi" class="form-control @error('nomor_transaksi') is-invalid @enderror" value="{{ old('nomor_transaksi', $recommendedNo) }}" required>
                        @error('nomor_transaksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Format rekomendasi telah terisi otomatis.</div>
                    </div>

                    <!-- Tanggal Masuk -->
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_masuk" class="form-label font-weight-bold">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control @error('tanggal_masuk') is-invalid @enderror" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                        @error('tanggal_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Barang -->
                <div class="mb-3">
                    <label for="item_id" class="form-label font-weight-bold">Pilih Barang <span class="text-danger">*</span></label>
                    <select name="item_id" id="item_id" class="form-select @error('item_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->kode_barang }} - {{ $item->nama_barang }} (Stok saat ini: {{ $item->stok }} {{ $item->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('item_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Jumlah Masuk -->
                    <div class="col-md-6 mb-3">
                        <label for="jumlah" class="form-label font-weight-bold">Jumlah Masuk <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', 1) }}" min="1" required>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Persediaan barang akan bertambah secara otomatis sesuai jumlah ini.</div>
                    </div>

                    <!-- Supplier -->
                    <div class="col-md-6 mb-3">
                        <label for="supplier" class="form-label font-weight-bold">Supplier / Pemasok <span class="text-danger">*</span></label>
                        <input type="text" name="supplier" id="supplier" class="form-control @error('supplier') is-invalid @enderror" value="{{ old('supplier') }}" placeholder="Contoh: PT Pupuk Indonesia, Balih Pertanian" required>
                        @error('supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="mb-4">
                    <label for="keterangan" class="form-label font-weight-bold">Keterangan Tambahan</label>
                    <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Tuliskan keterangan pendukung transaksi (opsional)...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                    <a href="{{ route('incoming-goods.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-green">
                        <i class="fa-solid fa-arrow-down-long me-2"></i> Simpan Transaksi Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
