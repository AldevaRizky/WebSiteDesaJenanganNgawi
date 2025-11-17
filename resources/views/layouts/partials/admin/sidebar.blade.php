<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/logo/ngawi.png') }}" alt=" Logo" width="36" class="me-1">
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-1 fs-5">Desa Jenangan</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- Apps & Pages Header -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Apps &amp; Pages</span>
        </li>

        <!-- Layouts Section -->
        <li
            class="menu-item {{ request()->routeIs(
                'heroes.*',
                'admin.heroes.*',
                'hero_banner.*',
                'admin.hero_banner.*',
                'logos.*',
                'admin.logos.*',
                'data_penduduk.*',
                'admin.data_penduduk.*',
                'sejarah_desa.*',
                'admin.sejarah_desa.*',
                'sambutan_kepala_desa.*',
                'admin.sambutan_kepala_desa.*',
                'visi_misi.*',
                'admin.visi_misi.*',
                'footer.*',
                'admin.footer.*',
            )
                ? 'active open'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div class="text-truncate" data-i18n="Layouts">Layouts</div>
                <span class="badge rounded-pill bg-danger ms-auto">8</span>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.heroes.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.heroes.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Hero Cover">Hero Cover</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.hero_banner.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.hero_banner.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Hero Banner">Hero Banner</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.logos.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.logos.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Logo">Logo</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.data_penduduk.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.data_penduduk.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Data Penduduk">Data Penduduk</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.sejarah_desa.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.sejarah_desa.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Sejarah Desa">Sejarah Desa</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.sambutan_kepala_desa.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.sambutan_kepala_desa.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Sambutan Kepala Desa">Sambutan Kepala Desa</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.visi_misi.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.visi_misi.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Visi & Misi">Visi & Misi</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('admin.footer.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.footer.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Footer">Footer</div>
                    </a>
                </li>

            </ul>
        </li>

        <!-- News Category -->
        <li class="menu-item {{ request()->routeIs('admin.kategori_berita.index') ? 'active' : '' }}">
            <a href="{{ route('admin.kategori_berita.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div class="text-truncate" data-i18n="News">Kategori Berita</div>
            </a>
        </li>

        <!-- News -->
        <li class="menu-item {{ request()->routeIs('admin.beritas.index') ? 'active' : '' }}">
            <a href="{{ route('admin.beritas.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-news"></i>
                <div class="text-truncate" data-i18n="News">Berita</div>
            </a>
        </li>

        <!-- Message -->
        <li class="menu-item {{ request()->routeIs('pesans.index') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons bx bx-chat"></i>
                <div class="text-truncate" data-i18n="Message">Pesan Masuk</div>
            </a>
        </li>

    </ul>
</aside>
