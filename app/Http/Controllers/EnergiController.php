<?php

namespace App\Http\Controllers;

use App\Models\Energi;
use App\Http\Requests\EnergiRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EnergiController extends Controller
{
    public function index(): View
    {
        $energis = Energi::all();
        return view('energi.index', compact('energis'));
    }

    public function create(): View
    {
        return view('energi.create');
    }

    public function store(EnergiRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')->store('energi/dokumentasi', 'public');
        }

        Energi::create($data);

        return redirect()->route('energi.index')
            ->with('success', 'Data energi & ketenagalistrikan berhasil ditambahkan.');
    }

    public function edit(Energi $energi): View
    {
        return view('energi.edit', compact('energi'));
    }

    public function update(EnergiRequest $request, Energi $energi): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('dokumentasi')) {
            if ($energi->dokumentasi) {
                Storage::disk('public')->delete($energi->dokumentasi);
            }
            $data['dokumentasi'] = $request->file('dokumentasi')->store('energi/dokumentasi', 'public');
        }

        $energi->update($data);

        return redirect()->route('energi.index')
            ->with('success', 'Data energi & ketenagalistrikan berhasil diperbarui.');
    }

    public function destroy(Energi $energi): RedirectResponse
    {
        $energi->delete();

        return redirect()->route('energi.index')
            ->with('success', 'Data energi & ketenagalistrikan berhasil dihapus.');
    }
}
