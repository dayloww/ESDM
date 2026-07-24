<?php

namespace App\Http\Controllers;

use App\Models\Pengawasan;
use App\Http\Requests\PengawasanRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengawasanController extends Controller
{
    public function index(): View
    {
        $pengawasans = Pengawasan::all();
        return view('pengawasan.index', compact('pengawasans'));
    }

    public function create(): View
    {
        return view('pengawasan.create');
    }

    public function store(PengawasanRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')->store('pengawasan/dokumentasi', 'public');
        }

        Pengawasan::create($data);

        return redirect()->route('pengawasan.index')
            ->with('success', 'Data pengawasan berhasil ditambahkan.');
    }

    public function edit(Pengawasan $pengawasan): View
    {
        return view('pengawasan.edit', compact('pengawasan'));
    }

    public function update(PengawasanRequest $request, Pengawasan $pengawasan): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('dokumentasi')) {
            if ($pengawasan->dokumentasi) {
                Storage::disk('public')->delete($pengawasan->dokumentasi);
            }
            $data['dokumentasi'] = $request->file('dokumentasi')->store('pengawasan/dokumentasi', 'public');
        }

        $pengawasan->update($data);

        return redirect()->route('pengawasan.index')
            ->with('success', 'Data pengawasan berhasil diperbarui.');
    }

    public function destroy(Pengawasan $pengawasan): RedirectResponse
    {
        $pengawasan->delete();

        return redirect()->route('pengawasan.index')
            ->with('success', 'Data pengawasan berhasil dihapus.');
    }
}
