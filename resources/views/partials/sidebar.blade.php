<!-- ########## START: LEFT PANEL ########## -->
<div class="br-logo"><a href=""><span>[</span>Invenku Panel<span>]</span></a></div>
<div class="br-sideleft overflow-y-auto" style="background-color: #1d2939">
  <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
  <div class="br-sideleft-menu">

    <a href="/dashboard" class="br-menu-link {{ Request::is('dashboard') ? 'active' : '' }}">
      <div class="br-menu-item">
        <i class="menu-item-icon bi bi-grid tx-18"></i>
        <span class="menu-item-label">Dashboard</span>
      </div><!-- menu-item -->
    </a><!-- br-menu-link -->

    @if (Auth::user()->role == 'Super Admin')
      <a href="/manage/user" class="br-menu-link {{ Request::is('manage/user') || Request::is('manage/user/*') || Request::is('manage/jabatan') || Request::is('manage/jabatan/*') || Request::is('manage/pegawai') || Request::is('manage/pegawai/*') ? 'show-sub active' : '' }}">
        <div class="br-menu-item">
          <i class="menu-item-icon bi bi-people tx-18"></i>
          <span class="menu-item-label">Manage User</span>
          <i class="menu-item-arrow fa fa-angle-down"></i>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->
      <ul class="br-menu-sub nav flex-column">
        <li class="nav-item"><a href="/manage/jabatan" class="nav-link {{ Request::is('manage/jabatan') || Request::is('manage/jabatan/*') ? 'active' : '' }}">Jabatan</a></li>
        <li class="nav-item"><a href="/manage/pegawai" class="nav-link {{ Request::is('manage/pegawai') || Request::is('manage/pegawai/*') ? 'active' : '' }}">Pegawai</a></li>
        <li class="nav-item"><a href="/manage/user" class="nav-link {{ Request::is('manage/user') || Request::is('manage/user/*') ? 'active' : '' }}">User</a></li>
        {{-- <li class="nav-item"><a href="/manage/booking" class="nav-link {{ Request::is('manage/booking') || Request::is('manage/booking/*') ? 'active' : '' }}">Booking</a></li> --}}
      </ul>

      <a href="/manage/permintaanAtk" class="br-menu-link {{ Request::is('manage/permintaanAtk') || Request::is('manage/permintaanAtk/*') ? 'active' : '' }}">
        <div class="br-menu-item">
          <i class="menu-item-icon bi bi-box-seam tx-18"></i>
          <span class="menu-item-label">ATK / Suvenir</span>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->

      <a href="/manage/peminjamanRuang" class="br-menu-link {{ Request::is('manage/peminjamanRuang') || Request::is('manage/peminjamanRuang/*') ? 'active' : '' }}">
        <div class="br-menu-item">
          <i class="menu-item-icon bi bi-building tx-18"></i>
          <span class="menu-item-label">Peminjaman Ruang</span>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->

      <a href="/manage/peminjamanKendaraan" class="br-menu-link {{ Request::is('manage/peminjamanKendaraan') || Request::is('manage/peminjamanKendaraan/*') ? 'active' : '' }}">
        <div class="br-menu-item">
          <i class="menu-item-icon bi bi-car-front tx-18"></i>
          <span class="menu-item-label">Peminjaman Kendaraan</span>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->

      {{-- <a href="/manage/peminjamanBmn" class="br-menu-link {{ Request::is('manage/peminjamanBmn') || Request::is('manage/peminjamanBmn/*') || Request::is('manage/pengembalianBmn') || Request::is('manage/pengembalianBmn/*') ? 'show-sub active' : '' }}">
        <div class="br-menu-item">
          <i class="menu-item-icon bi bi-boxes tx-18"></i>
          <span class="menu-item-label">BMN</span>
          <i class="menu-item-arrow fa fa-angle-down"></i>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->
      <ul class="br-menu-sub nav flex-column">
        <li class="nav-item"><a href="/manage/peminjamanBmn" class="nav-link {{ Request::is('manage/peminjamanBmn') || Request::is('manage/peminjamanBmn/*') ? 'active' : '' }}">Peminjaman</a></li>
        <li class="nav-item"><a href="/manage/pengembalianBmn" class="nav-link {{ Request::is('manage/pengembalianBmn') || Request::is('manage/pengembalianBmn/*') ? 'active' : '' }}">Pengembalian</a></li>
      </ul> --}}
    @endif

    @if (in_array(Auth::user()->role, ['Petugas', 'Petugas BMN', 'Katim', 'PPK', 'Kasubag TU', 'Resepsionis', 'Viewer']))
      <a href="/permintaanAtk" class="br-menu-link {{ Request::is('permintaanAtk') || Request::is('permintaanAtk/*') ? 'active' : '' }}">
        <div class="br-menu-item">
          <i class="menu-item-icon bi bi-box-seam tx-18"></i>
          <span class="menu-item-label">ATK / Suvenir</span>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->
    @endif
    
    {{-- @if (in_array(Auth::user()->role, ['Petugas', 'Petugas BMN', 'Kasubag TU']))
      <a href="/peminjamanRuang" class="br-menu-link {{ Request::is('peminjamanRuang') || Request::is('peminjamanRuang/*') ? 'active' : '' }}">
        <div class="br-menu-item">
          <i class="menu-item-icon bi bi-building tx-18"></i>
          <span class="menu-item-label mb-0">Peminjaman Ruang</span>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->

      <a href="/peminjamanKendaraan" class="br-menu-link {{ Request::is('peminjamanKendaraan') || Request::is('peminjamanKendaraan/*') ? 'active' : '' }}">
        <div class="br-menu-item">
          <i class="menu-item-icon bi bi-car-front tx-18"></i>
          <span class="menu-item-label">Peminjaman Kendaraan</span>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->
    @endif --}}
    
    {{-- Coming Soon --}}
    <hr style="border-color: #adb5bd">
    <div class="mb-2">
      <div class="br-menu-item">
        <i class="menu-item-icon bi bi-building tx-18"></i>
        <div>
          <span class="menu-item-label mb-0">Peminjaman Ruang</span>
          <span class="menu-item-label tx-10 bg-danger p-1 rounded">Coming Soon</span>
        </div>
      </div><!-- menu-item -->
    </div><!-- br-menu-link -->
    <div>
      <div class="br-menu-item">
        <i class="menu-item-icon bi bi-car-front tx-18"></i>
        <div>
          <span class="menu-item-label mb-0">Peminjaman Kendaraan</span>
          <span class="menu-item-label tx-10 bg-danger p-1 rounded">Coming Soon</span>
        </div>
      </div><!-- menu-item -->
    </div><!-- br-menu-link -->
    
    {{-- @if (in_array(Auth::user()->role, ['Petugas BMN', 'Katim', 'Kasubag TU']))
      <a href="/peminjamanBmn" class="br-menu-link {{ Request::is('peminjamanBmn') || Request::is('peminjamanBmn/*') ? 'active' : '' }}">
        <div class="br-menu-item">
          <i class="menu-item-icon bi bi-boxes tx-18"></i>
          <span class="menu-item-label">Peminjaman BMN</span>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->
    @endif --}}

    {{-- @if (Auth::user()->role == 'Petugas')
      <a href="/peminjamanBmn" class="br-menu-link {{ Request::is('peminjamanBmn') || Request::is('peminjamanBmn/*') || Request::is('pengembalianBmn') || Request::is('pengembalianBmn/*') ? 'show-sub active' : '' }}">
        <div class="br-menu-item">
          <i class="menu-item-icon bi bi-boxes tx-18"></i>
          <span class="menu-item-label">BMN</span>
          <i class="menu-item-arrow fa fa-angle-down"></i>
        </div><!-- menu-item -->
      </a><!-- br-menu-link -->
      <ul class="br-menu-sub nav flex-column">
        <li class="nav-item"><a href="/peminjamanBmn" class="nav-link {{ Request::is('peminjamanBmn') || Request::is('peminjamanBmn/*') ? 'active' : '' }}">Peminjaman</a></li>
        <li class="nav-item"><a href="/pengembalianBmn" class="nav-link {{ Request::is('pengembalianBmn') || Request::is('pengembalianBmn/*') ? 'active' : '' }}">Pengembalian</a></li>
      </ul>
    @endif --}}

  </div><!-- br-sideleft-menu -->

  {{-- <label class="sidebar-label pd-x-15 mg-t-25 mg-b-20 tx-info op-9">Information Summary</label> --}}

  {{-- <div class="info-list">
    <div class="d-flex align-items-center justify-content-between pd-x-15">
      <div>
        <p class="tx-10 tx-roboto tx-uppercase tx-spacing-1 tx-white op-3 mg-b-2 space-nowrap">Memory Usage</p>
        <h5 class="tx-lato tx-white tx-normal mg-b-0">32.3%</h5>
      </div>
      <span class="peity-bar" data-peity='{ "fill": ["#336490"], "height": 35, "width": 60 }'>8,6,5,9,8,4,9,3,5,9</span>
    </div><!-- d-flex -->

    <div class="d-flex align-items-center justify-content-between pd-x-15 mg-t-20">
      <div>
        <p class="tx-10 tx-roboto tx-uppercase tx-spacing-1 tx-white op-3 mg-b-2 space-nowrap">CPU Usage</p>
        <h5 class="tx-lato tx-white tx-normal mg-b-0">140.05</h5>
      </div>
      <span class="peity-bar" data-peity='{ "fill": ["#1C7973"], "height": 35, "width": 60 }'>4,3,5,7,12,10,4,5,11,7</span>
    </div><!-- d-flex -->

    <div class="d-flex align-items-center justify-content-between pd-x-15 mg-t-20">
      <div>
        <p class="tx-10 tx-roboto tx-uppercase tx-spacing-1 tx-white op-3 mg-b-2 space-nowrap">Disk Usage</p>
        <h5 class="tx-lato tx-white tx-normal mg-b-0">82.02%</h5>
      </div>
      <span class="peity-bar"
        data-peity='{ "fill": ["#8E4246"], "height": 35, "width": 60 }'>1,2,1,3,2,10,4,12,7</span>
    </div><!-- d-flex -->

    <div class="d-flex align-items-center justify-content-between pd-x-15 mg-t-20">
      <div>
        <p class="tx-10 tx-roboto tx-uppercase tx-spacing-1 tx-white op-3 mg-b-2 space-nowrap">Daily Traffic</p>
        <h5 class="tx-lato tx-white tx-normal mg-b-0">62,201</h5>
      </div>
      <span class="peity-bar"
        data-peity='{ "fill": ["#9C7846"], "height": 35, "width": 60 }'>3,12,7,9,2,3,4,5,2</span>
    </div><!-- d-flex -->
  </div><!-- info-lst --> --}}

  <br>
</div><!-- br-sideleft -->
<!-- ########## END: LEFT PANEL ########## -->