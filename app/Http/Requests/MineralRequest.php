<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MineralRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lokasi' => ['required', 'string', 'max:255'],
            'jenis_komoditas' => ['required', 'string', 'max:255'],
            'pemegang_izin' => ['required', 'string', 'max:255'],
            'luas' => ['nullable', 'numeric', 'min:0'],
            'produksi' => ['nullable', 'numeric', 'min:0'],
            'dokumentasi' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpeg,png,jpg', 'max:10240'],
            'hasil_pemantauan' => ['nullable', 'string'],
            'tindak_lanjut' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'lokasi.required' => 'Lokasi wajib diisi.',
            'jenis_komoditas.required' => 'Jenis komoditas wajib diisi.',
            'pemegang_izin.required' => 'Pemegang izin wajib diisi.',
            'luas.numeric' => 'Luas harus berupa angka.',
            'produksi.numeric' => 'Produksi harus berupa angka.',
            'dokumentasi.max' => 'Dokumentasi tidak boleh lebih dari 10 MB.',
        ];
    }
}
