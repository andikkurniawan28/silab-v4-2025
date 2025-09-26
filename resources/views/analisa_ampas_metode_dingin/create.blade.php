@extends('template.master')

@section('analisa_ampas_metode_dingin-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Analisa Ampas Metode John Payne</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('analisa_ampas_metode_dingin.store') }}" method="POST">
                    @csrf

                    {{-- Barcode full --}}
                    <div class="mb-3">
                        <label for="id" class="form-label">Barcode</label>
                        <select name="id" id="id" class="form-select select2" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($samples as $s)
                                <option value="{{ $s->id }}" data-pol="{{ $s->pol }}"
                                    data-kadar_air="{{ $s->kadar_air }}" {{ old('id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->id }} | {{ $s->material->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 2 kolom --}}
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Berat sampel & air --}}
                            <div class="mb-3">
                                <label for="berat_sampel" class="form-label">Berat Sampel</label>
                                <input type="number" step="any" class="form-control" name="berat_sampel" id="berat_sampel" value="{{ old('berat_sampel') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="berat_air" class="form-label">Berat Air</label>
                                <input type="number" step="any" class="form-control" name="berat_air" id="berat_air" value="{{ old('berat_air') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="brix" class="form-label">Brix</label>
                                <input type="number" step="any" class="form-control" name="brix" id="brix" value="{{ old('brix') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="bj" class="form-label">BJ</label>
                                <input type="text" class="form-control bg-light" id="bj" name="bj" readonly value="0.000000">
                            </div>
                            <div class="mb-3">
                                <label for="berat_residual_juice" class="form-label">Berat Residual Juice</label>
                                <input type="text" class="form-control bg-light" id="berat_residual_juice" name="berat_residual_juice" readonly value="0.00">
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- hasil perhitungan --}}
                            <div class="mb-3">
                                <label for="pol" class="form-label">Pol Baca</label>
                                <input type="text" class="form-control bg-light" id="pol" name="pol" readonly value="{{ old('pol') }}">
                            </div>
                            <div class="mb-3">
                                <label for="zat_kering" class="form-label">Berat Kering</label>
                                <input type="text" class="form-control bg-light" id="zat_kering" name="zat_kering" readonly value="0.00">
                            </div>
                            <div class="mb-3">
                                <label for="kadar_air" class="form-label">Kadar Air (%)</label>
                                <input type="text" class="form-control bg-light" id="kadar_air" name="kadar_air" readonly value="0.00">
                            </div>
                            <div class="mb-3">
                                <label for="pol_persen" class="form-label">%Pol</label>
                                <input type="text" class="form-control bg-light" id="pol_persen" name="pol_persen" readonly value="0.00">
                            </div>
                            <div class="mb-3">
                                <label for="pol_ampas" class="form-label">Pol Ampas</label>
                                <input type="text" class="form-control bg-light" id="pol_ampas" name="pol_ampas" readonly value="0.00">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('analisa_ampas_metode_dingin.index') }}" class="btn btn-secondary">
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
        const bjTable = {
            0.0: 0.998203, 0.1: 0.998588, 0.2: 0.998973, 0.3: 0.999358, 0.4: 0.999744,
            0.5: 1.000130, 0.6: 1.000516, 0.7: 1.000902, 0.8: 1.001289, 0.9: 1.001676,
            1.0: 1.002063, 1.1: 1.002451, 1.2: 1.002839, 1.3: 1.003227, 1.4: 1.003615,
            1.5: 1.004004, 1.6: 1.004393, 1.7: 1.004782, 1.8: 1.005172, 1.9: 1.005562,
            2.0: 1.005952
        };

        function updateBJ() {
            const brix = parseFloat($('#brix').val());
            if (isNaN(brix)) {
                $('#bj').val('0.000000');
                return;
            }
            const rounded = Math.round(brix * 10) / 10;
            const bj = bjTable[rounded];
            $('#bj').val(bj ? bj.toFixed(6) : '0.000000');
        }

        function updateResidualJuice() {
            const sampel = parseFloat($('#berat_sampel').val()) || 0;
            const kering = parseFloat($('#zat_kering').val()) || 0;
            const residual = (sampel * kering) / 100;
            $('#berat_residual_juice').val(residual.toFixed(2));
        }

        function updatePolPersen() {
            const pol = parseFloat($('#pol').val()) || 0;
            const bj = parseFloat($('#bj').val()) || 1;
            const hasil = pol * 0.286 / bj * 10;
            $('#pol_persen').val(isFinite(hasil) ? hasil.toFixed(2) : '0.00');
        }

        function updatePolAmpas() {
            const pol = parseFloat($('#pol_persen').val()) || 0;
            const sampel = parseFloat($('#berat_sampel').val()) || 0;
            const air = parseFloat($('#berat_air').val()) || 0;
            const residual = parseFloat($('#berat_residual_juice').val()) || 0;
            const hasilAmpas = sampel > 0 ? ((pol * 0.26 * (air + residual)) / sampel) : 0;
            $('#pol_ampas').val(hasilAmpas.toFixed(2));
        }

        function updateAll() {
            updateBJ();
            updateResidualJuice();
            updatePolPersen();
            updatePolAmpas();
        }

        $('#id').on('change', function() {
            let pol = $(this).find(':selected').data('pol');
            let kadarAir = $(this).find(':selected').data('kadar_air');

            $('#pol').val(pol ?? '0.00');
            $('#kadar_air').val(kadarAir ?? '0.00');
            $('#zat_kering').val((100 - parseFloat(kadarAir || 0)).toFixed(2));

            updateAll();
        });

        $('#brix, #berat_sampel, #berat_air').on('input', updateAll);
        $('#id').trigger('change');
    });
</script>
@endsection
