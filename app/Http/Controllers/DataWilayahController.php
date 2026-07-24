<?php

namespace App\Http\Controllers;

use App\Models\DataWilayah;
use App\Models\Desa;
use App\Http\Requests\DataWilayahRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DataWilayahController extends Controller
{
    public function index(): View
    {
        $wilayahs = DataWilayah::with(['desa.kecamatan.kabupaten'])->get();
        return view('wilayah.index', compact('wilayahs'));
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
