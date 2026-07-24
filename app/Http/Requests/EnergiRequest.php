<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnergiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'desa' => ['required', 'string', 'max:255'],
            'sumber_energi' => ['required', 'string', 'max:255'],
            'kapasitas' => ['nullable', 'string', 'max:255'],
            'jaringan' => ['nullable', 'string', 'max:255'],
            'potensi_ebt' => ['nullable', 'string'],
            'kondisi_infrastruktur' => ['nullable', 'string'],
            'permasalahan' => ['nullable', 'string'],
            'dokumentasi' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpeg,png,jpg', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'desa.required' => 'Desa wajib diisi.',
            'sumber_energi.required' => 'Sumber energi wajib diisi.',
            'dokumentasi.max' => 'Dokumentasi tidak boleh lebih dari 10 MB.',
        ];
    }
}
