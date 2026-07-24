<?php

namespace App\Http\Controllers;

use App\Models\DataWilayah;
use App\Models\UsahaEsdm;
use App\Models\Mineral;
use App\Models\Energi;
use App\Models\Pengawasan;
use App\Models\PotensiPad;
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

        $recentActivities = $this->recentActivities();

        return view('dashboard.index', compact('stats', 'chartData', 'recentActivities'));
    }

    private function recentActivities()
    {
        return collect()
            ->merge($this->activityFromDataWilayah())
            ->merge($this->activityFromUsahaEsdm())
            ->merge($this->activityFromMineral())
            ->merge($this->activityFromEnergi())
            ->merge($this->activityFromPengawasan())
            ->merge($this->activityFromPotensiPad())
            ->sortByDesc('occurred_at')
            ->take(5)
            ->values();
    }

    private function activityFromDataWilayah()
    {
        return DataWilayah::with('desa.kecamatan.kabupaten')
            ->latest()
            ->take(2)
            ->get()
            ->map(function (DataWilayah $item) {
                $kabupaten = $item->desa?->kecamatan?->kabupaten?->nama ?? '-';
                $kecamatan = $item->desa?->kecamatan?->nama ?? '-';
                $desa = $item->desa?->nama ?? '-';

                return [
                    'type' => 'Data Wilayah',
                    'title' => $desa,
                    'description' => $kabupaten . ' · ' . $kecamatan,
                    'icon' => 'bi-map-fill',
                    'color' => '#0d6efd',
                    'href' => route('wilayah.edit', $item->id),
                    'occurred_at' => $item->created_at,
                ];
            });
    }

    private function activityFromUsahaEsdm()
    {
        return UsahaEsdm::latest()
            ->take(2)
            ->get()
            ->map(function (UsahaEsdm $item) {
                return [
                    'type' => 'Usaha ESDM',
                    'title' => $item->nama_pelaku_usaha,
                    'description' => $item->jenis_usaha . ' · ' . $item->lokasi,
                    'icon' => 'bi-briefcase-fill',
                    'color' => '#198754',
                    'href' => route('usaha.edit', $item->id),
                    'occurred_at' => $item->created_at,
                ];
            });
    }

    private function activityFromMineral()
    {
        return Mineral::latest()
            ->take(2)
            ->get()
            ->map(function (Mineral $item) {
                return [
                    'type' => 'Mineral',
                    'title' => $item->jenis_komoditas,
                    'description' => $item->lokasi,
                    'icon' => 'bi-gem',
                    'color' => '#6f42c1',
                    'href' => route('mineral.edit', $item->id),
                    'occurred_at' => $item->created_at,
                ];
            });
    }

    private function activityFromEnergi()
    {
        return Energi::latest()
            ->take(2)
            ->get()
            ->map(function (Energi $item) {
                return [
                    'type' => 'Energi',
                    'title' => $item->sumber_energi,
                    'description' => $item->desa,
                    'icon' => 'bi-plug-fill',
                    'color' => '#fd7e14',
                    'href' => route('energi.edit', $item->id),
                    'occurred_at' => $item->created_at,
                ];
            });
    }

    private function activityFromPengawasan()
    {
        return Pengawasan::latest()
            ->take(2)
            ->get()
            ->map(function (Pengawasan $item) {
                return [
                    'type' => 'Pengawasan',
                    'title' => $item->objek,
                    'description' => $item->lokasi,
                    'icon' => 'bi-shield-check',
                    'color' => '#0dcaf0',
                    'href' => route('pengawasan.edit', $item->id),
                    'occurred_at' => $item->created_at,
                ];
            });
    }

    private function activityFromPotensiPad()
    {
        return PotensiPad::latest()
            ->take(2)
            ->get()
            ->map(function (PotensiPad $item) {
                return [
                    'type' => 'Potensi PAD',
                    'title' => $item->jenis_kegiatan,
                    'description' => $item->lokasi,
                    'icon' => 'bi-cash-coin',
                    'color' => '#dc3545',
                    'href' => route('pad.edit', $item->id),
                    'occurred_at' => $item->created_at,
                ];
            });
    }
}
