<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnergiRequest;
use App\Models\Energi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class KetenagalistrikanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Energi::where('jenis_usaha', 'UPTL');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('bidang_kegiatan')) {
            $query->where('bidang_kegiatan', $request->input('bidang_kegiatan'));
        }

        $energis = $query->latest()->get();
        $statusOptions = [
            'aktif' => 'Aktif',
            'nonaktif' => 'Nonaktif',
            'habis' => 'Habis',
        ];
        $bidangOptions = Energi::where('jenis_usaha', 'UPTL')
            ->whereNotNull('bidang_kegiatan')
            ->distinct()
            ->orderBy('bidang_kegiatan')
            ->pluck('bidang_kegiatan', 'bidang_kegiatan')
            ->all();

        return view('ketenagalistrikan.index', compact('energis', 'statusOptions', 'bidangOptions'));
    }

    public function create(): View
    {
        return view('ketenagalistrikan.create');
    }

    public function store(EnergiRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['jenis_usaha'] = 'UPTL';

        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')->store('energi/dokumentasi', 'public');
        }

        Energi::create($data);

        return redirect()->route('ketenagalistrikan.index')
            ->with('success', 'Data ketenagalistrikan berhasil ditambahkan.');
    }

    public function show(Energi $energi): View
    {
        return view('ketenagalistrikan.show', compact('energi'));
    }

    public function edit(Energi $energi): View
    {
        return view('ketenagalistrikan.edit', compact('energi'));
    }

    public function update(EnergiRequest $request, Energi $energi): RedirectResponse
    {
        $data = $request->validated();
        $data['jenis_usaha'] = 'UPTL';

        if ($request->hasFile('dokumentasi')) {
            if ($energi->dokumentasi) {
                Storage::disk('public')->delete($energi->dokumentasi);
            }
            $data['dokumentasi'] = $request->file('dokumentasi')->store('energi/dokumentasi', 'public');
        }

        $energi->update($data);

        return redirect()->route('ketenagalistrikan.index')
            ->with('success', 'Data ketenagalistrikan berhasil diperbarui.');
    }

    public function destroy(Energi $energi): RedirectResponse
    {
        if ($energi->dokumentasi) {
            Storage::disk('public')->delete($energi->dokumentasi);
        }

        $energi->delete();

        return redirect()->route('ketenagalistrikan.index')
            ->with('success', 'Data ketenagalistrikan berhasil dihapus.');
    }
}
