@extends('template.master')

@section('analisa_bjb-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Analisa BJB</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('analisa_bjb.store') }}" method="POST">
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

                    <label class="form-label">Kalkulator BJB</label>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-secondary">
                                <tr>
                                    <th>No</th>
                                    <th>Ayakan + SHS (g)</th>
                                    <th>Ayakan (g)</th>
                                    <th>SHS (g)</th>
                                    <th>FB</th>
                                    <th>SHS Faktor (g)</th>
                                    <th>FA</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= 6; $i++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td><input id="berat_ayakan_plus_shs{{ $i }}" type="number"
                                                step="any" class="form-control form-control-sm" onchange="hitungBJB()">
                                        </td>
                                        <td><input id="berat_ayakan{{ $i }}" type="number" step="any"
                                                class="form-control form-control-sm" onchange="hitungBJB()"></td>
                                        <td id="berat_shs{{ $i }}"></td>
                                        <td id="faktor_berat{{ $i }}">{{ $factors['Faktor Berat BJB'] ?? 1 }}
                                        </td>
                                        <td id="berat_shs_koreksi{{ $i }}"></td>
                                        <td id="faktor_ayakan{{ $i }}">
                                            {{ number_format($factors['Faktor Ayakan ' . $i] ?? 1, 2) }}</td>
                                        <td id="jumlah{{ $i }}"></td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="bjb" class="form-label">BJB</label>
                        <input type="number" name="bjb" id="bjb" step="any"
                            class="form-control @error('bjb') is-invalid @enderror" value="{{ old('bjb') }}" readonly>
                        @error('bjb')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('analisa_bjb.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function hitungBJB() {
            let faktorBerat = parseFloat(document.getElementById("faktor_berat1").innerHTML) || 1;

            let total = 0;
            for (let i = 1; i <= 6; i++) {
                let ayakan = parseFloat(document.getElementById("berat_ayakan" + i).value) || 0;
                let ayakanPlus = parseFloat(document.getElementById("berat_ayakan_plus_shs" + i).value) || 0;
                let faktorAyakan = parseFloat(document.getElementById("faktor_ayakan" + i).innerHTML) || 1;

                let beratShs = ayakanPlus - ayakan;
                let beratShsKoreksi = beratShs * faktorBerat;
                let jumlah = beratShsKoreksi * faktorAyakan;

                document.getElementById("berat_shs" + i).innerHTML = beratShs.toFixed(2);
                document.getElementById("berat_shs_koreksi" + i).innerHTML = beratShsKoreksi.toFixed(2);
                document.getElementById("jumlah" + i).innerHTML = jumlah.toFixed(2);

                total += jumlah;
            }

            if (total > 0) {
                let bjb = 1000 / total;
                document.getElementById("bjb").value = bjb.toFixed(2);
            } else {
                document.getElementById("bjb").value = "";
            }
        }
    </script>
@endsection
