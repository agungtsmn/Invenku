@extends('layout.main')

@push('css')
  <!-- vendor css -->
  <link href="{{ asset('template') }}/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/Ionicons/css/ionicons.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/rickshaw/rickshaw.min.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/chartist/chartist.css" rel="stylesheet">

  <!-- Bracket CSS -->
  <link rel="stylesheet" href="{{ asset('template') }}/css/bracket.css">

  <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endpush

@section('content')
  <!-- ########## START: MAIN PANEL ########## -->
  <div class="br-mainpanel">
    <div class="pd-x-30 pd-y-30 d-flex align-items-center welcome-box">
      <i class="bi bi-person-circle mr-4 mt-2" style="font-size: 50px; color: #343a40"></i>
      <div>
        <p class="tx-gray-800 mg-b-5 tx-30">Welcome, <b>{{ Auth::user()->pegawai->nama }}</b></p>
        <p class="mg-b-0">Kelola data dan permintaan Anda dengan mudah.</p>
      </div>
    </div><!-- d-flex -->
    <div class="pd-x-30 pd-y-30">
      <h4 class="tx-gray-800 mg-b-5">Statistik</h4>
      <p class="mg-b-0">Statistik permintaan dan peminjaman</p>
    </div><!-- d-flex -->
    <div class="br-pagebody mg-t-5 pd-x-30">
      <div class="row row-sm">
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="bg-br-primary overflow-hidden rounded">
            <div class="pd-25 d-flex align-items-center">
              {{-- <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i> --}}
              <i class="bi bi-clipboard tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10"> Draf</p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">0</p>
                <span class="tx-11 tx-roboto tx-white-6">Permintaan</span>
              </div>
            </div>
          </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="bg-danger overflow-hidden rounded">
            <div class="pd-25 d-flex align-items-center">
              {{-- <i class="ion ion-bag tx-60 lh-0 tx-white op-7"></i> --}}
              <i class="bi bi-clipboard-check tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Pengajuan</p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">0</p>
                <span class="tx-11 tx-roboto tx-white-6">Permintaan</span>
              </div>
            </div>
          </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="bg-primary overflow-hidden rounded">
            <div class="pd-25 d-flex align-items-center">
              {{-- <i class="bi bi-alarm tx-60 lh-0 tx-white op-7"></i> --}}
              <i class="bi bi-clipboard-check tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Diterima</p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">0</p>
                <span class="tx-11 tx-roboto tx-white-6">Permintaan</span>
              </div>
            </div>
          </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3 mb-3">
          <div class="bg-teal overflow-hidden rounded">
            <div class="pd-25 d-flex align-items-center">
              {{-- <i class="bi bi-alarm tx-60 lh-0 tx-white op-7"></i> --}}
              <i class="bi bi-clipboard-check tx-60 lh-0 tx-white op-7"></i>
              <div class="mg-l-20">
                <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Disetujui</p>
                <p class="tx-24 tx-white tx-lato tx-bold mg-b-2 lh-1">0</p>
                <span class="tx-11 tx-roboto tx-white-6">Permintaan</span>
              </div>
            </div>
          </div>
        </div><!-- col-3 -->
      </div><!-- row -->

    </div><!-- br-pagebody -->
    @include('partials.footer')
  </div><!-- br-mainpanel -->
  <!-- ########## END: MAIN PANEL ########## -->
@endsection

@push('js')
  <script src="{{ asset('template') }}/lib/jquery/jquery.js"></script>
  <script src="{{ asset('template') }}/lib/popper.js/popper.js"></script>
  <script src="{{ asset('template') }}/lib/bootstrap/bootstrap.js"></script>
  <script src="{{ asset('template') }}/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
  <script src="{{ asset('template') }}/lib/moment/moment.js"></script>
  <script src="{{ asset('template') }}/lib/jquery-ui/jquery-ui.js"></script>
  <script src="{{ asset('template') }}/lib/jquery-switchbutton/jquery.switchButton.js"></script>
  <script src="{{ asset('template') }}/lib/peity/jquery.peity.js"></script>
  <script src="{{ asset('template') }}/lib/chartist/chartist.js"></script>
  <script src="{{ asset('template') }}/lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
  <script src="{{ asset('template') }}/lib/d3/d3.js"></script>
  <script src="{{ asset('template') }}/lib/rickshaw/rickshaw.min.js"></script>


  <script src="{{ asset('template') }}/js/bracket.js"></script>
  <script src="{{ asset('template') }}/js/ResizeSensor.js"></script>
  <script src="{{ asset('template') }}/js/dashboard.js"></script>

  <script>
    $(function() {
      'use strict'

      // FOR DEMO ONLY
      // menu collapsed by default during first page load or refresh with screen
      // having a size between 992px and 1299px. This is intended on this page only
      // for better viewing of widgets demo.
      $(window).resize(function() {
        minimizeMenu();
      });

      minimizeMenu();

      function minimizeMenu() {
        if (window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
          // show only the icons and hide left menu label by default
          $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
          $('body').addClass('collapsed-menu');
          $('.show-sub + .br-menu-sub').slideUp();
        } else if (window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
          $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
          $('body').removeClass('collapsed-menu');
          $('.show-sub + .br-menu-sub').slideDown();
        }
      }
    });
  </script>
@endpush