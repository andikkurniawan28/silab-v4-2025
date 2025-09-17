<nav id="sidebar" class="sidebar js-sidebar">

    <div class="sidebar-content js-simplebar">

        <a class="sidebar-brand" href="{{ route('dashboard.index') }}">
            <img src="/adminkit-main/static/img/icons/logo.png" />
            <span class="align-middle">Silab</span>
        </a>

        <ul class="sidebar-nav">

            <li class="sidebar-item @yield('dashboard-active')">
                <a class="sidebar-link" href="{{ route('dashboard.index') }}">
                    <i class="bi bi-speedometer2 align-middle"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            @if (Auth()->user()->role->akses_daftar_jabatan)
                <li class="sidebar-item @yield('roles-active')">
                    <a class="sidebar-link" href="{{ route('roles.index') }}">
                        <i class="bi bi-person-badge align-middle"></i>
                        <span class="align-middle">Jabatan</span>
                    </a>
                </li>
            @endif

            @if (Auth()->user()->role->akses_daftar_user)
                <li class="sidebar-item @yield('users-active')">
                    <a class="sidebar-link" href="{{ route('users.index') }}">
                        <i class="bi bi-people align-middle"></i>
                        <span class="align-middle">User</span>
                    </a>
                </li>
            @endif

            @if (Auth()->user()->role->akses_daftar_stasiun)
                <li class="sidebar-item @yield('stations-active')">
                    <a class="sidebar-link" href="{{ route('stations.index') }}">
                        <i class="bi bi-diagram-3 align-middle"></i>
                        <span class="align-middle">Stasiun</span>
                    </a>
                </li>
            @endif

            @if (Auth()->user()->role->akses_daftar_satuan)
                <li class="sidebar-item @yield('units-active')">
                    <a class="sidebar-link" href="{{ route('units.index') }}">
                        <i class="bi bi-rulers align-middle"></i>
                        <span class="align-middle">Satuan</span>
                    </a>
                </li>
            @endif

        </ul>


    </div>

</nav>
