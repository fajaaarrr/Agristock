@extends('layouts.app')

@section('title', 'Catat Barang Keluar - AgriStock')
@section('header_title', 'Catat Barang Keluar')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <div class="mb-4">
                <a href="{{ route('outgoing-goods.index') }}" class="btn btn-sm btn-light text-muted">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <form action="{{ route('outgoing-goods.store') }}" method="POST" id="outgoingForm">
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

                    <!-- Tanggal Keluar -->
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_keluar" class="form-label font-weight-bold">Tanggal Keluar <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control @error('tanggal_keluar') is-invalid @enderror" value="{{ old('tanggal_keluar', date('Y-m-d')) }}" required>
                        @error('tanggal_keluar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Barang Select -->
                <div class="mb-3">
                    <label for="item_id" class="form-label font-weight-bold">Pilih Barang <span class="text-danger">*</span></label>
                    <select name="item_id" id="item_id" class="form-select @error('item_id') is-invalid @enderror" required onchange="updateMaxStock()">
                        <option value="" data-stock="0">-- Pilih Barang --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" data-stock="{{ $item->stok }}" data-unit="{{ $item->satuan }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->kode_barang }} - {{ $item->nama_barang }} (Stok tersedia: {{ $item->stok }} {{ $item->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('item_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Jumlah Keluar -->
                    <div class="col-md-6 mb-3">
                        <label for="jumlah" class="form-label font-weight-bold">Jumlah Keluar <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', 1) }}" min="1" required>
                            <span class="input-group-text bg-light text-muted" id="unitSpan">satuan</span>
                        </div>
                        @error('jumlah')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-danger" id="stockWarning" style="display: none;">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> Jumlah melebihi stok yang tersedia!
                        </div>
                    </div>

                    <!-- Tujuan Penggunaan -->
                    <div class="col-md-6 mb-3">
                        <label for="tujuan_penggunaan" class="form-label font-weight-bold">Tujuan Penggunaan <span class="text-danger">*</span></label>
                        <input type="text" name="tujuan_penggunaan" id="tujuan_penggunaan" class="form-control @error('tujuan_penggunaan') is-invalid @enderror" value="{{ old('tujuan_penggunaan') }}" placeholder="Contoh: Didistribusikan ke Kelompok Tani, Pemakaian Lahan" required>
                        @error('tujuan_penggunaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="mb-4">
                    <label for="keterangan" class="form-label font-weight-bold">Keterangan Tambahan</label>
                    <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Tuliskan keterangan pendukung transaksi keluar (opsional)...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('outgoing-goods.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-green" id="submitBtn">
                        <i class="fa-solid fa-arrow-up-long me-2"></i> Simpan Transaksi Keluar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateMaxStock() {
        const select = document.getElementById('item_id');
        const selectedOption = select.options[select.selectedIndex];
        const stock = parseInt(selectedOption.getAttribute('data-stock') || 0);
        const unit = selectedOption.getAttribute('data-unit') || 'satuan';
        
        document.getElementById('unitSpan').textContent = unit;
        
        const qtyInput = document.getElementById('jumlah');
        qtyInput.setAttribute('max', stock);
        
        checkStockLimit();
    }

    function checkStockLimit() {
        const select = document.getElementById('item_id');
        const selectedOption = select.options[select.selectedIndex];
        const stock = parseInt(selectedOption.getAttribute('data-stock') || 0);
        
        const qtyInput = document.getElementById('jumlah');
        const val = parseInt(qtyInput.value || 0);
        
        const warning = document.getElementById('stockWarning');
        const submitBtn = document.getElementById('submitBtn');
        
        if (select.value && val > stock) {
            warning.style.display = 'block';
            submitBtn.disabled = true;
        } else {
            warning.style.display = 'none';
            submitBtn.disabled = false;
        }
    }

    document.getElementById('jumlah').addEventListener('input', checkStockLimit);
    
    // Run initial configuration on load
    window.addEventListener('DOMContentLoaded', updateMaxStock);
</script>
@endsection
