<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Http\Requests\KabupatenRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KabupatenController extends Controller
{
    public function index(): View
    {
        $kabupatens = Kabupaten::withCount('kecamatans')->get();
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
