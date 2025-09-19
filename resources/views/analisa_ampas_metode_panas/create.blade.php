@extends('template.master')

@section('analisa_ampas_metode_panas-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Analisa Ampas Metode Panas</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('analisa_ampas_metode_panas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="id" class="form-label">Barcode</label>
                        <select name="id" id="id" class="form-select select2" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($samples as $s)
                                <option value="{{ $s->id }}" data-pol="{{ $s->pol }}"
                                    data-kadar_air="{{ $s->kadar_air }}" {{ old('id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="brix_nira_gilingan5" class="form-label">Brix Nira Gilingan 5</label>
                                <input type="number" name="brix_nira_gilingan5" id="brix_nira_gilingan5" step="any"
                                    class="form-control @error('brix_nira_gilingan5') is-invalid @enderror"
                                    value="{{ old('brix_nira_gilingan5') }}" required>
                                @error('brix_nira_gilingan5')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kadar_air" class="form-label">Kadar Air (MC)</label>
                                <input type="number" name="kadar_air" id="kadar_air" step="any"
                                    class="form-control @error('kadar_air') is-invalid @enderror"
                                    value="{{ old('kadar_air') }}" readonly>
                                @error('kadar_air')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pol" class="form-label">Pol Baca</label>
                                <input type="number" name="pol" id="pol" step="any"
                                    class="form-control @error('pol') is-invalid @enderror" value="{{ old('pol') }}"
                                    readonly>
                                @error('pol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="zat_kering" class="form-label">Zat Kering</label>
                                <input type="number" name="zat_kering" id="zat_kering" step="any"
                                    class="form-control @error('zat_kering') is-invalid @enderror"
                                    value="{{ old('zat_kering') }}" readonly>
                                @error('zat_kering')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="pol_ampas" class="form-label">Pol Ampas</label>
                                <input type="number" name="pol_ampas" id="pol_ampas" step="any"
                                    class="form-control @error('pol_ampas') is-invalid @enderror"
                                    value="{{ old('pol_ampas') }}" readonly>
                                @error('pol_ampas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('analisa_ampas_metode_panas.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const factor = {{ $factor }};

            function hitungPolAmpas() {
                let pol = parseFloat($('#pol').val()) || 0;
                let mc = parseFloat($('#kadar_air').val()) || 0;
                let brix = parseFloat($('#brix_nira_gilingan5').val()) || 0;

                if (pol > 0 && mc >= 0) {
                    let pol_ampas = ((pol / 2) * 0.0286 * ((10000 + mc) / 100) * 2.5) + (factor * brix);
                    $('#pol_ampas').val(pol_ampas.toFixed(4));
                } else {
                    $('#pol_ampas').val('');
                }
            }

            $('#id').on('change', function() {
                let pol = $(this).find(':selected').data('pol');
                let kadarAir = $(this).find(':selected').data('kadar_air');

                $('#pol').val(pol ?? '');
                $('#kadar_air').val(kadarAir ?? '');

                if (kadarAir !== undefined && kadarAir !== null && kadarAir !== '') {
                    $('#zat_kering').val(100 - parseFloat(kadarAir));
                } else {
                    $('#zat_kering').val('');
                }

                hitungPolAmpas();
            });

            $('#brix_nira_gilingan5').on('input', function() {
                hitungPolAmpas();
            });

            $('#id').trigger('change');
        });
    </script>
@endsection
