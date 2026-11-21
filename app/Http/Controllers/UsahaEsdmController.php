<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsahaEsdmRequest;
use App\Models\UsahaEsdm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UsahaEsdmController extends Controller
{
    public function index(Request $request): View
    {
        $query = UsahaEsdm::query();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('jenis_usaha')) {
            $query->where('jenis_usaha', $request->input('jenis_usaha'));
        }

        $usahas = $query->latest()->get();
        $statusOptions = [
            'aktif' => 'Aktif',
            'nonaktif' => 'Nonaktif',
            'izin_habis' => 'Izin Habis',
        ];
        $jenisUsahaOptions = UsahaEsdm::query()
            ->whereNotNull('jenis_usaha')
            ->distinct()
            ->orderBy('jenis_usaha')
            ->pluck('jenis_usaha', 'jenis_usaha')
            ->all();

        return view('usaha.index', compact('usahas', 'statusOptions', 'jenisUsahaOptions'));
    }

    public function create(): View
    {
        return view('usaha.create');
    }

    public function store(UsahaEsdmRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('dokumen')) {
            $data['dokumen'] = $request->file('dokumen')->store('usaha/dokumen', 'public');
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('usaha/foto', 'public');
        }

        UsahaEsdm::create($data);

        return redirect()->route('usaha.index')
            ->with('success', 'Data usaha ESDM berhasil ditambahkan.');
    }

    public function edit(UsahaEsdm $usaha): View
    {
        return view('usaha.edit', compact('usaha'));
    }

    public function update(UsahaEsdmRequest $request, UsahaEsdm $usaha): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('dokumen')) {
            if ($usaha->dokumen) {
                Storage::disk('public')->delete($usaha->dokumen);
            }
            $data['dokumen'] = $request->file('dokumen')->store('usaha/dokumen', 'public');
        }

        if ($request->hasFile('foto')) {
            if ($usaha->foto) {
                Storage::disk('public')->delete($usaha->foto);
            }
            $data['foto'] = $request->file('foto')->store('usaha/foto', 'public');
        }

        $usaha->update($data);

        return redirect()->route('usaha.index')
            ->with('success', 'Data usaha ESDM berhasil diperbarui.');
    }

    public function destroy(UsahaEsdm $usaha): RedirectResponse
    {
        // Keep files in storage during soft delete, or we can choose to delete. Typically we keep for soft delete.
        $usaha->delete();

        return redirect()->route('usaha.index')
            ->with('success', 'Data usaha ESDM berhasil dihapus.');
    }
}
