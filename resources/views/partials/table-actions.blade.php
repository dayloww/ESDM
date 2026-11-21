<div class="table-actions d-flex flex-wrap gap-2">
    @if (! empty($showRoute))
        <a href="{{ route($showRoute, $id) }}" class="btn btn-outline-info btn-sm" title="Lihat detail" aria-label="Lihat detail {{ $label }}">
            <i class="bi bi-eye" aria-hidden="true"></i>
        </a>
    @endif
    <a href="{{ route($editRoute, $id) }}" class="btn btn-warning btn-sm" title="Edit" aria-label="Edit {{ $label }}">
        <i class="bi bi-pencil" aria-hidden="true"></i>
    </a>
    @if(($canDelete ?? true) && auth()->user()?->canDeleteData())
        <form action="{{ route($deleteRoute, $id) }}" method="POST" class="d-inline" id="delete-form-{{ $id }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" data-delete-label="{{ $label }}"
                    onclick="deleteConfirm(event, 'delete-form-{{ $id }}')" aria-label="Hapus {{ $label }}">
                <i class="bi bi-trash" aria-hidden="true"></i>
            </button>
        </form>
    @endif
</div>
