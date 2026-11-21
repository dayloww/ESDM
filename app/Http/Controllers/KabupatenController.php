<?php

namespace App\Http\Controllers;

use App\Http\Requests\KabupatenRequest;
use App\Models\Kabupaten;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KabupatenController extends Controller
{
    public function index(Request $request): View
    {
        $query = Kabupaten::withCount('kecamatans');

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%'.(string) $request->input('nama').'%');
        }

        $kabupatens = $query->orderBy('nama')->get();

        return view('kabupaten.index', compact('kabupatens'));
    }

    public function create(): View
    {
        return view('kabupaten.create');
    }

    public function store(KabupatenRequest $request): RedirectResponse
    {
        Kabupaten::create($request->validated());

        return redirect()->route('kabupaten.index')
            ->with('success', 'Kabupaten berhasil ditambahkan.');
    }

    public function edit(Kabupaten $kabupaten): View
    {
        return view('kabupaten.edit', compact('kabupaten'));
    }

    public function update(KabupatenRequest $request, Kabupaten $kabupaten): RedirectResponse
    {
        $kabupaten->update($request->validated());

        return redirect()->route('kabupaten.index')
            ->with('success', 'Kabupaten berhasil diperbarui.');
    }

    public function destroy(Kabupaten $kabupaten): RedirectResponse
    {
        if ($kabupaten->kecamatans()->count() > 0) {
            return redirect()->route('kabupaten.index')
                ->with('error', 'Kabupaten tidak bisa dihapus karena memiliki kecamatan.');
        }

        $kabupaten->delete();

        return redirect()->route('kabupaten.index')
            ->with('success', 'Kabupaten berhasil dihapus.');
    }
}
