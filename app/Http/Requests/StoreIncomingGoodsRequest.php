<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomingGoodsRequest extends FormRequest
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
            'nomor_transaksi' => 'required|string|max:255|unique:incoming_goods,nomor_transaksi',
            'item_id' => 'required|exists:items,id',
            'tanggal_masuk' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'supplier' => 'required|string|max:255',
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
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'tanggal_masuk.date' => 'Format tanggal masuk tidak valid.',
            'jumlah.required' => 'Jumlah barang masuk wajib diisi.',
            'jumlah.integer' => 'Jumlah barang masuk harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah barang masuk minimal 1.',
            'supplier.required' => 'Nama supplier wajib diisi.',
        ];
    }
}
