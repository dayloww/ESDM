<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PotensiPadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenis_kegiatan' => ['required', 'string', 'max:255'],
            'komoditas' => ['nullable', 'string', 'max:255'],
            'volume' => ['nullable', 'numeric', 'min:0'],
            'satuan' => ['nullable', 'string', 'max:255'],
            'periode' => ['nullable', 'string', 'max:255'],
            'nilai_produksi' => ['nullable', 'numeric', 'min:0'],
            'pelaku_usaha' => ['nullable', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'estimasi_penerimaan' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_kegiatan.required' => 'Jenis kegiatan wajib diisi.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'volume.numeric' => 'Volume harus berupa angka.',
            'nilai_produksi.numeric' => 'Nilai produksi harus berupa angka.',
            'estimasi_penerimaan.numeric' => 'Estimasi penerimaan harus berupa angka.',
        ];
    }
}
