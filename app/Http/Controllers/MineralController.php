<?php

namespace App\Http\Controllers;

use App\Models\Mineral;
use App\Http\Requests\MineralRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MineralController extends Controller
{
    public function index(): View
    {
        $minerals = Mineral::all();
        return view('mineral.index', compact('minerals'));
    }

    public function create(): View
    {
        return view('mineral.create');
    }

    public function store(MineralRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')->store('mineral/dokumentasi', 'public');
        }

        Mineral::create($data);

        return redirect()->route('mineral.index')
            ->with('success', 'Data mineral & pertambangan berhasil ditambahkan.');
    }

    public function edit(Mineral $mineral): View
    {
        return view('mineral.edit', compact('mineral'));
    }

    public function update(MineralRequest $request, Mineral $mineral): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('dokumentasi')) {
            if ($mineral->dokumentasi) {
                Storage::disk('public')->delete($mineral->dokumentasi);
            }
            $data['dokumentasi'] = $request->file('dokumentasi')->store('mineral/dokumentasi', 'public');
        }

        $mineral->update($data);

        return redirect()->route('mineral.index')
            ->with('success', 'Data mineral & pertambangan berhasil diperbarui.');
    }

    public function destroy(Mineral $mineral): RedirectResponse
    {
        $mineral->delete();

        return redirect()->route('mineral.index')
            ->with('success', 'Data mineral & pertambangan berhasil dihapus.');
    }
}
