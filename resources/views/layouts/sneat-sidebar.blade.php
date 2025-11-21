<!-- Sidebar -->
<aside id="layout-menu" class="layout-menu menu-vertical bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
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

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Master Data</span>
        </li>

        <li class="menu-item {{ request()->routeIs('jabatan.*') ? 'active' : '' }}">
            <a href="{{ route('jabatan.index') }}" class="menu-link">
                <i class="menu-icon bx bx-briefcase-alt-2"></i>
                <div data-i18n="Jabatan">Jabatan</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('pegawai.*') ? 'active' : '' }}">
            <a href="{{ route('pegawai.index') }}" class="menu-link">
                <i class="menu-icon bx bx-user"></i>
                <div data-i18n="Pegawai">Pegawai</div>
            </a>
        </li>

        <!-- Tambah menu lain sesuai kebutuhan -->
    </ul>
</aside>
<!-- / Sidebar -->
