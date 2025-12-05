<!-- Pegawai Sidebar (simplified) -->
<aside id="layout-menu" class="layout-menu menu-vertical bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('pegawai.portal') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-2">{{ config('app.name', 'Simpeg') }}</span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->routeIs('pegawai.portal') ? 'active' : '' }}">
            <a href="{{ route('pegawai.portal') }}" class="menu-link">
                <i class="menu-icon bx bx-home-circle"></i>
                <div data-i18n="Portal">Portal Pegawai</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('pegawai.profile') ? 'active' : '' }}">
            <a href="{{ route('pegawai.profile') }}" class="menu-link">
                <i class="menu-icon bx bx-user"></i>
                <div data-i18n="Profil">Profil</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('pegawai.attendance.*') ? 'active' : '' }}">
            <a href="{{ route('pegawai.portal') }}#attendance" class="menu-link">
                <i class="menu-icon bx bx-time-five"></i>
                <div data-i18n="Presensi">Presensi</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('pegawai.leave.*') ? 'active' : '' }}">
            <a href="{{ route('pegawai.leave.create') }}" class="menu-link">
                <i class="menu-icon bx bx-file-plus"></i>
                <div data-i18n="Pengajuan">Pengajuan</div>
            </a>
        </li>
    </ul>
</aside>
<!-- / Pegawai Sidebar -->
