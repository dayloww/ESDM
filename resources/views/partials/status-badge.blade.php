@php
    $value = (string) ($status ?? '');
    $key = strtolower(str_replace([' ', '/'], '_', $value));
    $map = [
        'aktif' => ['success', 'Aktif'],
        'berlistrik' => ['success', 'Berlistrik'],
        'selesai' => ['success', 'Selesai'],
        'disetujui' => ['success', 'Disetujui'],
        'nonaktif' => ['secondary', 'Nonaktif'],
        'izin_habis' => ['danger', 'Izin habis'],
        'belum_berlistrik' => ['danger', 'Belum berlistrik'],
        'tertunda' => ['danger', 'Tertunda'],
        'ditolak' => ['danger', 'Ditolak'],
        'sebagian' => ['warning', 'Sebagian'],
        'dalam_proses' => ['warning', 'Dalam proses'],
        'menunggu' => ['warning', 'Menunggu'],
        'diproses' => ['info', 'Diproses'],
    ];
    $resolved = $map[$key] ?? ['secondary', $value !== '' ? ucfirst(str_replace('_', ' ', $value)) : '-'];
    $tone = $tone ?? $resolved[0];
    $badgeLabel = $label ?? $resolved[1];
@endphp
<span class="badge status-badge status-badge--{{ $tone }}">{{ $badgeLabel }}</span>
