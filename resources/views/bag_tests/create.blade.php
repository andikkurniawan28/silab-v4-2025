@extends('template.master')

@section('bag_tests-active', 'active')
@section('input-show', 'show')
@section('input-active', 'active')

@section('content')
    <style>
        input[type="text"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            font-size: 1rem;
        }

        table,
        table th,
        table td {
            font-size: 1rem;
        }
    </style>

    <div class="container-fluid py-0 px-0">
        <h1 class="h3 mb-3"><strong>Tambah Uji Karung</strong></h1>


        <form action="{{ route("bag_tests.store") }}" method="POST">
            @csrf

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Tanggal Pengujian</th>
                        <th class="text-center">Tanggal Kedatangan</th>
                        <th class="text-center">Batch</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="date" class="form-control" id="test_date" name="test_date"
                                value="{{ date('Y-m-d') }}" required>
                        </td>
                        <td>
                            <input type="date" class="form-control" id="arrival_date" name="arrival_date"
                                value="{{ date('Y-m-d') }}" required>
                        </td>
                        <td>
                            <input type="number" class="form-control" id="batch" name="batch" value="1"
                                required>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-primary" onclick="tambahBaris()">Tambah</button>
                                <button type="button" class="btn btn-danger" onclick="hapusBarisTerakhir()">Hapus</button>
                                {{-- <button type="button" class="btn btn-secondary" onclick="cetakLaporan()">Cetak</button> --}}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <style>
                <style>@media (max-width: 576px) {

                    .table th,
                    .table td {
                        font-size: 0.7rem;
                        padding: 0.25rem;
                    }

                    .card h5 {
                        font-size: 1rem;
                    }
                }
            </style>
            </style>

            <!-- Tabel Pengukuran -->
            <div class="row g-4">
                <!-- I. Panjang dan Lebar Karung -->
                <div class="col-md-6 col-sm-12">
                    <div class="card p-3">
                        <h5 class="text-center mb-3">I. Panjang dan Lebar Karung (Cm)</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="table-dimensi">
                                <thead>
                                    <tr class="bg-secondary text-white text-center">
                                        <th rowspan="2">No</th>
                                        <th colspan="2">Outer</th>
                                        <th colspan="2">Inner</th>
                                    </tr>
                                    <tr class="bg-secondary text-white text-center">
                                        <th colspan="1">P</th>
                                        <th colspan="1">L</th>
                                        <th colspan="1">P</th>
                                        <th colspan="1">L</th>
                                    </tr>
                                    <tr class="bg-info text-white text-center">
                                        <th>Std</th>
                                        <th>97</th>
                                        {{-- <th>Ket</th> --}}
                                        <th>57</th>
                                        {{-- <th>Ket</th> --}}
                                        <th>110</th>
                                        {{-- <th>Ket</th> --}}
                                        <th>60</th>
                                        {{-- <th>Ket</th> --}}
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- II. Berat Karung -->
                <div class="col-md-6 col-sm-12">
                    <div class="card p-3">
                        <h5 class="text-center mb-3">II. Berat Karung (Gram)</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="table-berat">
                                <thead class="bg-secondary text-white text-center">
                                    <tr>
                                        <th rowspan="1">No</th>
                                        <th colspan="1">Outer</th>
                                        <th colspan="1">Inner</th>
                                    </tr>
                                    <tr class="bg-info text-white text-center">
                                        <th>Std</th>
                                        <th>110</th>
                                        {{-- <th>Ket</th> --}}
                                        <th>36</th>
                                        {{-- <th>Ket</th> --}}
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- III. Tebal Karung -->
                <div class="col-md-6 col-sm-12 mb-3 mt-3">
                    <div class="card p-3">
                        <h5 class="text-center mb-3">III. Tebal Karung (mm)</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="table-tebal">
                                <thead class="bg-secondary text-white text-center">
                                    <tr>
                                        <th rowspan="1">No</th>
                                        <th colspan="2">Outer</th>
                                        <th colspan="2">Inner</th>
                                    </tr>
                                    <tr class="bg-info text-white text-center">
                                        <th>Std</th>
                                        <th>Raw</th>
                                        <th>0.175</th>
                                        {{-- <th>Ket</th> --}}
                                        <th>Raw</th>
                                        <th>0.03</th>
                                        {{-- <th>Ket</th> --}}
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- IV. Anyaman / Mesh -->
                <div class="col-md-6 col-sm-12">
                    <div class="card p-3">
                        <h5 class="text-center mb-3">IV. Anyaman / Mesh Karung</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="table-mesh">
                                <thead class="bg-secondary text-white text-center">
                                    <tr>
                                        <th rowspan="1">No</th>
                                        <th colspan="1">Alas</th>
                                        <th colspan="1">Tinggi</th>
                                    </tr>
                                    <tr class="bg-info text-white text-center">
                                        <th>Std</th>
                                        <th>12</th>
                                        {{-- <th>Ket</th> --}}
                                        <th>12</th>
                                        {{-- <th>Ket</th> --}}
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- V. Denier -->
                <div class="col-md-6 col-sm-12">
                    <div class="card p-3">
                        <h5 class="text-center mb-3">V. Denier (D)</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="table-denier">
                                <thead class="bg-secondary text-white text-center">
                                    <tr>
                                        <th>No</th>
                                        <th colspan="1">Denier</th>
                                    </tr>
                                    <tr class="bg-info text-white text-center">
                                        <th>Std</th>
                                        <th>900</th>
                                        {{-- <th>Ket</th> --}}
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <br>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>
@endsection

@section('script')

    <script>
        function hitungDenier(no) {
            const lebarOuterElem = document.querySelector(`input[name="dimensi[${no}][l_nilai_outer]"]`);
            const panjangOuterElem = document.querySelector(`input[name="dimensi[${no}][p_nilai_outer]"]`);
            const anyamanAlasElem = document.querySelector(`input[name="mesh[${no}][alas]"]`);
            const anyamanTinggiElem = document.querySelector(`input[name="mesh[${no}][tinggi]"]`);
            const beratOuterElem = document.querySelector(`input[name="berat[${no}][outer]"]`);
            const denierElem = document.querySelector(`input[name="denier[${no}][nilai]"]`);

            if (!lebarOuterElem || !panjangOuterElem || !anyamanAlasElem ||
                !anyamanTinggiElem || !beratOuterElem || !denierElem) {
                return;
            }

            const lebar = parseFloat(lebarOuterElem.value) || 0;
            const panjang = parseFloat(panjangOuterElem.value) || 0;
            const anyamanAlas = parseFloat(anyamanAlasElem.value) || 0;
            const anyamanTinggi = parseFloat(anyamanTinggiElem.value) || 0;
            const beratOuter = parseFloat(beratOuterElem.value) || 0;

            if (lebar === 0 || panjang === 0 || anyamanAlas === 0 || anyamanTinggi === 0 || beratOuter === 0) {
                denierElem.value = '';
                return;
            }

            const CM_TO_INCHI = 0.3937007874;
            const INCHI_TO_METER = 0.0254;

            // Langkah 1: konversi ke inchi lalu bulatkan 1 angka di belakang koma (seperti Excel)
            const W = parseFloat((lebar * CM_TO_INCHI).toFixed(1));
            const H = parseFloat((panjang * CM_TO_INCHI).toFixed(1));

            // Langkah 2: Rumus ukuran seperti Excel
            const bagian1 = (CM_TO_INCHI * panjang * anyamanAlas * H) * INCHI_TO_METER;
            const bagian2 = (CM_TO_INCHI * lebar * anyamanTinggi * W) * INCHI_TO_METER;
            const ukuran = (bagian1 + bagian2) * 2;

            if (ukuran === 0) {
                denierElem.value = '';
                return;
            }

            const denier = (beratOuter / ukuran) * 9000;

            // Debug
            console.log("W (inch):", W);
            console.log("H (inch):", H);
            console.log("Ukuran (m²):", ukuran);
            console.log("Denier:", denier);

            denierElem.value = Math.round(denier);
        }

        // Fungsi daftarkan listener untuk Denier
        function registerDenierListener(no) {
            const inputs = [
                `input[name="dimensi[${no}][l_nilai_outer]"]`,
                `input[name="dimensi[${no}][p_nilai_outer]"]`,
                `input[name="mesh[${no}][alas]"]`,
                `input[name="mesh[${no}][tinggi]"]`,
                `input[name="berat[${no}][outer]"]`
            ];

            inputs.forEach(selector => {
                const element = document.querySelector(selector);
                if (element) {
                    element.addEventListener('input', () => hitungDenier(no));
                }
            });
        }

        // Fungsi tambah baris (sudah diperbarui)
        function tambahBaris() {
            const tabelIDs = ['dimensi', 'berat', 'tebal', 'mesh', 'denier'];
            const tbodyDimensi = document.querySelector('#table-dimensi tbody');
            const no = tbodyDimensi.rows.length + 1;

            // DIMENSI
            tbodyDimensi.insertAdjacentHTML('beforeend', `
        <tr>
            <td>${no}</td>
            <td><input type="number" step="any" name="dimensi[${no}][p_nilai_outer]" class="form-control" required></td>

            <td><input type="number" step="any" name="dimensi[${no}][l_nilai_outer]" class="form-control" required></td>

            <td><input type="number" step="any" name="dimensi[${no}][p_nilai_inner]" class="form-control" required></td>

            <td><input type="number" step="any" name="dimensi[${no}][l_nilai_inner]" class="form-control" required></td>

        </tr>`);

            // BERAT
            document.querySelector('#table-berat tbody').insertAdjacentHTML('beforeend', `
        <tr>
            <td>${no}</td>
            <td><input type="number" step="any" name="berat[${no}][outer]" class="form-control" required></td>

            <td><input type="number" step="any" name="berat[${no}][inner]" class="form-control" required></td>

        </tr>`);

            // TEBAL
            document.querySelector('#table-tebal tbody').insertAdjacentHTML('beforeend', `
        <tr>
            <td>${no}</td>
            <td><input type="number" step="any" name="tebal[${no}][raw_outer]" class="form-control" required></td>
            <td><input type="number" step="any" name="tebal[${no}][outer]" class="form-control" readonly required></td>

            <td><input type="number" step="any" name="tebal[${no}][raw_inner]" class="form-control" required></td>
            <td><input type="number" step="any" name="tebal[${no}][inner]" class="form-control" readonly required></td>

        </tr>`);

            // MESH
            document.querySelector('#table-mesh tbody').insertAdjacentHTML('beforeend', `
        <tr>
            <td>${no}</td>
            <td><input type="number" step="any" name="mesh[${no}][alas]" class="form-control" required></td>

            <td><input type="number" step="any" name="mesh[${no}][tinggi]" class="form-control" required></td>

        </tr>`);

            // DENIER
            document.querySelector('#table-denier tbody').insertAdjacentHTML('beforeend', `
        <tr>
            <td>${no}</td>
            <td><input type="number" step="any" name="denier[${no}][nilai]" class="form-control" required readonly></td>

        </tr>`);

            // Daftarkan listener
            registerTebalListener(no);
            registerDenierListener(no); // 🔥 Penting: hitung Denier otomatis
            updateNomorDanName();
        }

        // Fungsi hapus baris terakhir
        function hapusBarisTerakhir() {
            const tabelIDs = ['dimensi', 'berat', 'tebal', 'mesh', 'denier'];
            tabelIDs.forEach(function(id) {
                const tbody = document.querySelector(`#table-${id} tbody`);
                if (tbody && tbody.rows.length > 0) {
                    tbody.deleteRow(tbody.rows.length - 1);
                }
            });
            updateNomorDanName();
        }

        // Fungsi update nomor dan name input
        function updateNomorDanName() {
            const tabels = {
                dimensi: ['p_nilai_outer', 'l_nilai_outer', 'p_nilai_inner', 'l_nilai_inner'],
                berat: ['outer', 'inner'],
                tebal: ['raw_outer', 'outer', 'raw_inner', 'inner'],
                mesh: ['alas', 'tinggi'],
                denier: ['nilai']
            };
            for (const [key, fields] of Object.entries(tabels)) {
                const rows = document.querySelectorAll(`#table-${key} tbody tr`);
                rows.forEach((row, index) => {
                    const no = index + 1;
                    row.children[0].textContent = no;
                    const inputs = row.querySelectorAll('input');
                    inputs.forEach((input, i) => {
                        input.name = `${key}[${no}][${fields[i]}]`;
                    });
                });
            }
        }

        // Listener untuk tebal (sudah ada)
        function registerTebalListener(no) {
            const rawOuter = document.querySelector(`input[name="tebal[${no}][raw_outer]"]`);
            const rawInner = document.querySelector(`input[name="tebal[${no}][raw_inner]"]`);
            const hasilOuter = document.querySelector(`input[name="tebal[${no}][outer]"]`);
            const hasilInner = document.querySelector(`input[name="tebal[${no}][inner]"]`);

            if (rawOuter) {
                rawOuter.addEventListener('input', () => {
                    const val = parseFloat(rawOuter.value);
                    hasilOuter.value = isNaN(val) ? '' : (val / 8).toFixed(3);
                });
            }
            if (rawInner) {
                rawInner.addEventListener('input', () => {
                    const val = parseFloat(rawInner.value);
                    hasilInner.value = isNaN(val) ? '' : (val / 8).toFixed(3);
                });
            }
        }

        // Fungsi cetak laporan
        function cetakLaporan() {
            const test_date = document.getElementById('test_date').value;
            const arrival_date = document.getElementById('arrival_date').value;
            const batch = document.getElementById('batch').value;
            if (test_date && arrival_date) {
                const baseUrl = "{{ url('uji_karung') }}";
                const finalUrl = `${baseUrl}/${test_date}/${arrival_date}/${batch}`;
                window.open(finalUrl, '_blank');
            } else {
                alert('Silakan pilih test_date uji, test_date arrival_date & batch terlebih dahulu.');
            }
        }

        // Fungsi reset data
        function resetData() {
            const test_date = document.getElementById('test_date').value;
            const arrival_date = document.getElementById('arrival_date').value;
            const batch = document.getElementById('batch').value;
            if (test_date && arrival_date) {
                const url = "{{ url('uji_karung-reset') }}/" + test_date + "/" + arrival_date + "/" + batch;
                if (confirm('Yakin ingin me-reset data uji karung untuk test_date ini?')) {
                    window.location.href = url;
                }
            } else {
                alert('Silakan pilih test_date uji, test_date arrival_date & batch terlebih dahulu.');
            }
        }

        // Tambah baris pertama saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            tambahBaris(); // Tambah 1 baris awal
        });
    </script>
@endsection
