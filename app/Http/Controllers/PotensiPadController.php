<?php

namespace App\Http\Controllers;

use App\Http\Requests\PotensiPadRequest;
use App\Models\PotensiPad;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PotensiPadController extends Controller
{
    public function index(Request $request): View
    {
        $query = PotensiPad::query();

        if ($request->filled('jenis_kegiatan')) {
            $query->where('jenis_kegiatan', $request->input('jenis_kegiatan'));
        }

        if ($request->filled('periode')) {
            $query->where('periode', 'like', '%'.(string) $request->input('periode').'%');
        }

        $pads = $query->latest()->get();
        $jenisKegiatanOptions = PotensiPad::query()
            ->whereNotNull('jenis_kegiatan')
            ->distinct()
            ->orderBy('jenis_kegiatan')
            ->pluck('jenis_kegiatan', 'jenis_kegiatan')
            ->all();

        return view('pad.index', compact('pads', 'jenisKegiatanOptions'));
    }

    public function create(): View
    {
        return view('pad.create');
    }

    public function store(PotensiPadRequest $request): RedirectResponse
    {
        PotensiPad::create($request->validated());

        return redirect()->route('pad.index')
            ->with('success', 'Data potensi PAD berhasil ditambahkan.');
    }

    public function edit(PotensiPad $pad): View
    {
        return view('pad.edit', compact('pad'));
    }

    public function update(PotensiPadRequest $request, PotensiPad $pad): RedirectResponse
    {
        $pad->update($request->validated());

        return redirect()->route('pad.index')
            ->with('success', 'Data potensi PAD berhasil diperbarui.');
    }

    public function destroy(PotensiPad $pad): RedirectResponse
    {
        $pad->delete();

        return redirect()->route('pad.index')
            ->with('success', 'Data potensi PAD berhasil dihapus.');
    }
}
