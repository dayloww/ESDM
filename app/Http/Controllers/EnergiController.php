<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnergiRequest;
use App\Models\Energi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EnergiController extends Controller
{
    public function index(Request $request): View
    {
        $query = Energi::where(function ($q) {
            $q->where('jenis_usaha', '!=', 'UPTL')->orWhereNull('jenis_usaha');
        });

        if ($request->filled('sumber_energi')) {
            $query->where('sumber_energi', $request->input('sumber_energi'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $energis = $query->latest()->get();
        $sumberEnergiOptions = Energi::query()
            ->whereNotNull('sumber_energi')
            ->distinct()
            ->orderBy('sumber_energi')
            ->pluck('sumber_energi', 'sumber_energi')
            ->all();
        $statusOptions = [
            'aktif' => 'Aktif',
            'nonaktif' => 'Nonaktif',
            'habis' => 'Habis',
        ];

        return view('energi.index', compact('energis', 'sumberEnergiOptions', 'statusOptions'));
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

    public function show(Energi $energi): View
    {
        return view('energi.show', compact('energi'));
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
        if ($energi->dokumentasi) {
            Storage::disk('public')->delete($energi->dokumentasi);
        }

        $energi->delete();

        return redirect()->route('energi.index')
            ->with('success', 'Data energi & ketenagalistrikan berhasil dihapus.');
    }
}
