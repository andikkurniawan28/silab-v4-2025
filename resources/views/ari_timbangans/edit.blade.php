@extends('template.master')

@section('ari_timbangans-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Edit ARI Timbangan</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('ari_timbangans.update', $ari_timbangan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" value="{{ date('Y-m-d H:i') }}" name="ari_at">

                    <div class="mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="number" name="id" id="id"
                            class="form-control @error('id') is-invalid @enderror"
                            value="{{ old('id', $ari_timbangan->id) }}" readonly>
                        @error('id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="brix_ari" class="form-label">Brix</label>
                        <input type="number" name="brix_ari" id="brix_ari" step="any"
                            class="form-control @error('brix_ari') is-invalid @enderror"
                            value="{{ old('brix_ari', $ari_timbangan->brix_ari) }}" required autofocus>
                        @error('brix_ari')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pol_ari" class="form-label">Pol</label>
                        <input type="number" name="pol_ari" id="pol_ari" step="any"
                            class="form-control @error('pol_ari') is-invalid @enderror"
                            value="{{ old('pol_ari', $ari_timbangan->pol_ari) }}" required>
                        @error('pol_ari')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pol_baca_ari" class="form-label">Pol Baca</label>
                        <input type="number" name="pol_baca_ari" id="pol_baca_ari" step="any"
                            class="form-control @error('pol_baca_ari') is-invalid @enderror"
                            value="{{ old('pol_baca_ari', $ari_timbangan->pol_baca_ari) }}" required>
                        @error('pol_baca_ari')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="rendemen_ari" class="form-label">R</label>
                        <input type="number" name="rendemen_ari" id="rendemen_ari" step="any"
                            class="form-control @error('rendemen_ari') is-invalid @enderror"
                            value="{{ old('rendemen_ari', $ari_timbangan->rendemen_ari) }}" required>
                        @error('rendemen_ari')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('ari_timbangans.index') }}" class="btn btn-secondary">
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
            let brix = parseFloat($('#brix_ari').val()) || 0;
            let pol = parseFloat($('#pol_ari').val()) || 0;
            $('#rendemen_ari').val(((pol - (0.5 * (brix - pol))) * 0.7).toFixed(2));
        }

        function hitungPol() {
            let brix = parseFloat($('#brix_ari').val()) || 0;
            let r = parseFloat($('#rendemen_ari').val()) || 0;
            let pol = ((r / 0.7) + (0.5 * brix)) / 1.5;
            $('#pol_ari').val((pol).toFixed(2));
        }

        $('#brix_ari, #pol_ari').on('input', hitungRendemen);
        $('#rendemen_ari').on('input', hitungPol);
    </script>
@endsection
