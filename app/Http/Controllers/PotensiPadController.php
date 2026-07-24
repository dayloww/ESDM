<?php

namespace App\Http\Controllers;

use App\Models\PotensiPad;
use App\Http\Requests\PotensiPadRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PotensiPadController extends Controller
{
    public function index(): View
    {
        $pads = PotensiPad::all();
        return view('pad.index', compact('pads'));
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
