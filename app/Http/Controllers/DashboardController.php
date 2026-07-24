<?php

namespace App\Http\Controllers;

use App\Models\DataWilayah;
use App\Models\UsahaEsdm;
use App\Models\Mineral;
use App\Models\Energi;
use App\Models\Pengawasan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard.
     */
    public function index(): View
    {
        $stats = [
            'wilayah'    => DataWilayah::count(),
            'usaha'      => UsahaEsdm::count(),
            'mineral'    => Mineral::count(),
            'energi'     => Energi::count(),
            'pengawasan' => Pengawasan::count(),
        ];

        // Hitung distribusi data per kabupaten
        // Sangihe
        $sangiheUsaha = UsahaEsdm::where('lokasi', 'like', '%Sangihe%')->count();
        $sangiheMineral = Mineral::where('lokasi', 'like', '%Sangihe%')->count();
        $sangiheEnergi = Energi::where('desa', 'like', '%Sangihe%')->count();
        $sangihePengawasan = Pengawasan::where('lokasi', 'like', '%Sangihe%')->count();

        // Talaud
        $talaudUsaha = UsahaEsdm::where('lokasi', 'like', '%Talaud%')->count();
        $talaudMineral = Mineral::where('lokasi', 'like', '%Talaud%')->count();
        $talaudEnergi = Energi::where('desa', 'like', '%Talaud%')->count();
        $talaudPengawasan = Pengawasan::where('lokasi', 'like', '%Talaud%')->count();

        // Sitaro
        $sitaroUsaha = UsahaEsdm::where('lokasi', 'like', '%Sitaro%')
            ->orWhere('lokasi', 'like', '%Siau%')
            ->orWhere('lokasi', 'like', '%Tagulandang%')
            ->orWhere('lokasi', 'like', '%Biaro%')
            ->count();
        $sitaroMineral = Mineral::where('lokasi', 'like', '%Sitaro%')
            ->orWhere('lokasi', 'like', '%Siau%')
            ->orWhere('lokasi', 'like', '%Tagulandang%')
            ->orWhere('lokasi', 'like', '%Biaro%')
            ->count();
        $sitaroEnergi = Energi::where('desa', 'like', '%Sitaro%')
            ->orWhere('desa', 'like', '%Siau%')
            ->orWhere('desa', 'like', '%Tagulandang%')
            ->orWhere('desa', 'like', '%Biaro%')
            ->count();
        $sitaroPengawasan = Pengawasan::where('lokasi', 'like', '%Sitaro%')
            ->orWhere('lokasi', 'like', '%Siau%')
            ->orWhere('lokasi', 'like', '%Tagulandang%')
            ->orWhere('lokasi', 'like', '%Biaro%')
            ->count();

        $chartData = [
            'labels' => ['Kab. Kepulauan Sangihe', 'Kab. Kepulauan Talaud', 'Kab. Kepulauan Sitaro'],
            'usaha'      => [$sangiheUsaha, $talaudUsaha, $sitaroUsaha],
            'mineral'    => [$sangiheMineral, $talaudMineral, $sitaroMineral],
            'energi'     => [$sangiheEnergi, $talaudEnergi, $sitaroEnergi],
            'pengawasan' => [$sangihePengawasan, $talaudPengawasan, $sitaroPengawasan],
        ];

        return view('dashboard.index', compact('stats', 'chartData'));
    }
}
