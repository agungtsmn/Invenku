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

  <style>
    @media (max-width: 575.98px) {
      #signature-pad{
        width: 100%;
      }
    }
  </style>
@endpush

@section('content')
  <!-- ########## START: MAIN PANEL ########## -->
  <div class="br-mainpanel">
    <div class="br-pageheader pd-y-15 pd-l-20">
      <nav class="breadcrumb pd-0 mg-0 tx-12">
        <a class="breadcrumb-item" href="/dashboard">Invenku Pusmendik</a>
        <span class="breadcrumb-item active">Tanda Tangan</span>
      </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
      <h4 class="tx-gray-800 mg-b-5">Tanda Tangan</h4>
      <p class="mg-b-0">Pengelola Tanda Tangan</p>
    </div>

    <div class="br-pagebody">
      <div class="br-section-wrapper">

        <form id="signature-form" class="form-layout form-layout-2" action="/tanda-tangan" method="post">
          @csrf
          <div class="row no-gutters">
            <input type="hidden" value="{{ Auth::user()->pegawai_id }}" name="pegawai_id" required>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label"> Tanda Tangan <span class="tx-danger">*</span></label>
                <div class="d-flex align-items-enter">
                  <canvas id="signature-pad" class="bd"></canvas>
                  <input type="hidden" name="tanda_tangan" id="tanda_tangan" required>
                  <button type="button" onclick="clearPad()" class="btn btn-danger ml-2"><i class="bi bi-trash"></i></button>
                </div>
              </div>
            </div><!-- col-12 -->
            <div class="col-md-6">
              <div class="form-group mg-md-l--1 d-flex flex-column justify-content-between">
                <label class="form-control-label"> Tanda Tangan Saat Ini <span class="tx-danger">*</span></label>
                @if (Auth::user()->pegawai?->tandaTangan?->tanda_tangan)
                  <img src="{{ asset('storage/tanda_tangan/' . Auth::user()->pegawai->tandaTangan->tanda_tangan) }}" alt="Tanda Tangan" width="200px">
                @else
                  <span>Belum ada tanda tangan yang tersimpan</span>
                @endif
                <div class="">
                  <b>{{ Auth::user()->pegawai->nama }}</b><br>
                  <span>NIP {{ Auth::user()->pegawai->nip }}</span>
                </div>
              </div>
            </div><!-- col-12 -->
          </div><!-- row -->
          <div class="form-layout-footer bd pd-20 bd-t-0">
            <button type="submit" class="btn btn-info">Submit</button>
            <a href="/dashboard" class="btn btn-secondary">Cancel</a>
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

  {{-- sweetalert2 --}}
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

  <script>
    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas);

    function clearPad() {
      signaturePad.clear();
    }

    document.getElementById('signature-form').addEventListener('submit', function(e) {
      if (signaturePad.isEmpty()) {
        e.preventDefault(); // Cegah submit
        Swal.fire({
          title: 'Oops!',
          text: 'Silakan tanda tangani terlebih dahulu!',
          confirmButtonColor: '#00a48b',
          confirmButtonText: 'Ok!',
        });
        // alert("Silakan tanda tangani terlebih dahulu sebelum menyimpan.");
      } else {
        // Kalau tidak kosong, simpan ke input hidden
        const dataURL = signaturePad.toDataURL();
        document.getElementById('tanda_tangan').value = dataURL;
      }
    });
  </script>

@endpush