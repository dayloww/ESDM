<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengawasanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal' => ['required', 'date'],
            'petugas' => ['required', 'string', 'max:255'],
            'objek' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'hasil' => ['nullable', 'string'],
            'temuan' => ['nullable', 'string'],
            'rekomendasi' => ['nullable', 'string'],
            'dokumentasi' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpeg,png,jpg', 'max:10240'],
            'tindak_lanjut' => ['nullable', 'string'],
            'status' => ['required', 'in:selesai,dalam_proses,tertunda'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal pengawasan wajib diisi.',
            'petugas.required' => 'Nama petugas wajib diisi.',
            'objek.required' => 'Objek pengawasan wajib diisi.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'dokumentasi.max' => 'Dokumentasi tidak boleh lebih dari 10 MB.',
        ];
    }
}
