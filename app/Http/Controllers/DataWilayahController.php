<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataWilayahRequest;
use App\Models\DataWilayah;
use App\Models\Desa;
use App\Models\Kabupaten;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DataWilayahController extends Controller
{
    public function index(Request $request): View
    {
        $query = DataWilayah::with(['desa.kecamatan.kabupaten']);

        if ($request->filled('status_berlistrik')) {
            $query->where('status_berlistrik', $request->input('status_berlistrik'));
        }

        if ($request->filled('kabupaten_id')) {
            $query->whereHas(
                'desa.kecamatan.kabupaten',
                fn ($q) => $q->where('kabupaten.id', $request->input('kabupaten_id'))
            );
        }

        $wilayahs = $query->latest()->get();
        $kabupatenOptions = Kabupaten::orderBy('nama')->pluck('nama', 'id')->all();

        return view('wilayah.index', compact('wilayahs', 'kabupatenOptions'));
    }

    public function create(): View
    {
        $desas = Desa::with('kecamatan.kabupaten')->get();

        return view('wilayah.create', compact('desas'));
    }

    public function store(DataWilayahRequest $request): RedirectResponse
    {
        DataWilayah::create($request->validated());

        return redirect()->route('wilayah.index')
            ->with('success', 'Data wilayah berhasil ditambahkan.');
    }

    public function edit(DataWilayah $wilayah): View
    {
        $desas = Desa::with('kecamatan.kabupaten')->get();

        return view('wilayah.edit', compact('wilayah', 'desas'));
    }

    public function update(DataWilayahRequest $request, DataWilayah $wilayah): RedirectResponse
    {
        $wilayah->update($request->validated());

        return redirect()->route('wilayah.index')
            ->with('success', 'Data wilayah berhasil diperbarui.');
    }

    public function destroy(DataWilayah $wilayah): RedirectResponse
    {
        $wilayah->delete();

        return redirect()->route('wilayah.index')
            ->with('success', 'Data wilayah berhasil dihapus.');
    }
}
