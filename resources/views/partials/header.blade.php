<!-- ########## START: HEAD PANEL ########## -->
<div class="br-header">
  <div class="br-header-left">
    <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
    <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>

  </div><!-- br-header-left -->
  <div class="br-header-right">

    <nav class="nav">
      <div class="dropdown">
        <a href="" class="nav-link nav-link-profile d-flex" data-toggle="dropdown">
          {{-- <span class="logged-name hidden-md-down">{{ Auth::user()->nama }}</span> --}}
          <div class="d-flex align-items-end flex-column mr-2">
            <span class="tx-bold tx-info logged-name hidden-md-down">{{ Auth::user()->pegawai->nama }}</span>
            <span class="tx-10 logged-name hidden-md-down">{{ Auth::user()->role }}</span>
          </div>
          <img src="{{ asset('assets/img') }}/person3.png" class="wd-32 rounded-circle" alt="">
          <span class="square-10 bg-success"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-header wd-200">
          <ul class="list-unstyled user-profile-nav">
            <li><a href="/logout"><i class="icon bi bi-power"></i> Sign Out</a></li>
          </ul>
        </div><!-- dropdown-menu -->
      </div><!-- dropdown -->
    </nav>

  </div><!-- br-header-right -->
</div><!-- br-header -->
<!-- ########## END: HEAD PANEL ########## -->