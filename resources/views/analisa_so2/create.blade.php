@extends('template.master')

@section('analisa_so2-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Analisa SO<sub>2</sub></strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('analisa_so2.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="id" class="form-label">Barcode</label>
                        <select name="id" id="id" class="form-select select2" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($samples as $s)
                                <option value="{{ $s->id }}" {{ old('id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->id }} | {{ $s->material->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="v2" class="form-label">Volume Titrasi Sebenarnya</label>
                                <input type="number" name="v2" id="v2" step="any"
                                    class="form-control @error('v2') is-invalid @enderror"
                                    value="{{ old('v2') }}" required>
                                @error('v2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="v1" class="form-label">Volume Titrasi Blanko</label>
                                <input type="number" name="v1" id="v1" step="any"
                                    class="form-control @error('v1') is-invalid @enderror"
                                    value="{{ old('v1') }}" required>
                                @error('v1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="so2" class="form-label">Kadar SO<sub>2</sub></label>
                                <input type="number" name="so2" id="so2" step="any"
                                    class="form-control @error('so2') is-invalid @enderror" value="{{ old('so2') }}"
                                    readonly>
                                @error('so2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('analisa_so2.index') }}" class="btn btn-secondary">
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

        function hitungSO2() {
            let v1 = parseFloat($('#v1').val()) || 0;
            let v2 = parseFloat($('#v2').val()) || 0;

            if (v2 > 0 && v1 >= 0) {
                let so2 = (v2 - v1) * factor * 20;
                $('#so2').val(so2.toFixed(4));
            } else {
                $('#so2').val('');
            }
        }

        // trigger perhitungan ketika v1 / v2 berubah
        $('#v1, #v2').on('input', function() {
            hitungSO2();
        });

        // jika barcode dipilih, isi data default lalu hitung
        $('#id').on('change', function() {
            let v2 = $(this).find(':selected').data('v2');
            let so2 = $(this).find(':selected').data('so2');

            $('#v2').val(v2 ?? '');
            $('#so2').val(so2 ?? '');

            hitungSO2();
        });

        // jalankan sekali saat load kalau ada value lama
        $('#id').trigger('change');
    });
</script>
@endsection

