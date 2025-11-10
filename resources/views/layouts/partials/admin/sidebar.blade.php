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
    <li class="menu-item {{ request()->routeIs(
        'heroes.*', 'admin.heroes.*',
        'hero_banner.*', 'admin.hero_banner.*',
        'logos.*', 'admin.logos.*',
        'dataSekolah.*', 'admin.dataSekolah.*',
        'sejarah_sekolah.*', 'admin.sejarah_sekolah.*',
        'sambutan_kepala_sekolah.*', 'admin.sambutan_kepala_sekolah.*',
        'visi_misi.*', 'admin.visi_misi.*',
        'fasilitaslayouts.*', 'admin.fasilitaslayouts.*',
        'footer.*', 'admin.footer.*'
      ) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div class="text-truncate" data-i18n="Layouts">Layouts</div>
        <span class="badge rounded-pill bg-danger ms-auto">9</span>
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
        <li class="menu-item {{ request()->routeIs('dataSekolah.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Data Sekolah">Data Sekolah</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('sejarah_sekolah.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Sejarah Sekolah">Sejarah Sekolah</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('sambutan_kepala_sekolah.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Sambutan Kepala Sekolah">Sambutan Kepala Sekolah</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('visi_misi.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Visi&Misi">Visi & Misi</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('fasilitaslayouts.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Fasilitas">Fasilitas</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('footer.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Footer">Footer</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- News -->
    <li class="menu-item {{ request()->routeIs('beritas.index') ? 'active' : '' }}">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-news"></i>
        <div class="text-truncate" data-i18n="News">Berita</div>
      </a>
    </li>

    <!-- Extrakurikuler -->
    <li class="menu-item {{ request()->routeIs('ekstrakurikulers.index') ? 'active' : '' }}">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-group"></i>
        <div class="text-truncate" data-i18n="Extrakurikuler">Extrakurikuler</div>
      </a>
    </li>

    <!-- Message -->
    <li class="menu-item {{ request()->routeIs('pesans.index') ? 'active' : '' }}">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-chat"></i>
        <div class="text-truncate" data-i18n="Message">Pesan Masuk</div>
      </a>
    </li>

    <!-- Apps Header -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Apps</span>
    </li>

    <!-- PPDB -->
    <li class="menu-item {{ request()->routeIs(
        'periodes*', 'admin.periodes*',
        'gelombangs*', 'admin.gelombangs*',
        'formulir_pendaftaran*', 'admin.formulir_pendaftaran*',
        'users.ppdb*', 'admin.users.ppdb*'
      ) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-group"></i>
        <div class="text-truncate" data-i18n="Layouts">PPDB</div>
        <span class="badge rounded-pill bg-danger ms-auto">4</span>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('periodes.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Periode PPDB">Periode PPDB</div>
          </a>
        </li>
      </ul>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('gelombangs.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Gelombang PPDB">Gelombang PPDB</div>
          </a>
        </li>
      </ul>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('users.ppdb.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Manage Users PPDB">Manage Users PPDB</div>
          </a>
        </li>
      </ul>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('formulir_pendaftaran.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Data PPDB">Data PPDB</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- MasterData -->
    <li class="menu-item {{ request()->routeIs(
        'gurus*', 'admin.gurus*',
        'siswas*', 'admin.siswas*',
        'academic_years*', 'admin.academic_years*',
        'classes*', 'admin.classes*',
        'subjects*', 'admin.subjects*',
        'schedules*', 'admin.schedules*',
        'class-students*', 'admin.class-students*',
        'attendances*', 'admin.attendances*'
      ) ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-data"></i>
        <div class="text-truncate" data-i18n="Layouts">Master Data</div>
        <span class="badge rounded-pill bg-danger ms-auto">4</span>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('gurus.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Users Guru">Users Guru</div>
          </a>
        </li>
      </ul>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('siswas.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Users Siswa">Users Siswa</div>
          </a>
        </li>
      </ul>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('academic_years.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Tahun Akademik">Tahun Akademik</div>
          </a>
        </li>
      </ul>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('classes.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Kelas">Kelas</div>
          </a>
        </li>
      </ul>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('subjects.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Mata Pelajaran">Mata Pelajaran</div>
          </a>
        </li>
      </ul>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('schedules.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Jadwal">Jadwal</div>
          </a>
        </li>
      </ul>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('class-students.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Kelas Siswa">Kelas Siswa</div>
          </a>
        </li>
      </ul>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('attendances.index') ? 'active' : '' }}">
          <a href="#" class="menu-link">
            <div class="text-truncate" data-i18n="Presensi Siswa">Presensi Siswa</div>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</aside>
