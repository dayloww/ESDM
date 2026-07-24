<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsahaEsdm;
use App\Models\Mineral;
use App\Models\Energi;
use App\Models\Pengawasan;
use App\Models\PotensiPad;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $tipe = $request->get('tipe', 'usaha');
        $data = collect();

        switch ($tipe) {
            case 'usaha':
                $query = UsahaEsdm::query();
                if ($request->filled('status')) {
                    $query->where('status', $request->get('status'));
                }
                $data = $query->get();
                break;
            case 'mineral':
                $query = Mineral::query();
                if ($request->filled('komoditas')) {
                    $query->where('jenis_komoditas', 'like', '%' . $request->get('komoditas') . '%');
                }
                $data = $query->get();
                break;
            case 'energi':
                $query = Energi::query();
                if ($request->filled('sumber')) {
                    $query->where('sumber_energi', 'like', '%' . $request->get('sumber') . '%');
                }
                $data = $query->get();
                break;
            case 'pengawasan':
                $query = Pengawasan::query();
                if ($request->filled('status')) {
                    $query->where('status', $request->get('status'));
                }
                $data = $query->get();
                break;
            case 'pad':
                $query = PotensiPad::query();
                if ($request->filled('kegiatan')) {
                    $query->where('jenis_kegiatan', 'like', '%' . $request->get('kegiatan') . '%');
                }
                $data = $query->get();
                break;
        }

        return view('laporan.index', compact('tipe', 'data'));
    }
}
