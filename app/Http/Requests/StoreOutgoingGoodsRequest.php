<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOutgoingGoodsRequest extends FormRequest
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
            'nomor_transaksi' => 'required|string|max:255|unique:outgoing_goods,nomor_transaksi',
            'item_id' => 'required|exists:items,id',
            'tanggal_keluar' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'tujuan_penggunaan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'nomor_transaksi.required' => 'Nomor transaksi wajib diisi.',
            'nomor_transaksi.unique' => 'Nomor transaksi sudah digunakan.',
            'item_id.required' => 'Barang wajib dipilih.',
            'item_id.exists' => 'Barang yang dipilih tidak terdaftar.',
            'tanggal_keluar.required' => 'Tanggal keluar wajib diisi.',
            'tanggal_keluar.date' => 'Format tanggal keluar tidak valid.',
            'jumlah.required' => 'Jumlah barang keluar wajib diisi.',
            'jumlah.integer' => 'Jumlah barang keluar harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah barang keluar minimal 1.',
            'tujuan_penggunaan.required' => 'Tujuan penggunaan wajib diisi.',
        ];
    }
}
