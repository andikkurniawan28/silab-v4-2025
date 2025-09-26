@extends('template.master')

@section('core_samples-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit Core Sample</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('core_samples.update', $core_sample->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" value="{{ date('Y-m-d H:i') }}" name="core_at">

                    <div class="mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="number" name="id" id="id"
                            class="form-control @error('id') is-invalid @enderror"
                            value="{{ old('id', $core_sample->id) }}" readonly>
                        @error('id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="brix_core" class="form-label">Brix</label>
                        <input type="number" name="brix_core" id="brix_core" step="any"
                            class="form-control @error('brix_core') is-invalid @enderror"
                            value="{{ old('brix_core', $core_sample->brix_core) }}" required autofocus>
                        @error('brix_core')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pol_core" class="form-label">Pol</label>
                        <input type="number" name="pol_core" id="pol_core" step="any"
                            class="form-control @error('pol_core') is-invalid @enderror"
                            value="{{ old('pol_core', $core_sample->pol_core) }}" required>
                        @error('pol_core')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pol_baca_core" class="form-label">Pol Baca</label>
                        <input type="number" name="pol_baca_core" id="pol_baca_core" step="any"
                            class="form-control @error('pol_baca_core') is-invalid @enderror"
                            value="{{ old('pol_baca_core', $core_sample->pol_baca_core) }}" required>
                        @error('pol_baca_core')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="rendemen_core" class="form-label">R</label>
                        <input type="number" name="rendemen_core" id="rendemen_core" step="any"
                            class="form-control @error('rendemen_core') is-invalid @enderror"
                            value="{{ old('rendemen_core', $core_sample->rendemen_core) }}" required>
                        @error('rendemen_core')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('core_samples.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function hitungRendemen() {
            let brix = parseFloat($('#brix_core').val()) || 0;
            let pol = parseFloat($('#pol_core').val()) || 0;
            $('#rendemen_core').val(((pol - (0.5 * (brix - pol))) * 0.7).toFixed(2));
        }

        function hitungPol() {
            let brix = parseFloat($('#brix_core').val()) || 0;
            let r = parseFloat($('#rendemen_core').val()) || 0;
            let pol = ((r / 0.7) + (0.5 * brix)) / 1.5;
            $('#pol_core').val((pol).toFixed(2));
        }

        $('#brix_core, #pol_core').on('input', hitungRendemen);
        $('#rendemen_core').on('input', hitungPol);
    </script>
@endsection
