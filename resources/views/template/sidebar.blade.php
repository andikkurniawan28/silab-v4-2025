<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">
{{-- <ul class="navbar-nav bg-gradient-light sidebar sidebar-light accordion" id="accordionSidebar"> --}}

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-flask"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Silab</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @yield('dashboard-active')">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @if (Auth()->user()->role->akses_master)
        <!-- Nav Item - Master Collapse Menu -->
        <li
            class="nav-item
        @yield('roles-active')
        @yield('users-active')
        @yield('stations-active')
        @yield('units-active')
        @yield('parameters-active')
        @yield('materials-active')
        @yield('monitoring_hourly_spots-active')
        @yield('monitoring_shiftly_spots-active')
        @yield('estimation_spots-active')
        @yield('items-active')
        @yield('regions-active')
        @yield('impurities-active')
        @yield('varieties-active')
        @yield('kawalans-active')
        @yield('factors-active')
        @yield('flow_spots-active')
    ">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseMaster" aria-expanded="true"
                aria-controls="collapseMaster">
                <i class="fas fa-fw fa-database"></i>
                <span>Master</span>
            </a>
            <div id="collapseMaster"
                class="collapse
            @yield('roles-show')
            @yield('users-show')
            @yield('stations-show')
            @yield('units-show')
            @yield('parameters-show')
            @yield('materials-show')
            @yield('monitoring_hourly_spots-show')
            @yield('monitoring_shiftly_spots-show')
            @yield('estimation_spots-show')
            @yield('items-show')
            @yield('regions-show')
            @yield('impurities-show')
            @yield('varieties-show')
            @yield('kawalans-show')
            @yield('factors-show')
            @yield('flow_spots-show')
        "
                aria-labelledby="headingMaster" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">

                    <h6 class="collapse-header">Sub-Menu :</h6>

                    @if (Auth()->user()->role->akses_daftar_jabatan)
                        <a class="collapse-item
                    @yield('roles-active')"
                            href="{{ route('roles.index') }}">
                            Jabatan
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_user)
                        <a class="collapse-item
                    @yield('users-active')"
                            href="{{ route('users.index') }}">
                            User
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_stasiun)
                        <a class="collapse-item
                    @yield('stations-active')"
                            href="{{ route('stations.index') }}">
                            Stasiun
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_satuan)
                        <a class="collapse-item
                    @yield('units-active')"
                            href="{{ route('units.index') }}">
                            Satuan
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_parameter)
                        <a class="collapse-item
                    @yield('parameters-active')"
                            href="{{ route('parameters.index') }}">
                            Parameter
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_material)
                        <a class="collapse-item
                    @yield('materials-active')"
                            href="{{ route('materials.index') }}">
                            Material
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_titik_flow)
                        <a class="collapse-item
                    @yield('flow_spots-active')"
                            href="{{ route('flow_spots.index') }}">
                            Titik Flow
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_titik_monitoring_perjam)
                        <a class="collapse-item
                    @yield('monitoring_hourly_spots-active')"
                            href="{{ route('monitoring_hourly_spots.index') }}">
                            Titik Monitoring Perjam
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_titik_monitoring_pershift)
                        <a class="collapse-item
                    @yield('monitoring_shiftly_spots-active')"
                            href="{{ route('monitoring_shiftly_spots.index') }}">
                            Titik Monitoring Pershift
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_titik_taksasi)
                        <a class="collapse-item
                    @yield('estimation_spots-active')"
                            href="{{ route('estimation_spots.index') }}">
                            Titik Taksasi
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_barang)
                        <a class="collapse-item
                    @yield('items-active')"
                            href="{{ route('items.index') }}">
                            Barang
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_wilayah)
                        <a class="collapse-item
                    @yield('regions-active')"
                            href="{{ route('regions.index') }}">
                            Wilayah
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_kotoran_tebu)
                        <a class="collapse-item
                    @yield('impurities-active')"
                            href="{{ route('impurities.index') }}">
                            Kotoran Tebu
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_varietas_tebu)
                        <a class="collapse-item
                    @yield('varieties-active')"
                            href="{{ route('varieties.index') }}">
                            Varietas Tebu
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_kawalan_tebu)
                        <a class="collapse-item
                    @yield('kawalans-active')"
                            href="{{ route('kawalans.index') }}">
                            Kawalan Tebu
                        </a>
                    @endif

                    @if (Auth()->user()->role->akses_daftar_faktor)
                        <a class="collapse-item
                    @yield('factors-active')"
                            href="{{ route('factors.index') }}">
                            Faktor
                        </a>
                    @endif

                </div>
            </div>
        </li>
    @endif

    @if (Auth()->user()->role->akses_cetak_barcode || Auth()->user()->role->akses_daftar_barcode)
        <!-- Nav Item - BarcodePrinting Collapse Menu -->
        <li class="nav-item
        @yield('barcodePrinting-active')
    ">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseBarcodePrinting"
                aria-expanded="true" aria-controls="collapseBarcodePrinting">
                <i class="fas fa-fw fa-print"></i>
                <span>Barcode</span>
            </a>
            <div id="collapseBarcodePrinting" class="collapse
                @yield('barcodePrinting-show')
            "
                aria-labelledby="headingMaster" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">

                    <h6 class="collapse-header">Cetak Barcode :</h6>
                    @if (Auth()->user()->role->akses_cetak_barcode)
                        @foreach ($viewStation as $v)
                            <a class="collapse-item
                            @yield("barcodePrinting{$v->id}-active")"
                                href="{{ route('barcode_printing.index', $v->id) }}">
                                {{ $v->name }}
                            </a>
                        @endforeach
                    @endif

                    <h6 class="collapse-header">Barcode Tersimpan :</h6>
                    @if (Auth()->user()->role->akses_daftar_barcode)
                        <a class="collapse-item
                            @yield('barcode_printing.list-active')"
                            href="{{ route('barcode_printing.list') }}">
                            Daftar Barcode
                        </a>
                    @endif
                </div>
        </li>
    @endif

    @if (Auth()->user()->role->akses_input_data)
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#inputData"
                    aria-expanded="true" aria-controls="inputData">
                    <i class="fas fa-fw fa-edit"></i>
                    <span>Input Data</span>
                </a>
                <div id="inputData" class="collapse
                @yield('input-show')
                " aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Seputar Analisa :</h6>
                        @if (Auth()->user()->role->akses_daftar_analisa)
                        <a class="collapse-item @yield('analyses-active')" href="{{ route('analyses.index') }}">Analisa</a>
                        @endif
                        @if (Auth()->user()->role->akses_verifikasi_mandor)
                        <a class="collapse-item @yield('analysis_unverified-active')" href="{{ route('analysis_unverified.index') }}">Verifikasi Mandor</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_analisa_ampas_metode_panas)
                        <a class="collapse-item @yield('analisa_ampas_metode_panas-active')" href="{{ route('analisa_ampas_metode_panas.index') }}">Ampas Metode Panas</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_analisa_ampas_metode_dingin)
                        <a class="collapse-item @yield('analisa_ampas_metode_dingin-active')" href="{{ route('analisa_ampas_metode_dingin.index') }}">Ampas John Payne</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_analisa_ketel)
                        <a class="collapse-item @yield('analisa_ketel-active')" href="{{ route('analisa_ketel.index') }}">Analisa Ketel</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_analisa_cao)
                        <a class="collapse-item @yield('analisa_cao-active')" href="{{ route('analisa_cao.index') }}">Analisa CaO</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_analisa_so2)
                        <a class="collapse-item @yield('analisa_so2-active')" href="{{ route('analisa_so2.index') }}">Analisa SO<sub>2</sub></a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_analisa_bjb)
                        <a class="collapse-item @yield('analisa_bjb-active')" href="{{ route('analisa_bjb.index') }}">Analisa BJB</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_uji_karung)
                        <a class="collapse-item @yield('bag_tests-active')" href="{{ route('bag_tests.index') }}">Uji Karung</a>
                        @endif

                        <h6 class="collapse-header">Seputar Proses :</h6>
                        @if (Auth()->user()->role->akses_daftar_flow_nm)
                        <a class="collapse-item @yield('flow_nm-active')" href="{{ route('flow_nm.index') }}">Flow NM</a>
                        @endif
                        {{-- @if (Auth()->user()->role->akses_daftar_keliling_proses)
                        <a class="collapse-item @yield('keliling_proses-active')" href="{{ route('keliling_proses.index') }}">Keliling Proses</a>
                        @endif --}}
                        @if (Auth()->user()->role->akses_daftar_imbibisi)
                        <a class="collapse-item @yield('imbibisi-active')" href="{{ route('imbibisi.index') }}">Imbibisi</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_monitoring_perjam)
                        <a class="collapse-item @yield('monitoring_hourlies-active')" href="{{ route('monitoring_hourlies.index') }}">Monitoring Perjam</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_monitoring_pershift)
                        <a class="collapse-item @yield('monitoring_shiftlies-active')" href="{{ route('monitoring_shiftlies.index') }}">Monitoring Pershift</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_taksasi_proses)
                        <a class="collapse-item @yield('estimations-active')" href="{{ route('estimations.index') }}">Taksasi Proses</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_gula_dikarungi)
                        <a class="collapse-item @yield('sugar_baggings-active')" href="{{ route('sugar_baggings.index') }}">Gula Dikarungi</a>
                        @endif

                        <h6 class="collapse-header">Seputar Penyimpanan :</h6>
                        @if (Auth()->user()->role->akses_daftar_transaksi_stok)
                        <a class="collapse-item @yield('stock_transactions-active')" href="{{ route('stock_transactions.index') }}">Transaksi Stok</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_mutasi_stok)
                        <a class="collapse-item @yield('stock_transaction_details-active')" href="{{ route('stock_transaction_details.index') }}">Mutasi Stok</a>
                        @endif

                        <h6 class="collapse-header">Seputar On-Farm :</h6>
                        @if (Auth()->user()->role->akses_daftar_gelas_core)
                        <a class="collapse-item @yield('core_cards-active')" href="{{ route('core_cards.index') }}">Gelas Core</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_gelas_ari)
                        <a class="collapse-item @yield('ari_cards-active')" href="{{ route('ari_cards.index') }}">Gelas ARI</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_posbrix)
                        <a class="collapse-item @yield('posbrixes-active')" href="{{ route('posbrixes.index') }}">Posbrix</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_core_sample)
                        <a class="collapse-item @yield('core_samples-active')" href="{{ route('core_samples.index') }}">Core Sample</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_ari_timbangan)
                        <a class="collapse-item @yield('ari_timbangans-active')" href="{{ route('ari_timbangans.index') }}">ARI Timbangan</a>
                        @endif
                        @if (Auth()->user()->role->akses_daftar_penilaian_mbs)
                        <a class="collapse-item @yield('penilaian_mbss-active')" href="{{ route('penilaian_mbss.index') }}">Penilaian MBS</a>
                        @endif
                    </div>
                </div>
            </li>
    @endif

    {{-- <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
