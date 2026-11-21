@php
    $tag = isset($activity['href']) && $activity['href'] ? 'a' : 'div';
    $timestamp = ! empty($activity['occurred_at'])
        ? \Carbon\Carbon::parse($activity['occurred_at'])->locale('id')
        : null;
    $timeLabel = $timestamp?->diffForHumans() ?? '-';
    $timeTitle = $timestamp?->format('d M Y H:i') ?? 'Waktu tidak tersedia';
@endphp
<{{ $tag }} @if ($tag === 'a') href="{{ $activity['href'] }}" @endif class="activity-item" style="--activity-accent: {{ $activity['color'] }}">
    <span class="activity-icon" aria-hidden="true"><i class="bi {{ $activity['icon'] }}"></i></span>
    <span class="activity-body">
        <span class="activity-type">{{ $activity['type'] }}</span>
        <span class="activity-title d-block">{{ $activity['title'] }}</span>
        @if (! empty($activity['description']))
            <span class="activity-desc d-block">{{ $activity['description'] }}</span>
        @endif
    </span>
    <time class="activity-time" @if ($timestamp) datetime="{{ $timestamp->toIso8601String() }}" title="Dibuat {{ $timeTitle }}" @endif>
        <i class="bi bi-clock" aria-hidden="true"></i>
        {{ $timeLabel }}
    </time>
</{{ $tag }}>
