<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KabupatenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama kabupaten wajib diisi.',
            'nama.string' => 'Nama kabupaten harus berupa teks.',
            'nama.max' => 'Nama kabupaten tidak boleh lebih dari 255 karakter.',
        ];
    }
}
