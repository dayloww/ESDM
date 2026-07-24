<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kecamatan_id' => ['required', 'exists:kecamatan,id'],
            'nama' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'kecamatan_id.required' => 'Kecamatan wajib dipilih.',
            'kecamatan_id.exists' => 'Kecamatan tidak valid.',
            'nama.required' => 'Nama desa wajib diisi.',
            'nama.string' => 'Nama desa harus berupa teks.',
            'nama.max' => 'Nama desa tidak boleh lebih dari 255 karakter.',
        ];
    }
}
