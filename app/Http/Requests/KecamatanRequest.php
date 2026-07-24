<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KecamatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kabupaten_id' => ['required', 'exists:kabupaten,id'],
            'nama' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'kabupaten_id.required' => 'Kabupaten wajib dipilih.',
            'kabupaten_id.exists' => 'Kabupaten tidak valid.',
            'nama.required' => 'Nama kecamatan wajib diisi.',
            'nama.string' => 'Nama kecamatan harus berupa teks.',
            'nama.max' => 'Nama kecamatan tidak boleh lebih dari 255 karakter.',
        ];
    }
}
