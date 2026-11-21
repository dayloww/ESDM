@if (! empty($filters))
<form method="GET" action="{{ route($routeName) }}" class="row g-2 align-items-end mb-3">
    @foreach ($filters as $filter)
        <div class="col-12 col-sm-6 col-lg-3">
            <label class="form-label small fw-semibold" for="filter-{{ $filter['name'] }}">{{ $filter['label'] }}</label>
            @if (($filter['type'] ?? 'select') === 'select')
                <select class="form-select form-select-sm" id="filter-{{ $filter['name'] }}" name="{{ $filter['name'] }}">
                    <option value="">Semua {{ $filter['label'] }}</option>
                    @foreach ($filter['options'] as $value => $label)
                        <option value="{{ $value }}" {{ (string) request($filter['name']) === (string) $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            @else
                <input type="{{ $filter['type'] }}" class="form-control form-control-sm"
                       id="filter-{{ $filter['name'] }}" name="{{ $filter['name'] }}"
                       value="{{ request($filter['name']) }}"
                        placeholder="{{ $filter['placeholder'] ?? 'Cari ' . strtolower($filter['label']) }}">
            @endif
        </div>
    @endforeach
    <div class="col-12 col-sm-6 col-lg-auto d-flex flex-wrap gap-2">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="bi bi-filter me-1" aria-hidden="true"></i> Terapkan
        </button>
        <a href="{{ route($routeName) }}" class="btn btn-outline-secondary btn-sm" role="button" aria-label="Reset filter">Reset</a>
    </div>
</form>
@endif
