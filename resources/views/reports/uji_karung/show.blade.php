<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Sistem Informasi Laboratorium PG Kebon Agung</title>
    <link rel="icon" type="image/png" href="/admin_template/img/QC.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    @php
        if (!function_exists('formatTanggalIndonesia')) {
            function formatTanggalIndonesia($tanggal)
            {
                $bulanIndo = [
                    '01' => 'Januari',
                    '02' => 'Februari',
                    '03' => 'Maret',
                    '04' => 'April',
                    '05' => 'Mei',
                    '06' => 'Juni',
                    '07' => 'Juli',
                    '08' => 'Agustus',
                    '09' => 'September',
                    '10' => 'Oktober',
                    '11' => 'November',
                    '12' => 'Desember',
                ];

                $parts = explode('-', $tanggal); // [2025, 05, 17]
                $tahun = $parts[0];
                $bulan = $bulanIndo[$parts[1]];
                $hari = $parts[2];

                return ltrim($hari, '0') . ' ' . $bulan . ' ' . $tahun;
            }
        }
    @endphp
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: "Times New Roman", Times, serif;
        }

        .a4-container {
            /* width: 794px;    */
            width: 900px;
            /* Lebar A4 px */
            height: 1123px;
            /* Tinggi A4 px */
            margin: 20px auto;
            background-image: url('/admin_template/img/master_kop_page-0001.jpg');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: top center;
            position: relative;
        }

        .content {
            position: absolute;
            top: 150px;
            /* posisi naik dari 220px */
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 700px;
            color: black;
            font-size: 12px;
            /* font kecil */
        }

        /* Judul section */
        .title-section h2,
        .title-section h3 {
            text-align: center;
            color: blue;
            margin: 0;
        }

        .title-section h2 {
            font-size: 18px;
            font-weight: normal;
        }

        .title-section h3 {
            font-style: italic;
            font-size: 15px;
            margin-top: 5px;
            margin-bottom: 30px;
        }

        .info-row {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 2px;
            /* persempit margin bawah */
            font-size: 16px;
            margin-left: 30px;
            /* Tambahkan margin kiri */
        }

        .info-subnote {
            margin: 0 0 10px 0;
            /* HAPUS margin-left 20px */
            font-size: 14px;
            font-style: italic;
            color: #333;
            margin-left: 30px;
            /* Tambahkan margin kiri */
            margin-bottom: 2px;
            /* persempit margin bawah */
        }

        .info-label {
            width: 150px;
            font-weight: bold;
            margin-bottom: 2px;
            /* persempit margin bawah */
        }

        .info-value {
            flex-grow: 1;
            margin-bottom: 2px;
            /* persempit margin bawah */
        }

        /* Section HASIL, pos absolute supaya menimpa background juga */
        .hasil-section {
            position: absolute;
            top: 400px;
            /* sesuaikan posisi vertikal agar tidak bertumpuk dengan content sebelumnya */
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 700px;
            color: black;
            font-family: "Times New Roman", Times, serif;
            font-size: 16px;
            margin-left: 30px;
            /* Tambahkan margin kiri */
        }

        .hasil-section h2 {
            text-align: center;
            letter-spacing: 10px;
            margin-bottom: 8px;
            font-size: 26px;
            margin-left: 30px;
            /* Tambahkan margin kiri */
            padding: 1px;
            /* padding 1 untuk semua sel */
        }

        .hasil-section table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            text-align: center;
            padding: 1px;
            /* padding 1 untuk semua sel */
        }

        .hasil-section table th,
        .hasil-section table td {
            border: 1px solid black;
            padding: 1px;
            /* padding 1 untuk semua sel */
        }

        .hasil-section table td:first-child,
        .hasil-section table th:first-child {
            width: 40px;
            text-align: center;
            padding: 1px;
            /* padding 1 untuk semua sel */
        }

        .hasil-section table td:nth-child(2),
        .hasil-section table th:nth-child(2) {
            text-align: center;
            padding: 1px;
            /* padding 1 untuk semua sel */
        }

        .hasil-section p {
            margin: 10px 0 0 0;
            padding: 1px;
            /* padding 1 untuk semua sel */
        }

        .hasil-section p.result-text {
            font-style: italic;
            text-align: center;
            margin-top: 8px;
            font-weight: normal;
            padding: 1px;
            /* padding 1 untuk semua sel */
        }

        .hasil-section p.note {
            margin-top: 30px;
            font-style: italic;
            padding: 1px;
            /* padding 1 untuk semua sel */
        }
    </style>
</head>

<body>

    <div class="a4-container">
        <div class="content">
            <div class="title-section">
                <br>
                <h2 style="margin-bottom: 0px;">
                    <u>HASIL ANALISA PEMERIKSAAN BAHAN KEMASAN</u>
                </h2>
                <h3 style="margin-top: 0px; font-style: italic;">
                    RESULTS OF PACKAGING MATERIAL ANALYSIS
                </h3>

            </div>

            <div class="info-row">
                <div class="info-label">No.</div>
                <div class="info-value">:
                    No. KBA/FRM/QCT/50
                    {{-- {{ $request->nomor_dokumen }} --}}
                </div>
            </div>
            <p class="info-subnote">No</p>

            <div class="info-row">
                <div class="info-label">Jenis</div>
                <div class="info-value">: Karung & Inner</div>
            </div>
            <p class="info-subnote">Type</p>

            <div class="info-row">
                <div class="info-label">Tanggal Kedatangan</div>
                <div class="info-value">: @php echo formatTanggalIndonesia($request->arrival_date); @endphp / Batch : {{ $request->batch }}</div>
            </div>
            <p class="info-subnote">Date of received</p>

            <div class="info-row">
                <div class="info-label">Tanggal Pengujian</div>
                <div class="info-value">: @php echo formatTanggalIndonesia($request->test_date); @endphp</div>
            </div>
            <p class="info-subnote">Date of analysis</p>
        </div>

        <!-- Section HASIL -->
        <section class="hasil-section">
            <br><br>
            <h5 style="font-size: 12px; font-weight: bold; text-decoration: underline; margin: 0; text-align:center;">
                HASIL</h5>
            <h5 style="font-size: 12px; font-weight: bold; font-style: italic; margin: 0; text-align:center;">RESULT
            </h5>
            <br>

            <div class="row">

                <!-- I. Panjang dan Lebar Karung -->
                <div class="col-12">
                    <h5 class="mb-3">I. Panjang dan Lebar Karung (Cm)</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-secondary">
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th colspan="4">Outer</th>
                                    <th colspan="4">Inner</th>
                                </tr>
                                <tr>
                                    <th colspan="2">P<sub>(97)</sub></th>
                                    <th colspan="2">L<sub>(57)</sub></th>
                                    <th colspan="2">P<sub>(110)</sub></th>
                                    <th colspan="2">L<sub>(60)</sub></th>
                                </tr>
                                {{-- <tr>
                                <th>Std</th>
                                <th>97</th>
                                <th>Ket</th>
                                <th>57</th>
                                <th>Ket</th>
                                <th>110</th>
                                <th>Ket</th>
                                <th>60</th>
                                <th>Ket</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->p_nilai_outer }}</td>
                                        <td>{{ $item->p_ket_outer == 1 ? '✓' : '✗' }}</td>
                                        <td>{{ $item->l_nilai_outer }}</td>
                                        <td>{{ $item->l_ket_outer == 1 ? '✓' : '✗' }}</td>
                                        <td>{{ $item->p_nilai_inner }}</td>
                                        <td>{{ $item->p_ket_inner == 1 ? '✓' : '✗' }}</td>
                                        <td>{{ $item->l_nilai_inner }}</td>
                                        <td>{{ $item->l_ket_inner == 1 ? '✓' : '✗' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-warning">
                            <tr>
                                <td style="font-size:13px;">SD</td>
                                <td>{{ $statistik['p_nilai_outer']['stddev'] }}</td>
                                <td></td>
                                <td>{{ $statistik['l_nilai_outer']['stddev'] }}</td>
                                <td></td>
                                <td>{{ $statistik['p_nilai_inner']['stddev'] }}</td>
                                <td></td>
                                <td>{{ $statistik['l_nilai_inner']['stddev'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size:13px;">Sesuai</td>
                                <td>{{ $statistik['p_nilai_outer']['sesuai'] }}</td>
                                <td></td>
                                <td>{{ $statistik['l_nilai_outer']['sesuai'] }}</td>
                                <td></td>
                                <td>{{ $statistik['p_nilai_inner']['sesuai'] }}</td>
                                <td></td>
                                <td>{{ $statistik['l_nilai_inner']['sesuai'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size:9px;">Tidak Sesuai</td>
                                <td>{{ $statistik['p_nilai_outer']['tidak_sesuai'] }}</td>
                                <td></td>
                                <td>{{ $statistik['l_nilai_outer']['tidak_sesuai'] }}</td>
                                <td></td>
                                <td>{{ $statistik['p_nilai_inner']['tidak_sesuai'] }}</td>
                                <td></td>
                                <td>{{ $statistik['l_nilai_inner']['tidak_sesuai'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>%</td>
                                <td>{{ $statistik['p_nilai_outer']['persen_kesesuaian'] }}%</td>
                                <td></td>
                                <td>{{ $statistik['l_nilai_outer']['persen_kesesuaian'] }}%</td>
                                <td></td>
                                <td>{{ $statistik['p_nilai_inner']['persen_kesesuaian'] }}%</td>
                                <td></td>
                                <td>{{ $statistik['l_nilai_inner']['persen_kesesuaian'] }}%</td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- II. Berat Karung -->
                <div class="col-6">
                    <h5 class="mb-3">II. Berat Karung (Gram)</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-secondary">
                                <tr>
                                    <th>No</th>
                                    <th colspan="2">Outer</th>
                                    <th colspan="2">Inner</th>
                                </tr>
                                <tr>
                                    <th>Std</th>
                                    <th>110</th>
                                    <th>Ket</th>
                                    <th>36</th>
                                    <th>Ket</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->berat_outer }}</td>
                                        <td>{{ $item->berat_outer_ket == 1 ? '✓' : '✗' }}</td>
                                        <td>{{ $item->berat_inner }}</td>
                                        <td>{{ $item->berat_inner_ket == 1 ? '✓' : '✗' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-warning">
                            <tr>
                                <td style="font-size:13px;">SD</td>
                                <td>{{ $statistik['berat_outer']['stddev'] }}</td>
                                <td></td>
                                <td>{{ $statistik['berat_inner']['stddev'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size:13px;">Sesuai</td>
                                <td>{{ $statistik['berat_outer']['sesuai'] }}</td>
                                <td></td>
                                <td>{{ $statistik['berat_inner']['sesuai'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size:9px;">Tidak Sesuai</td>
                                <td>{{ $statistik['berat_outer']['tidak_sesuai'] }}</td>
                                <td></td>
                                <td>{{ $statistik['berat_inner']['tidak_sesuai'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>%</td>
                                <td>{{ $statistik['berat_outer']['persen_kesesuaian'] }}%</td>
                                <td></td>
                                <td>{{ $statistik['berat_inner']['persen_kesesuaian'] }}%</td>
                                <td></td>
                            </tr>
                        </tfoot>
                        </table>
                    </div>
                </div>

                <!-- III. Tebal Karung -->
                <div class="col-6">
                    <h5 class="mb-3">III. Tebal Karung (mm)</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-secondary">
                                <tr>
                                    <th>No</th>
                                    <th colspan="2">Outer</th>
                                    <th colspan="2">Inner</th>
                                </tr>
                                <tr>
                                    <th>Std</th>
                                    <th>0.175</th>
                                    <th>Ket</th>
                                    <th>0.03</th>
                                    <th>Ket</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tebal_outer }}</td>
                                        <td>{{ $item->tebal_outer_ket == 1 ? '✓' : '✗' }}</td>
                                        <td>{{ $item->tebal_inner }}</td>
                                        <td>{{ $item->tebal_inner_ket == 1 ? '✓' : '✗' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-warning">
                            <tr>
                                <td style="font-size:13px;">SD</td>
                                <td>{{ $statistik['tebal_outer']['stddev'] }}</td>
                                <td></td>
                                <td>{{ $statistik['tebal_inner']['stddev'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size:13px;">Sesuai</td>
                                <td>{{ $statistik['tebal_outer']['sesuai'] }}</td>
                                <td></td>
                                <td>{{ $statistik['tebal_inner']['sesuai'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size:9px;">Tidak Sesuai</td>
                                <td>{{ $statistik['tebal_outer']['tidak_sesuai'] }}</td>
                                <td></td>
                                <td>{{ $statistik['tebal_inner']['tidak_sesuai'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>%</td>
                                <td>{{ $statistik['tebal_outer']['persen_kesesuaian'] }}%</td>
                                <td></td>
                                <td>{{ $statistik['tebal_inner']['persen_kesesuaian'] }}%</td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- IV. Anyaman / Mesh -->
                <div class="col-6">
                    <br><br>
                    <h5 class="mb-3">IV. Anyaman / Mesh Karung</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-secondary">
                                <tr>
                                    <th>No</th>
                                    <th colspan="2">Alas</th>
                                    <th colspan="2">Tinggi</th>
                                </tr>
                                <tr>
                                    <th>Std</th>
                                    <th>12</th>
                                    <th>Ket</th>
                                    <th>12</th>
                                    <th>Ket</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->mesh_alas }}</td>
                                        <td>{{ $item->mesh_ket_alas == 1 ? '✓' : '✗' }}</td>
                                        <td>{{ $item->mesh_tinggi }}</td>
                                        <td>{{ $item->mesh_ket_tinggi == 1 ? '✓' : '✗' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-warning">
                            <tr>
                                <td style="font-size:13px;">SD</td>
                                <td>{{ $statistik['mesh_alas']['stddev'] }}</td>
                                <td></td>
                                <td>{{ $statistik['mesh_tinggi']['stddev'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size:13px;">Sesuai</td>
                                <td>{{ $statistik['mesh_alas']['sesuai'] }}</td>
                                <td></td>
                                <td>{{ $statistik['mesh_tinggi']['sesuai'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size:9px;">Tidak Sesuai</td>
                                <td>{{ $statistik['mesh_alas']['tidak_sesuai'] }}</td>
                                <td></td>
                                <td>{{ $statistik['mesh_tinggi']['tidak_sesuai'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>%</td>
                                <td>{{ $statistik['mesh_alas']['persen_kesesuaian'] }}%</td>
                                <td></td>
                                <td>{{ $statistik['mesh_tinggi']['persen_kesesuaian'] }}%</td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- V. Denier -->
                <div class="col-6">
                    <br><br>
                    <h5 class="mb-3">V. Denier (D)</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-secondary">
                                <tr>
                                    <th>No</th>
                                    <th colspan="2">Denier</th>
                                </tr>
                                <tr>
                                    <th>Std</th>
                                    <th>900</th>
                                    <th>Ket</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->denier_nilai }}</td>
                                        <td>{{ $item->denier_ket == 1 ? '✓' : '✗' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-warning">
                            <tr>
                                <td style="font-size:13px;">SD</td>
                                <td>{{ $statistik['denier_nilai']['stddev'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size:13px;">Sesuai</td>
                                <td>{{ $statistik['denier_nilai']['sesuai'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size:9px;">Tidak Sesuai</td>
                                <td>{{ $statistik['denier_nilai']['tidak_sesuai'] }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>%</td>
                                <td>{{ $statistik['denier_nilai']['persen_kesesuaian'] }}%</td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>

            {{-- <p><strong>Method of Test :</strong> Complexometric</p> --}}

            <p class="note">
                <strong>Catatan :</strong> Hasil analisa hanya berdasarkan sampel yang diterima<br>
                <strong>Notice :</strong> This report is based on testing sample only
            </p>



            <div
                style="width: 100%; text-align: right; margin-top: 60px; font-size: 16px; font-family: 'Times New Roman', Times, serif;">
                <p style="margin: 0;">Malang, @php echo formatTanggalIndonesia(date('Y-m-d')); @endphp</p>
                <br><br><br><br><br><br>
                {{-- <p style="margin: 0; font-weight: bold;"><u>Tri Sunu Hardi</u></p> --}}
                <p style="margin: 0;">Kasubsie / Kasie Pabrikasi</p>
            </div>
        </section>


    </div>

</body>

</html>
