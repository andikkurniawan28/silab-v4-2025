<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

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
        @yield('factors-active')
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
            @yield('factors-show')
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
                    <h6 class="collapse-header">Sub-Menu :</h6>

                    @if (Auth()->user()->role->akses_daftar_barcode)
                        <a class="collapse-item
                            @yield('barcode_printing.list-active')"
                            href="{{ route('barcode_printing.list') }}">
                            Daftar Barcode
                        </a>
                    @endif
                    @if (Auth()->user()->role->akses_cetak_barcode)
                        @foreach ($viewStation as $v)
                            <a class="collapse-item
                            @yield("barcodePrinting{$v->id}-active")"
                                href="{{ route('barcode_printing.index', $v->id) }}">
                                {{ $v->name }}
                            </a>
                        @endforeach
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
                <div id="inputData" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Sub-Menu:</h6>
                        <a class="collapse-item" href="{{ route('analyses.index') }}">Analisa</a>
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
