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
        $jenis = $this->input('jenis_usaha');

        // ── Rules umum (berlaku untuk semua jenis usaha) ──────────────────
        $rules = [
            'jenis_usaha'  => ['required', 'string', 'in:IUPTLS,UPTL,Lainnya'],
            'desa'         => ['required', 'string', 'max:255'],
            'sumber_energi'=> ['nullable', 'string', 'max:255'],
            'kapasitas'    => ['nullable', 'string', 'max:255'],
            'jaringan'     => ['nullable', 'string', 'max:255'],
            'potensi_ebt'  => ['nullable', 'string'],
            'kondisi_infrastruktur' => ['nullable', 'string'],
            'permasalahan' => ['nullable', 'string'],
            'dokumentasi'  => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpeg,png,jpg', 'max:10240'],
        ];

        // ── Rules IUPTLS ──────────────────────────────────────────────────
        if ($jenis === 'IUPTLS') {
            $rules = array_merge($rules, [
                'nomor_izin'        => ['nullable', 'string', 'max:255'],
                'nama_pemegang_izin'=> ['required', 'string', 'max:255'],
                'nib'               => ['nullable', 'string', 'max:255'],
                'badan_usaha'       => ['nullable', 'string', 'max:255'],
                'jenis_pembangkit'  => ['nullable', 'string', 'max:255'],
                'sumber_energi'     => ['required', 'string', 'max:255'],
                'kapasitas'         => ['nullable', 'string', 'max:255'],
                'jumlah_unit'       => ['nullable', 'string', 'max:255'],
                'jaringan'          => ['nullable', 'string', 'max:255'],
                'latitude'          => ['nullable', 'string', 'max:100'],
                'longitude'         => ['nullable', 'string', 'max:100'],
                'tanggal_terbit'    => ['nullable', 'date'],
                'masa_berlaku'      => ['nullable', 'date'],
                'status'            => ['nullable', 'string', 'in:aktif,nonaktif,habis'],
                'potensi_ebt'       => ['nullable', 'string'],
                'permasalahan'      => ['nullable', 'string'],
                'keterangan'        => ['nullable', 'string'],
            ]);
        }

        // ── Rules UPTL ────────────────────────────────────────────────────
        if ($jenis === 'UPTL') {
            $rules = array_merge($rules, [
                'nomor_izin'          => ['nullable', 'string', 'max:255'],
                'nama_badan_usaha'    => ['required', 'string', 'max:255'],
                'nib'                 => ['nullable', 'string', 'max:255'],
                'penanggung_jawab'    => ['nullable', 'string', 'max:255'],
                'jenis_usaha_penunjang' => ['nullable', 'string', 'max:255'],
                'bidang_kegiatan'     => ['nullable', 'string', 'max:255'],
                'klasifikasi_usaha'   => ['nullable', 'string', 'max:255'],
                'latitude'            => ['nullable', 'string', 'max:100'],
                'longitude'           => ['nullable', 'string', 'max:100'],
                'tanggal_terbit'      => ['nullable', 'date'],
                'masa_berlaku'        => ['nullable', 'date'],
                'status'              => ['nullable', 'string', 'in:aktif,nonaktif,habis'],
                'keterangan'          => ['nullable', 'string'],
            ]);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'jenis_usaha.required'         => 'Jenis usaha wajib dipilih.',
            'jenis_usaha.in'               => 'Jenis usaha tidak valid.',
            'desa.required'                => 'Desa / lokasi wajib diisi.',
            'nama_pemegang_izin.required'  => 'Nama pemegang izin wajib diisi.',
            'nama_badan_usaha.required'    => 'Nama badan usaha wajib diisi.',
            'sumber_energi.required'       => 'Sumber energi wajib diisi.',
            'dokumentasi.max'              => 'Dokumentasi tidak boleh lebih dari 10 MB.',
            'dokumentasi.mimes'            => 'Format file tidak didukung.',
            'tanggal_terbit.date'          => 'Format tanggal terbit tidak valid.',
            'masa_berlaku.date'            => 'Format masa berlaku tidak valid.',
            'status.in'                    => 'Status tidak valid.',
        ];
    }
}
