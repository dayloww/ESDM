<?php

namespace App\Http\Controllers;

use App\Http\Requests\KecamatanRequest;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KecamatanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Kecamatan::with(['kabupaten'])->withCount('desas');

        if ($request->filled('kabupaten_id')) {
            $query->where('kabupaten_id', $request->input('kabupaten_id'));
        }

        $kecamatans = $query->orderBy('nama')->get();
        $kabupatenOptions = Kabupaten::orderBy('nama')->pluck('nama', 'id')->all();

        return view('kecamatan.index', compact('kecamatans', 'kabupatenOptions'));
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
