@if ($errors->any())
    <div class="alert alert-danger" role="alert" aria-live="polite" id="form-error-summary">
        <h6 class="alert-heading fw-semibold">Periksa kembali isian berikut:</h6>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
