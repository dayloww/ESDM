<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataWilayahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'desa_id' => ['required', 'exists:desa,id'],
            'koordinat' => ['nullable', 'string', 'max:255'],
            'jumlah_penduduk' => ['nullable', 'integer', 'min:0'],
            'kondisi_ketenagalistrikan' => ['nullable', 'string', 'max:255'],
            'status_berlistrik' => ['required', 'in:berlistrik,belum_berlistrik,sebagian'],
            'potensi_energi' => ['nullable', 'string'],
            'potensi_sumber_daya_mineral' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'desa_id.required' => 'Desa wajib dipilih.',
            'desa_id.exists' => 'Desa tidak valid.',
            'status_berlistrik.required' => 'Status berlistrik wajib dipilih.',
            'status_berlistrik.in' => 'Status berlistrik tidak valid.',
            'jumlah_penduduk.integer' => 'Jumlah penduduk harus berupa angka.',
            'jumlah_penduduk.min' => 'Jumlah penduduk tidak boleh kurang dari 0.',
        ];
    }
}
