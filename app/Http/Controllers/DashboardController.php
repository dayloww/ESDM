<?php

namespace App\Http\Controllers;

use App\Models\DataWilayah;
use App\Models\Energi;
use App\Models\Mineral;
use App\Models\Pengawasan;
use App\Models\PotensiPad;
use App\Models\UsahaEsdm;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Wilayah kerja beserta kata kunci pencarian lokasinya.
     */
    private const REGIONS = [
        'sangihe' => [
            'name' => 'Kab. Kepulauan Sangihe',
            'keywords' => ['Sangihe'],
        ],
        'talaud' => [
            'name' => 'Kab. Kepulauan Talaud',
            'keywords' => ['Talaud'],
        ],
        'sitaro' => [
            'name' => 'Kab. Kepulauan Sitaro',
            'keywords' => ['Sitaro', 'Siau', 'Tagulandang', 'Biaro'],
        ],
    ];

    /**
     * Tampilkan halaman dashboard.
     */
    public function index(): View
    {
        $stats = $this->stats();
        $regionCounts = $this->regionCounts();

        $chartData = [
            'labels' => array_column(self::REGIONS, 'name'),
            'usaha' => array_column($regionCounts, 'usaha'),
            'mineral' => array_column($regionCounts, 'mineral'),
            'energi' => array_column($regionCounts, 'energi'),
            'pengawasan' => array_column($regionCounts, 'pengawasan'),
        ];

        $recentActivities = $this->recentActivities();
        $monthlyGrowth = $this->monthlyGrowth();
        $hasRegionalData = $this->hasRegionalData($regionCounts);

        return view('dashboard.index', compact(
            'stats',
            'chartData',
            'recentActivities',
            'monthlyGrowth',
            'hasRegionalData',
        ));
    }

    public function analisis(): View
    {
        $stats = $this->stats();
        $regionCounts = $this->regionCounts();

        return view('dashboard.analisis', [
            'stats' => $stats,
            'compositionData' => $this->compositionData($stats),
            'regionalSummary' => $this->regionalSummary($regionCounts),
            'mapMarkers' => $this->mapMarkers(),
        ]);
    }

    private function stats(): array
    {
        return [
            'wilayah' => DataWilayah::count(),
            'usaha' => UsahaEsdm::count(),
            'mineral' => Mineral::count(),
            'energi' => Energi::count(),
            'pengawasan' => Pengawasan::count(),
            'pad' => PotensiPad::query()->count(),
        ];
    }

    private function compositionData(array $stats): array
    {
        return [
            'labels' => ['Data Wilayah', 'Usaha ESDM', 'Mineral', 'Energi', 'Pengawasan', 'Potensi PAD'],
            'values' => [$stats['wilayah'], $stats['usaha'], $stats['mineral'], $stats['energi'], $stats['pengawasan'], $stats['pad']],
            'colors' => ['#2563EB', '#0891B2', '#1E40AF', '#16A34A', '#64748B', '#475569'],
        ];
    }

    /**
     * Jumlah data baru per modul pada bulan berjalan (angka asli database).
     */
    private function monthlyGrowth(): array
    {
        $startOfMonth = now()->startOfMonth();

        return [
            'wilayah' => DataWilayah::where('created_at', '>=', $startOfMonth)->count(),
            'usaha' => UsahaEsdm::where('created_at', '>=', $startOfMonth)->count(),
            'mineral' => Mineral::where('created_at', '>=', $startOfMonth)->count(),
            'energi' => Energi::where('created_at', '>=', $startOfMonth)->count(),
            'pengawasan' => Pengawasan::where('created_at', '>=', $startOfMonth)->count(),
            'pad' => PotensiPad::query()->where('created_at', '>=', $startOfMonth)->count(),
        ];
    }

    private function hasRegionalData(array $regionCounts): bool
    {
        return collect($regionCounts)
            ->flatten()
            ->contains(fn ($value) => (int) $value > 0);
    }

    /**
     * Jumlah data per modul untuk setiap wilayah kerja (angka asli database).
     */
    private function regionCounts(): array
    {
        $metrics = [
            'usaha' => [UsahaEsdm::class, 'lokasi'],
            'mineral' => [Mineral::class, 'lokasi'],
            'energi' => [Energi::class, 'desa'],
            'pengawasan' => [Pengawasan::class, 'lokasi'],
        ];

        $counts = [];

        foreach (self::REGIONS as $key => $region) {
            foreach ($metrics as $metric => [$model, $column]) {
                $counts[$key][$metric] = $model::query()
                    ->where(function ($query) use ($column, $region) {
                        foreach ($region['keywords'] as $keyword) {
                            $query->orWhere($column, 'like', "%{$keyword}%");
                        }
                    })
                    ->count();
            }
        }

        return $counts;
    }

    /**
     * Ringkasan total data per wilayah kerja untuk panel Informasi Wilayah.
     */
    private function regionalSummary(array $regionCounts): array
    {
        $rows = collect($regionCounts)
            ->map(function (array $counts, string $key): array {
                return [
                    'name' => self::REGIONS[$key]['name'],
                    'meta' => sprintf(
                        'Usaha %d · Mineral %d · Energi %d · Pengawasan %d',
                        $counts['usaha'],
                        $counts['mineral'],
                        $counts['energi'],
                        $counts['pengawasan']
                    ),
                    'total' => array_sum($counts),
                ];
            })
            ->values();

        $maxTotal = (int) $rows->max('total');

        return $rows
            ->map(function (array $row) use ($maxTotal): array {
                $row['percent'] = $maxTotal > 0 ? (int) round(($row['total'] / $maxTotal) * 100) : 0;

                return $row;
            })
            ->all();
    }

    /**
     * Marker peta dari koordinat asli tabel data_wilayah dan usaha_esdm.
     * Koordinat kosong atau tidak valid dilewati — tanpa marker dummy.
     */
    private function mapMarkers(): array
    {
        $markers = [];

        DataWilayah::with('desa.kecamatan.kabupaten')
            ->whereNotNull('koordinat')
            ->latest()
            ->limit(200)
            ->get()
            ->each(function (DataWilayah $item) use (&$markers) {
                $coordinate = $this->parseCoordinate($item->koordinat);
                if ($coordinate === null) {
                    return;
                }

                $location = collect([
                    $item->desa?->kecamatan?->nama,
                    $item->desa?->kecamatan?->kabupaten?->nama,
                ])->filter()->implode(', ');

                $markers[] = $coordinate + [
                    'title' => $item->desa?->nama ?? '-',
                    'description' => $location !== '' ? $location : 'Data Wilayah',
                    'type' => 'wilayah',
                ];
            });

        UsahaEsdm::whereNotNull('koordinat')
            ->latest()
            ->limit(200)
            ->get()
            ->each(function (UsahaEsdm $item) use (&$markers) {
                $coordinate = $this->parseCoordinate($item->koordinat);
                if ($coordinate === null) {
                    return;
                }

                $markers[] = $coordinate + [
                    'title' => $item->nama_pelaku_usaha ?? '-',
                    'description' => filled($item->lokasi) ? $item->lokasi : 'Usaha ESDM',
                    'type' => 'usaha',
                ];
            });

        return $markers;
    }

    /**
     * Parse string koordinat dengan aman menjadi lat/lng float.
     * Menerima format umum seperti "3.6236, 125.4678", "(3.62;125.46)", "3,6236 125,4678".
     * Hanya menerima titik di dalam bounding box wilayah kerja Wilayah IV.
     */
    private function parseCoordinate(?string $raw): ?array
    {
        if (! filled($raw)) {
            return null;
        }

        if (! preg_match_all('/-?\d+(?:[.,]\d+)?/', $raw, $matches) || count($matches[0]) < 2) {
            return null;
        }

        $lat = (float) str_replace(',', '.', $matches[0][0]);
        $lng = (float) str_replace(',', '.', $matches[0][1]);

        // Bounding box Wilayah IV (Sangihe–Talaud–Sitaro); di luar ini dianggap tidak valid.
        if ($lat < 0.0 || $lat > 6.5 || $lng < 122.5 || $lng > 129.5) {
            return null;
        }

        return ['lat' => $lat, 'lng' => $lng];
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
                    'description' => $kabupaten.' · '.$kecamatan,
                    'icon' => 'bi-map-fill',
                    'color' => '#2563EB',
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
                    'description' => $item->jenis_usaha.' · '.$item->lokasi,
                    'icon' => 'bi-briefcase-fill',
                    'color' => '#0891B2',
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
                    'color' => '#1E40AF',
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
                    'color' => '#16A34A',
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
                    'color' => '#64748B',
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
                    'color' => '#F59E0B',
                    'href' => route('pad.edit', $item->id),
                    'occurred_at' => $item->created_at,
                ];
            });
    }
}
