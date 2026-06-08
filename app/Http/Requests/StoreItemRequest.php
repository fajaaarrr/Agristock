<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'kode_barang' => 'required|string|max:255|unique:items,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'satuan' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'lokasi_rak' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'kode_barang.unique' => 'Kode barang sudah terdaftar di sistem.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'category_id.required' => 'Kategori barang wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'satuan.required' => 'Satuan barang wajib diisi.',
            'stok.required' => 'Jumlah stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh bernilai negatif.',
            'stok_minimum.required' => 'Stok minimum wajib diisi.',
            'stok_minimum.integer' => 'Stok minimum harus berupa angka bulat.',
            'stok_minimum.min' => 'Stok minimum tidak boleh bernilai negatif.',
        ];
    }
}
