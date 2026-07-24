<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kabupaten;
use App\Http\Requests\KecamatanRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KecamatanController extends Controller
{
    public function index(): View
    {
        $kecamatans = Kecamatan::with(['kabupaten'])->withCount('desas')->get();
        return view('kecamatan.index', compact('kecamatans'));
    }

    public function create(): View
    {
        $kabupatens = Kabupaten::all();
        return view('kecamatan.create', compact('kabupatens'));
    }

    public function store(KecamatanRequest $request): RedirectResponse
    {
        Kecamatan::create($request->validated());

        return redirect()->route('kecamatan.index')
            ->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function edit(Kecamatan $kecamatan): View
   {
        $kabupatens = Kabupaten::all();
        return view('kecamatan.edit', compact('kecamatan', 'kabupatens'));
    }

    public function update(KecamatanRequest $request, Kecamatan $kecamatan): RedirectResponse
    {
        $kecamatan->update($request->validated());

        return redirect()->route('kecamatan.index')
            ->with('success', 'Kecamatan berhasil diperbarui.');
    }

    public function destroy(Kecamatan $kecamatan): RedirectResponse
    {
        if ($kecamatan->desas()->count() > 0) {
            return redirect()->route('kecamatan.index')
                ->with('error', 'Kecamatan tidak bisa dihapus karena memiliki desa.');
        }

        $kecamatan->delete();

        return redirect()->route('kecamatan.index')
            ->with('success', 'Kecamatan berhasil dihapus.');
    }
}
