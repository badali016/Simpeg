<!-- Sidebar -->
<aside id="layout-menu" class="layout-menu menu-vertical bg-menu-theme">
    <div class="app-brand demo">
        @php $brandRoute = route('admin.dashboard'); @endphp
        @auth
            @if(auth()->user()->is_admin)
                @php $brandRoute = route('admin.dashboard'); @endphp
            @elseif(auth()->user()->pegawai_id)
                @php $brandRoute = route('pegawai.portal'); @endphp
            @endif
        @endauth
        <a href="{{ $brandRoute }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-2">
                {{ config('app.name', 'Simpeg') }}
            </span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        @auth
            @if(auth()->user()->is_admin)
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Master Data</span>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.jabatan.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.jabatan.index') }}" class="menu-link">
                        <i class="menu-icon bx bx-briefcase-alt-2"></i>
                        <div data-i18n="Jabatan">Jabatan</div>
                    </a>
                </li>
                
                <li class="menu-item {{ request()->routeIs('admin.pegawai.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.pegawai.index') }}" class="menu-link">
                        <i class="menu-icon bx bx-user"></i>
                        <div data-i18n="Pegawai">Pegawai</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="menu-link">
                        <i class="menu-icon bx bx-user-check"></i>
                        <div data-i18n="Users">Users</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.leaves.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.leaves.index') }}" class="menu-link">
                        <i class="menu-icon bx bx-calendar-check"></i>
                        <div data-i18n="Pengajuan">Pengajuan Cuti</div>
                    </a>
                </li>
            @else
                {{-- Non-admin users see a simplified menu --}}
                <li class="menu-item {{ request()->routeIs('pegawai.portal') ? 'active' : '' }}">
                    <a href="{{ route('pegawai.portal') }}" class="menu-link">
                        <i class="menu-icon bx bx-user"></i>
                        <div data-i18n="Portal">Portal Pegawai</div>
                    </a>
                </li>
            @endif
        @endauth

        <!-- Tambah menu lain sesuai kebutuhan -->
    </ul>
</aside>
<!-- / Sidebar -->
