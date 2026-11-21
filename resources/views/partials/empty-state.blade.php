@php
    $hasFilter = collect(request()->query())
        ->filter(fn ($value) => $value !== null && $value !== '')
        ->isNotEmpty();
@endphp
<div class="text-center py-5">
    <i class="bi {{ $hasFilter ? 'bi-search' : 'bi-inbox' }} fs-1 text-secondary d-block mb-2" aria-hidden="true"></i>
    <p class="text-secondary mb-3">
        @if($hasFilter)
            Tidak ada {{ $label }} yang cocok dengan filter saat ini.
        @else
            Belum ada {{ $label }} yang tersimpan.
        @endif
    </p>
    <div class="d-flex flex-wrap justify-content-center gap-2">
        @if($hasFilter)
            <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-sm" role="button">Hapus filter</a>
        @endif
        @if (auth()->user()?->canManageData())
            <a href="{{ route($createRoute) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> {{ $createLabel }}
            </a>
        @endif
    </div>
</div>
