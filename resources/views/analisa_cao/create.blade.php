@extends('template.master')

@section('analisa_cao-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Analisa CaO</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('analisa_cao.store') }}" method="POST">
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
                                <label for="titrasi" class="form-label">Volume Titrasi</label>
                                <input type="number" name="titrasi" id="titrasi" step="any"
                                    class="form-control @error('titrasi') is-invalid @enderror" value="{{ old('titrasi') }}"
                                    required>
                                @error('titrasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="pengenceran" class="form-label">Pengenceran</label>
                                <input type="number" name="pengenceran" id="pengenceran" step="any"
                                    class="form-control @error('pengenceran') is-invalid @enderror"
                                    value="{{ old('pengenceran') }}" required>
                                @error('pengenceran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cao" class="form-label">Kadar CaO</label>
                                <input type="number" name="cao" id="cao" step="any"
                                    class="form-control @error('cao') is-invalid @enderror" value="{{ old('cao') }}"
                                    readonly>
                                @error('cao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('analisa_cao.index') }}" class="btn btn-secondary">
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
            const factor = {{ $factor }}; // sudah dikirim dari controller

            function hitungCaO() {
                let pengenceran = parseFloat($('#pengenceran').val()) || 0;
                let titrasi = parseFloat($('#titrasi').val()) || 0;

                if (titrasi > 0 && pengenceran >= 0) {
                    let cao = titrasi * factor * 200 * pengenceran;
                    $('#cao').val(cao.toFixed(4));
                } else {
                    $('#cao').val('');
                }
            }

            // trigger perhitungan ketika pengenceran / titrasi berubah
            $('#pengenceran, #titrasi').on('input', function() {
                hitungCaO();
            });

            // kalau barcode dipilih
            $('#id').on('change', function() {
                let titrasi = $(this).find(':selected').data('titrasi');
                let cao = $(this).find(':selected').data('cao');

                $('#titrasi').val(titrasi ?? '');
                $('#cao').val(cao ?? '');

                hitungCaO();
            });

            // jalankan sekali saat load kalau ada value lama
            $('#id').trigger('change');
        });
    </script>
@endsection
