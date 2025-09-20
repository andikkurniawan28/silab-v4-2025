@extends('template.master')

@section('flow_nm-active', 'active')
@section('input-show', 'show')

@section('content')
    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Flow NM</strong></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('flow_nm.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" id="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="time" class="form-label">Jam</label>
                            <select id="time" name="time" class="form-control select2" required>
                                @for ($i = 0; $i <= 23; $i++)
                                    <option value="{{ $i }}">{{ $i }}:00 - {{ $i+1 }}:00 </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th class="text-left" style="width: 30%">Titik Monitoring</th>
                                    <th class="text-left">Sebelum</th>
                                    <th class="text-left">Sesudah</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Tebu --}}
                                <tr>
                                    <td>Tebu Tergiling<sub>(Ku)</sub></td>
                                    <td><input type="number" class="form-control" id="tebu_sebelum"
                                            value="{{ $last_monitoring->p1 ?? 0 }}" readonly></td>
                                    <td><input type="number" class="form-control" id="tebu_setelah" name="p1" required
                                            autofocus></td>
                                </tr>
                                {{-- NMP --}}
                                <tr>
                                    <td>Totalizer NMP</td>
                                    <td><input type="text" class="form-control" id="totalizer_nmp_sebelum"
                                            value="{{ $last_monitoring->p2 ?? 0 }}" readonly></td>
                                    <td><input type="text" class="form-control" id="totalizer_nmp_setelah" name="p2"
                                            required></td>
                                </tr>
                                <tr>
                                    <td>Flow NMP</td>
                                    <td><input type="text" class="form-control" id="flow_nmp_sebelum"
                                            value="{{ $last_monitoring->p5 ?? 0 }}" readonly></td>
                                    <td><input type="text" class="form-control" id="flow_nmp_setelah" name="p5"
                                            readonly></td>
                                </tr>
                                <tr>
                                    <td>NMP%Tebu</td>
                                    <td><input type="text" class="form-control" id="nmpptebu_sebelum"
                                            value="{{ $last_monitoring->p8 ?? 0 }}" readonly></td>
                                    <td><input type="text" class="form-control" id="nmpptebu_setelah" name="p8"
                                            readonly></td>
                                </tr>
                                {{-- NMG --}}
                                <tr>
                                    <td>Totalizer NMG</td>
                                    <td><input type="text" class="form-control" id="totalizer_nmg_sebelum"
                                            value="{{ $last_monitoring->p3 ?? 0 }}" readonly></td>
                                    <td><input type="text" class="form-control" id="totalizer_nmg_setelah" name="p3"
                                            required></td>
                                </tr>
                                <tr>
                                    <td>Flow NMG</td>
                                    <td><input type="text" class="form-control" id="flow_nmg_sebelum"
                                            value="{{ $last_monitoring->p6 ?? 0 }}" readonly></td>
                                    <td><input type="text" class="form-control" id="flow_nmg_setelah" name="p6"
                                            readonly></td>
                                </tr>
                                <tr>
                                    <td>NMG%Tebu</td>
                                    <td><input type="text" class="form-control" id="nmgptebu_sebelum"
                                            value="{{ $last_monitoring->p9 ?? 0 }}" readonly></td>
                                    <td><input type="text" class="form-control" id="nmgptebu_setelah" name="p9"
                                            readonly></td>
                                </tr>
                                {{-- SFC --}}
                                <tr>
                                    <td>SFC</td>
                                    <td><input type="text" class="form-control" id="sfc_sebelum"
                                            value="{{ $last_monitoring->p11 ?? 0 }}" readonly></td>
                                    <td><input type="text" class="form-control" id="sfc_setelah" name="p11" required>
                                    </td>
                                </tr>
                                {{-- Decanter 1 --}}
                                <tr>
                                    <td>Totalizer Decanter 1</td>
                                    <td><input type="text" class="form-control" id="totalizer_d1_sebelum"
                                            value="{{ $last_monitoring->p12 ?? 0 }}" readonly></td>
                                    <td><input type="text" class="form-control" id="totalizer_d1_setelah" name="p12"
                                            required></td>
                                </tr>
                                <tr>
                                    <td>Flow Decanter 1</td>
                                    <td><input type="text" class="form-control" id="flow_d1_sebelum"
                                            value="{{ $last_monitoring->p14 ?? 0 }}" readonly></td>
                                    <td><input type="text" class="form-control" id="flow_d1_setelah" name="p14"
                                            readonly></td>
                                </tr>
                                {{-- Decanter 2 --}}
                                <tr>
                                    <td>Totalizer Decanter 2</td>
                                    <td><input type="text" class="form-control" id="totalizer_d2_sebelum"
                                            value="{{ $last_monitoring->p13 ?? 0 }}" readonly></td>
                                    <td><input type="text" class="form-control" id="totalizer_d2_setelah"
                                            name="p13" required></td>
                                </tr>
                                <tr>
                                    <td>Flow Decanter 2</td>
                                    <td><input type="text" class="form-control" id="flow_d2_sebelum"
                                            value="{{ $last_monitoring->p15 ?? 0 }}" readonly></td>
                                    <td><input type="text" class="form-control" id="flow_d2_setelah" name="p15"
                                            readonly></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <a href="{{ route('flow_nm.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function hitungFlow() {
                let tebu = parseFloat(document.getElementById("tebu_setelah").value) || 0;

                // ambil totalizer sebelum
                let totalizer_nmp_sebelum = parseFloat(document.getElementById("totalizer_nmp_sebelum").value) || 0;
                let totalizer_nmg_sebelum = parseFloat(document.getElementById("totalizer_nmg_sebelum").value) || 0;
                let totalizer_d1_sebelum = parseFloat(document.getElementById("totalizer_d1_sebelum").value) || 0;
                let totalizer_d2_sebelum = parseFloat(document.getElementById("totalizer_d2_sebelum").value) || 0;

                // ambil totalizer setelah
                let totalizer_nmp_setelah = parseFloat(document.getElementById("totalizer_nmp_setelah").value) || 0;
                let totalizer_nmg_setelah = parseFloat(document.getElementById("totalizer_nmg_setelah").value) || 0;
                let totalizer_d1_setelah = parseFloat(document.getElementById("totalizer_d1_setelah").value) || 0;
                let totalizer_d2_setelah = parseFloat(document.getElementById("totalizer_d2_setelah").value) || 0;

                // hitung flow
                let flow_nmp = totalizer_nmp_setelah - totalizer_nmp_sebelum;
                let flow_nmg = totalizer_nmg_setelah - totalizer_nmg_sebelum;
                let flow_d1 = totalizer_d1_setelah - totalizer_d1_sebelum;
                let flow_d2 = totalizer_d2_setelah - totalizer_d2_sebelum;

                // persen tebu
                let nmpptebu = tebu !== 0 ? (flow_nmp / tebu * 100).toFixed(2) : 0;
                let nmgptebu = tebu !== 0 ? (flow_nmg / tebu * 100).toFixed(2) : 0;

                // isi ke field
                document.getElementById("flow_nmp_setelah").value = flow_nmp;
                document.getElementById("flow_nmg_setelah").value = flow_nmg;
                document.getElementById("flow_d1_setelah").value = flow_d1;
                document.getElementById("flow_d2_setelah").value = flow_d2;
                document.getElementById("nmpptebu_setelah").value = nmpptebu;
                document.getElementById("nmgptebu_setelah").value = nmgptebu;
            }

            // trigger
            document.querySelectorAll(
                    "#tebu_setelah, #totalizer_nmp_setelah, #totalizer_nmg_setelah, #totalizer_d1_setelah, #totalizer_d2_setelah"
                )
                .forEach(el => el.addEventListener("input", hitungFlow));
        });
    </script>
@endsection
