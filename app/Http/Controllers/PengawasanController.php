<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengawasanRequest;
use App\Models\Pengawasan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengawasanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pengawasan::query();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->input('tanggal_dari'));
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->input('tanggal_sampai'));
        }

        $pengawasans = $query->latest('tanggal')->get();
        $statusOptions = [
            'selesai' => 'Selesai',
            'dalam_proses' => 'Dalam Proses',
            'tertunda' => 'Tertunda',
        ];

        return view('pengawasan.index', compact('pengawasans', 'statusOptions'));
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
