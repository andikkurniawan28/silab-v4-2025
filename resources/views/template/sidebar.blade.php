<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

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

    <!-- Nav Item - Master Collapse Menu -->
    <li class="nav-item
        @yield('roles-active')
        @yield('users-active')
        @yield('stations-active')
        @yield('units-active')
        @yield('parameters-active')
        @yield('materials-active')
    ">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseMaster" aria-expanded="true"
            aria-controls="collapseMaster">
            <i class="fas fa-fw fa-database"></i>
            <span>Master</span>
        </a>
        <div id="collapseMaster" class="collapse
            @yield('roles-show')
            @yield('users-show')
            @yield('stations-show')
            @yield('units-show')
            @yield('parameters-show')
            @yield('materials-show')
        " aria-labelledby="headingMaster" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

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

            </div>
        </div>
    </li>

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
