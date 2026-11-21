<?php

namespace App\Http\Controllers;

use App\Http\Requests\DesaRequest;
use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DesaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Desa::with(['kecamatan.kabupaten'])->withCount('dataWilayahs');

        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->input('kecamatan_id'));
        }

        $desas = $query->orderBy('nama')->get();
        $kecamatanOptions = Kecamatan::with('kabupaten')
            ->orderBy('nama')
            ->get()
            ->mapWithKeys(fn (Kecamatan $kecamatan) => [
                $kecamatan->id => $kecamatan->kabupaten?->nama.' - '.$kecamatan->nama,
            ])
            ->all();

        return view('desa.index', compact('desas', 'kecamatanOptions'));
    }

    public function create(): View
    {
        $kecamatans = Kecamatan::with('kabupaten')->get();

        return view('desa.create', compact('kecamatans'));
    }

    public function store(DesaRequest $request): RedirectResponse
    {
        Desa::create($request->validated());

        return redirect()->route('desa.index')
            ->with('success', 'Desa berhasil ditambahkan.');
    }

    public function edit(Desa $desa): View
    {
        $kecamatans = Kecamatan::with('kabupaten')->get();

        return view('desa.edit', compact('desa', 'kecamatans'));
    }

    public function update(DesaRequest $request, Desa $desa): RedirectResponse
    {
        $desa->update($request->validated());

        return redirect()->route('desa.index')
            ->with('success', 'Desa berhasil diperbarui.');
    }

    public function destroy(Desa $desa): RedirectResponse
    {
        if ($desa->dataWilayahs()->count() > 0) {
            return redirect()->route('desa.index')
                ->with('error', 'Desa tidak bisa dihapus karena memiliki data wilayah terkait.');
        }

        $desa->delete();

        return redirect()->route('desa.index')
            ->with('success', 'Desa berhasil dihapus.');
    }
}
