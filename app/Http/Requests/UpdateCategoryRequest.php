<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
        $category = $this->route('category');

        return [
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'nama_kategori')->ignore($category),
            ],
            'deskripsi' => 'nullable|string',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah digunakan.',
        ];
    }
}
