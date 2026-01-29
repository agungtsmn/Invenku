@extends('layout.main')

@push('css')
  <!-- vendor css -->
  <link href="{{ asset('template') }}/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/Ionicons/css/ionicons.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/highlightjs/github.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/select2/css/select2.min.css" rel="stylesheet">

  <!-- Bracket CSS -->
  <link rel="stylesheet" href="{{ asset('template') }}/css/bracket.css">
@endpush

@section('content')
  <!-- ########## START: MAIN PANEL ########## -->
  <div class="br-mainpanel">
    <div class="br-pageheader pd-y-15 pd-l-20">
      <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="/dashboard">Invenku Pusmendik</a>
        <a class="breadcrumb-item" href="/manage/user">Manage</a>
        <a class="breadcrumb-item" href="/manage/user">User</a>
        <span class="breadcrumb-item active">Create</span>
      </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
      <h4 class="tx-gray-800 mg-b-5">Create User</h4>
      <p class="mg-b-0">Adding user to the database</p>
    </div>

    <div class="br-pagebody">
      <div class="br-section-wrapper">

        <form class="form-layout form-layout-2" action="/manage/user" method="post">
          @csrf
          <div class="row no-gutters">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label mg-b-0-force">Pegawai <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="pegawai_id" data-placeholder="Pilih Pegawai" required>
                  <option label="Pilih Pegawai"></option>
                  @foreach ($pegawais as $pegawai)
                    <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                  @endforeach
                </select>
                @error('pegawai_id')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Email <span class="tx-danger">*</span></label>
                <input class="form-control" type="email" name="email" placeholder="Enter Email" required value="{{ old('email') }}">
                @error('email')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-4 -->
            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Password <span class="tx-danger">*</span></label>
                <input class="form-control" type="password" name="password" placeholder="Enter Password" required>
                @error('password')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-8 -->
            <div class="col-md-6">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Role <span class="tx-danger">*</span></label>
                <select id="select2-a" class="form-control" name="role" data-placeholder="Pilih Role" required>
                  <option label="Pilih Role"></option>
                  <option value="Pegawai">Pegawai</option>
                  <option value="Petugas">Petugas</option>
                  <option value="Petugas BMN">Petugas BMN</option>
                  <option value="Katim">Katim</option>
                  <option value="PPK">PPK</option>
                  <option value="Kasubag TU">Kasubag TU</option>
                  <option value="Resepsionis">Resepsionis</option>
                  <option value="Viewer">Viewer</option>
                  <option value="Super Admin">Super Admin</option>
                </select>
                @error('role')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-4 -->
          </div><!-- row -->
          <div class="form-layout-footer bd pd-20 bd-t-0">
            <button type="submit" class="btn btn-info">Submit Form</button>
            <a href="/manage/user" class="btn btn-secondary">Cancel</a href="">
          </div><!-- form-group -->
        </form><!-- form-layout -->


      </div><!-- br-section-wrapper -->
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
  <script src="{{ asset('template') }}/lib/highlightjs/highlight.pack.js"></script>
  <script src="{{ asset('template') }}/lib/select2/js/select2.min.js"></script>

  <script src="{{ asset('template') }}/js/bracket.js"></script>
  <script>
    $(function(){
      'use strict'

      $('.form-layout .form-control').on('focusin', function(){
        $(this).closest('.form-group').addClass('form-group-active');
      });

      $('.form-layout .form-control').on('focusout', function(){
        $(this).closest('.form-group').removeClass('form-group-active');
      });

      // Select2
      $('#select2-a, #select2-b').select2({
        minimumResultsForSearch: Infinity
      });

      $('#select2-a').on('select2:opening', function (e) {
        $(this).closest('.form-group').addClass('form-group-active');
      });

      $('#select2-a').on('select2:closing', function (e) {
        $(this).closest('.form-group').removeClass('form-group-active');
      });

    });
  </script>
@endpush