<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsahaEsdmRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nama_pelaku_usaha' => ['required', 'string', 'max:255'],
            'nomor_identitas' => ['nullable', 'string', 'max:255'],
            'nomor_perizinan' => ['nullable', 'string', 'max:255'],
            'jenis_usaha' => ['required', 'string', 'max:255'],
            'komoditas' => ['nullable', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'koordinat' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:aktif,nonaktif,izin_habis'],
            'produksi' => ['nullable', 'numeric', 'min:0'],
            'penjualan' => ['nullable', 'numeric', 'min:0'],
        ];

        if ($this->isMethod('POST')) {
            $rules['dokumen'] = ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'];
            $rules['foto'] = ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'];
        } else {
            $rules['dokumen'] = ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'];
            $rules['foto'] = ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nama_pelaku_usaha.required' => 'Nama pelaku usaha wajib diisi.',
            'jenis_usaha.required' => 'Jenis usaha wajib diisi.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'produksi.numeric' => 'Produksi harus berupa angka.',
            'penjualan.numeric' => 'Penjualan harus berupa angka.',
            'dokumen.mimes' => 'Dokumen harus berupa file PDF, Word, atau Excel.',
            'dokumen.max' => 'Dokumen tidak boleh lebih dari 10 MB.',
            'foto.image' => 'Foto harus berupa file gambar.',
            'foto.mimes' => 'Foto harus berformat jpeg, png, atau jpg.',
            'foto.max' => 'Foto tidak boleh lebih dari 5 MB.',
        ];
    }
}
