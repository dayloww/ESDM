@if (auth()->user()?->canManageData())
    <a href="{{ route($route) }}" class="btn btn-primary btn-sm create-button">
        <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> {{ $label }}
    </a>
@endif
