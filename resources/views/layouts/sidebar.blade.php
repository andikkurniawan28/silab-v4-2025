<ul class="navbar-nav bg-gradient-light sidebar sidebar-light accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            <img src="/Silab-v3/public/admin_template/img/QC.png" width="50" height="50" alt="Logo QC">
        </div>
        <div class="sidebar-brand-text mx-3">SILAB</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="{{ route("home") }}">
        <i class="fas fa-fw fa-home"></i>
        <span>Home</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route("dashboard") }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    @if(Auth()->user()->role_id <= 9)
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('monitoring_select_date') }}" target="_blank">
        <i class="fas fa-fw fa-eye"></i>
        <span>Monitoring</span></a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('monitoring_2024.index', 2) }}" target="_blank">
        <i class="fas fa-fw fa-eye"></i>
        <span>Monitoring 2024</span></a>
    </li>
    @endif

    @if(Auth()->user()->role_id <= 9)
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities3" aria-expanded="true" aria-controls="collapseUtilities3">
            <i class="fas fa-fw fa-balance-scale"></i>
            <span>Timbangan per Jam</span>
        </a>
        <div id="collapseUtilities3" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu :</h6>
                <a class="collapse-item" href="{{ route("timbangan_per_jam", 1) }}" target="_blank">RS In</a>
                <a class="collapse-item" href="{{ route("timbangan_per_jam", 2) }}" target="_blank">RS Out</a>
                <a class="collapse-item" href="{{ route("timbangan_per_jam", 3) }}" target="_blank">Tetes</a>
                {{-- <a class="collapse-item" href="{{ route("timbangan_per_jam", 4) }}" target="_blank">Conveyor</a> --}}
            </div>
        </div>
    </li>
    @endif

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="true" aria-controls="collapseUtilities2">
            <i class="fas fa-fw fa-folder-open"></i>
            <span>Hasil Analisa</span>
        </a>
        <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu :</h6>
                @foreach($stations as $station)
                    <a class="collapse-item" href="{{ route('station_result', $station->id) }}">{{ $station->name }}</a>
                @endforeach
                <a class="collapse-item" href="{{ route('rekap_turbidity') }}">Rekap Turbidity</a>
            </div>
        </div>
    </li>

    @if(Auth()->user()->role_id <= 8)

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#cetak_barcode" aria-expanded="true" aria-controls="cetak_barcode">
            <i class="fas fa-fw fa-barcode"></i>
            <span>Cetak Barcode</span>
        </a>
        <div id="cetak_barcode" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu :</h6>
                @foreach($stations as $station)
                    <a class="collapse-item" href="{{ route('cetak_barcode_by_category', $station->id) }}">{{ $station->name }}</a>
                @endforeach
                <a class="collapse-item" href="{{ route('cetak_barcode_analisa_pendahuluan.index') }}">{{ "Analisa Pendahuluan" }}</a>
            </div>
        </div>
    </li>

    @endif

    @if(Auth()->user()->role_id <= 9)

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-edit"></i>
            <span>Input Data Off Farm</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu :</h6>
                @if(Auth()->user()->role_id < 9)

                {{-- @if(Auth()->user()->role_id <= 8)
                <a class="collapse-item" href="{{ route('cetak_barcode') }}">Cetak Barcode</a>
                @endif --}}

                <a class="collapse-item" href="{{ route('analisa_off_farm.index') }}">Analisa</a>
                <a class="collapse-item" href="{{ route('analysis_unverified') }}">Verifikasi Mandor</a>
                {{-- <a class="collapse-item" href="{{ route('analyses.index') }}">Analisa</a>
                <a class="collapse-item" href="{{ route('saccharomat') }}">Saccharomat</a>
                <a class="collapse-item" href="{{ route('analisa_ampas') }}">Analisa Ampas</a>
                <a class="collapse-item" href="{{ route('analisa_umum') }}">Analisa Umum</a>
                <a class="collapse-item" href="{{ route('analisa_ketel') }}">Analisa Ketel</a>
                <a class="collapse-item" href="{{ route('analisa_hplc') }}">Analisa HPLC</a>
                <a class="collapse-item" href="{{ route('analisa_so2.index') }}">Analisa SO2</a>
                <a class="collapse-item" href="{{ route('analisa_cao.index') }}">Analisa CaO</a>
                <a class="collapse-item" href="{{ route('analisa_bjb.index') }}">Analisa BJB</a> --}}
                <a class="collapse-item" href="{{ route('balances.index') }}">Flow NM</a>
                <a class="collapse-item" href="{{ route('kactivities.index') }}">Keliling Proses</a>
                <a class="collapse-item" href="{{ route('chemicalcheckings.index') }}">Pengunaan BPP</a>
                <a class="collapse-item" href="{{ route('product50s.index') }}">Produk 50Kg</a>
                @endif

                <a class="collapse-item" href="{{ route('cetak_ronsel') }}">Cetak Ronsel</a>
                <a class="collapse-item" href="{{ route('tactivities.index') }}">Taksasi</a>
                <a class="collapse-item" href="{{ route('imbibitions.index') }}">Imbibisi</a>

                @if(Auth()->user()->role_id <= 6)
                <a class="collapse-item" href="{{ route('mollases.index') }}">Timbangan Tetes</a>
                <a class="collapse-item" href="{{ route('rawsugarinputs.index') }}">Timbangan RS In</a>
                <a class="collapse-item" href="{{ route('rawsugaroutputs.index') }}">Timbangan RS Out</a>
                <a class="collapse-item" href="{{ route('conveyor_sugars.index') }}">Conveyor Utara</a>
                @endif
            </div>
        </div>
    </li>
    @endif

    @if(Auth()->user()->role_id < 9)
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities1" aria-expanded="true" aria-controls="collapseUtilities1">
            <i class="fas fa-fw fa-edit"></i>
            <span>Input Data On Farm</span>
        </a>
        <div id="collapseUtilities1" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu :</h6>
                {{-- <a class="collapse-item" href="{{ route('posbrixes.index') }}">Pos Brix</a> --}}
                {{-- <a class="collapse-item" href="{{ route('rits.index') }}">Penerimaan</a> --}}
                {{-- <a class="collapse-item" href="{{ route('ari_samplings.index') }}">Sampling ARI</a> --}}
                {{-- <a class="collapse-item" href="{{ route('core_samples.index') }}">ARI Core Sample</a> --}}
                {{-- <a class="collapse-item" href="{{ route('aris.index') }}">ARI Gil Mini</a> --}}
                {{-- <a class="collapse-item" href="{{ route('core_samples.index') }}">Core Sample</a> --}}
                {{-- <a class="collapse-item" href="{{ route('scores.index') }}">Scoring</a> --}}
                {{-- <a class="collapse-item" href="{{ route('scoring_values.index') }}">Penilaian Kotoran</a> --}}
                {{-- <a class="collapse-item" href="{{ route('kartu_cores.index') }}">Gelas Core</a> --}}
                {{-- <a class="collapse-item" href="{{ route('gelas_core_ek.index') }}">Antrian Gelas Core EK</a>
                <a class="collapse-item" href="{{ route('gelas_core_eb.index') }}">Antrian Gelas Core EB</a> --}}
                <a class="collapse-item" href="{{ route('gelas_ari_ek.index') }}">Antrian Gelas ARI EK</a>
                <a class="collapse-item" href="{{ route('gelas_ari_eb.index') }}">Antrian Gelas ARI EB</a>
                {{-- <a class="collapse-item" href="{{ route('posbrix_2024_resource.index') }}">Posbrix</a>
                <a class="collapse-item" href="{{ route('core_sample_2024.index') }}">Core Sample</a>
                <a class="collapse-item" href="{{ route('core_sample_belum_teranalisa.render') }}">Belum Teranalisa</a> --}}
                <a class="collapse-item" href="{{ route('ari_2024.index') }}">Analisa Rendemen Individu</a>
                <a class="collapse-item" href="{{ route('ari_belum_teranalisa.render') }}">ARI Belum Teranalisa</a>
                <a class="collapse-item" href="{{ route('penilaian_mbs_2024.index') }}">Penilaian MBS</a>
                <a class="collapse-item" href="{{ route('analisa_pendahuluan.index') }}">Analisa Pendahuluan</a>
                <a class="collapse-item" href="{{ route('master_on_farm.render') }}">Master On Farm</a>
                <a class="collapse-item" href="{{ route('master_on_farm_2024.render') }}">Master On Farm 2024</a>
                <a class="collapse-item" href="{{ route('scoring', date("Y-m-d")) }}">Scoring Reward Punishment</a>
                {{-- <a class="collapse-item" href="{{ route('laporan_ko.index') }}">Laporan KO</a>
                <a class="collapse-item" href="{{ route('new_spta') }}">New SPTA</a> --}}
            </div>
        </div>
    </li>
    @endif

    @if(Auth()->user()->role_id <= 7)
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-fw fa-file-signature"></i>
            <span>Laporan</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu :</h6>
                    <a class="collapse-item" href="{{ route('report') }}">Cetak Laporan</a>
                    <a class="collapse-item" href="{{ route('cetak_laporan_mandor') }}">Laporan Mandor</a>
                    {{-- <a class="collapse-item" href="{{ route('rendemen_harians.index') }}">Rendemen Harian</a> --}}
                    {{-- <a class="collapse-item" href="{{ route('laporan_posbrix.index') }}">Laporan Posbrix</a> --}}
                    {{-- <a class="collapse-item" href="{{ route('laporan_core_sample.index') }}">Laporan Core Sample</a> --}}
                    <a class="collapse-item" href="{{ route('laporan_analisa_rendemen.index') }}">Laporan ARI</a>
                    <a class="collapse-item" href="{{ route('laporan_penilaian_mbs.index') }}">Laporan MBS</a>
                    @if(Auth()->user()->role_id <= 5)
                    <a class="collapse-item" href="{{ route('adjust_ari') }}">Adjust Core Sample</a>
                    @endif
                    {{-- <a class="collapse-item" href="{{ route('coas.index') }}">Certificate of Analysis</a> --}}
                    <a class="collapse-item" href="{{ route('coa_tetes.index') }}">COA Tetes</a>
                    {{-- <a class="collapse-item" href="{{ route('coa_gula_r1.index') }}">COA Gula R1</a>
                    <a class="collapse-item" href="{{ route('coa_kapur.index') }}">COA Kapur</a> --}}
            </div>
        </div>
    </li>
    @endif

    @if(Auth()->user()->role_id <= 8)
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
            <i class="fas fa-fw fa-mobile"></i>
            <span>Aplikasi</span>
        </a>
        <div id="collapse2" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu :</h6>
                {{-- @for($i=1; $i<=5; $i++)
                <a class="collapse-item" href="{{ route('posbrix_single_action.index', $i) }}" target="_blank">Posbrix Core {{ $i }}</a>
                @endfor --}}
                <?php /*
                @for($i=1; $i<=5; $i++)
                <a class="collapse-item" href="{{ route('posbrix_2024.index', $i) }}" target="_blank">Posbrix Core {{ $i }}</a>
                @endfor
                */ ?>
                {{-- <a class="collapse-item" href="{{ route('posbrix_magersari') }}" target="_blank">Posbrix Portable</a> --}}
                {{-- @for($i=1; $i<=5; $i++)
                <a class="collapse-item" href="{{ route('posbrix_magersari.core_sample', $i) }}" target="_blank">Core Sample {{ $i }}</a>
                @endfor --}}
                @for($i=1; $i<=4; $i++)
                <a class="collapse-item" href="{{ route('posbrix_magersari.ari', $i) }}" target="_blank">ARI {{ $i }}</a>
                @endfor
                {{-- <a class="collapse-item" href="{{ route('meja_utara') }}">{{ ucwords("meja utara") }}</a> --}}
                <a class="collapse-item" href="{{ route('meja_selatan') }}" target="_blank">{{ ucwords("penilaian tebu") }}</a>
                {{-- <a class="collapse-item" href="{{ route('syncSpta') }}" target="_blank">{{ ucwords("syncSpta") }}</a>
                <a class="collapse-item" href="{{ route('sync_npp', 5) }}" target="_blank">{{ ucwords("syncNpp") }}</a>
                <a class="collapse-item" href="{{ route('sync_all') }}" target="_blank">{{ ucwords("sync_all") }}</a>
                <a class="collapse-item" href="{{ route('sync_off_farm') }}" target="_blank">{{ ucwords("sync_off_farm") }}</a> --}}
                {{-- <a class="collapse-item" href="{{ route('sync_all') }}" target="_blank">{{ ucwords("sync_all") }}</a> --}}
                {{-- <a class="collapse-item" href="{{ route('sync_npp', 10) }}" target="_blank">{{ ucwords("syncNpp") }} 10 Menit</a> --}}
                {{-- <a class="collapse-item" href="{{ route('scan_rfid_core_sample_ek') }}" target="_blank">Pos Brix Core</a> --}}
                {{-- <a class="collapse-item" href="{{ route('scan_rfid_core_sample_eb') }}" target="_blank">Pos Brix EB/GD Core 2</a> --}}
                {{-- <a class="collapse-item" href="{{ route('scan_rfid') }}" target="_blank">Pos Brix EK</a>
                <a class="collapse-item" href="{{ route('scan_rfid_eb') }}" target="_blank">Pos Brix EB/GD</a>
                <a class="collapse-item" href="{{ route('tap_timbangan') }}" target="_blank">Tap Timbangan EK</a>
                <a class="collapse-item" href="{{ route('tap_timbangan_eb') }}" target="_blank">Tap Timbangan EB/GD</a>
                <a class="collapse-item" href="{{ route('tap_core_sampling') }}" target="_blank">Tap ARI Sampling</a> --}}
                {{-- <a class="collapse-item" href="{{ route('meja_selatan') }}" target="_blank">Penilaian Meja Selatan</a>
                <a class="collapse-item" href="{{ route('meja_utara') }}" target="_blank">Penilaian Meja Utara</a> --}}
                {{-- <a class="collapse-item" href="{{ route('view_ari') }}" target="_blank">Display Analisa Rendemen</a>
                <a class="collapse-item" href="{{ route('display_core_sample') }}" target="_blank">Display Core Sample</a>
                <a class="collapse-item" href="{{ route('view_arisampling') }}" target="_blank">Display Sampling</a>
                <a class="collapse-item" href="{{ route('display_ari_sampling2') }}" target="_blank">Display Sampling 2</a>
                <a class="collapse-item" href="{{ route('test_display_baru') }}" target="_blank">Display Sampling 3</a> --}}
                {{-- <a class="collapse-item" href="{{ route('view_timbangan') }}" target="_blank">Display Timbangan</a> --}}
                {{-- <a class="collapse-item" href="{{ route('view_onfarm', date('Y-m-d')) }}" target="_blank">Display On Farm</a>
                <a class="collapse-item" href="{{ route('find_result_by_identity') }}">Cari Data On Farm</a> --}}

            </div>
        </div>
    </li>
    @endif

    @if(Auth()->user()->role_id <= 9)
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaster" aria-expanded="true" aria-controls="collapseMaster">
            <i class="fas fa-fw fa-database"></i>
            <span>Master</span>
        </a>
        <div id="collapseMaster" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu :</h6>
                @if(Auth()->user()->role_id <= 1)
                    <a class="collapse-item" href="{{ route('users.index') }}">User</a>
                @endif

                @if(Auth()->user()->role_id <= 3)
                    <a class="collapse-item" href="{{ route('stations.index') }}">Stasiun</a>
                    <a class="collapse-item" href="{{ route('indicators.index') }}">Indikator</a>
                    <a class="collapse-item" href="{{ route('factors.index') }}">Faktor</a>
                @endif

                @if(Auth()->user()->role_id <= 4)
                    <a class="collapse-item" href="{{ route('dirts.index') }}">Kotoran</a>
                    <a class="collapse-item" href="{{ route('certificates.index') }}">Sertifikat</a>
                    <a class="collapse-item" href="{{ route('kuds.index') }}">KUD</a>
                    <a class="collapse-item" href="{{ route('pospantaus.index') }}">Pos Pantau</a>
                    <a class="collapse-item" href="{{ route('wilayahs.index') }}">Wilayah</a>
                    <a class="collapse-item" href="{{ route('varieties.index') }}">Varietas</a>
                    <a class="collapse-item" href="{{ route('kawalans.index') }}">Kawalan</a>
                @endif

                @if(Auth()->user()->role_id <= 7)
                    <a class="collapse-item" href="{{ route('materials.index') }}">Material</a>
                    <a class="collapse-item" href="{{ route('methods.index') }}">Method</a>
                    {{-- <a class="collapse-item" href="{{ route('certificate_contents.index') }}">Isi Sertifikat</a> --}}
                @endif

                @if(Auth()->user()->role_id <= 8)
                    <a class="collapse-item" href="{{ route('samples.index') }}">Sample (Barcode)</a>
                @endif

                @if(Auth()->user()->role_id <= 3)
                    <a class="collapse-item" href="{{ route('kspots.index') }}">Titik Keliling</a>
                    <a class="collapse-item" href="{{ route('tspots.index') }}">Titik Taksasi</a>
                @endif

                @if(Auth()->user()->role_id <= 4)
                    <a class="collapse-item" href="{{ route('chemicals.index') }}">Bahan Pembantu Proses</a>
                @endif
            </div>
        </div>
    </li>
    @endif

    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
