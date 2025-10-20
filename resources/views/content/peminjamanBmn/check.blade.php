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
        <a class="breadcrumb-item" href="/peminjamanBmn">Peminjaman BMN</a>
        <span class="breadcrumb-item active">Edit</span>
      </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
      <h4 class="tx-gray-800 mg-b-5">Edit Pengajuan Peminjaman BMN</h4>
      <p class="mg-b-0">Edit Form Pengajuan Peminjaman BMN</p>
    </div>

    <div class="br-pagebody">
      <div class="br-section-wrapper">

        <form id="accept{{ $peminjamanBmn->id }}" class="form-layout form-layout-2" action="/peminjamanBmn/{{ $peminjamanBmn->id }}/accepted" method="post">
          @csrf
          @method('put')
          <div class="row no-gutters">
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-control-label">Pemohon</label>
                <input class="form-control" type="text" value="{{ $peminjamanBmn->fPemohon->nama }}" readonly>
              </div>
            </div><!-- col-12 -->
            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Penanggung Jawab</label>
                <input class="form-control" type="text" value="{{ $peminjamanBmn->fPenanggungJawab->pegawai->nama }}" readonly>
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label">Verifikator</label>
                <input class="form-control" type="text" value="{{ $peminjamanBmn->fVerif->pegawai->nama }}" readonly>
              </div>
            </div><!-- col-6 -->

            <input type="hidden" name="status" value="Pengajuan">

            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Lama Pinjam (Hari)</label>
                <input class="form-control" type="number" value="{{ $peminjamanBmn->lama_pinjam }}" readonly>
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Lokasi Penggunaan</label>
                <input class="form-control" type="text" value="{{ $peminjamanBmn->lokasi_penggunaan }}" readonly>
              </div>
            </div><!-- col-6 -->

            <div class="col-md-12">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Daftar BMN :</label>
              </div>
            </div><!-- col-12 -->

            <div class="col-md-12" id="col-bmn"> <!-- Col BMN -->
              @foreach ($peminjamanBmn->bmn as $bmn)
                <div class="row no-gutters row-bmn"> <!-- Row BMN -->
                  <div class="col-md-4">
                    <div class="form-group bd-t-0-force">
                      <label class="form-control-label"> Jenis BMN</label>
                      <input class="form-control" type="text" value="{{ $bmn['jenis'] }}" readonly>
                    </div>
                  </div><!-- col-4 -->
                  <div class="col-md-2">
                    <div class="form-group bd-t-0-force mg-md-l--1">
                      <label class="form-control-label"> Merek</label>
                      <input class="form-control" type="text" value="{{ $bmn['merek'] }}" readonly>
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-md-2">
                    <div class="form-group bd-t-0-force mg-md-l--1">
                      <label class="form-control-label"> NUP</label>
                      <input class="form-control" type="text" value="{{ $bmn['nup'] }}" readonly>
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-md-2">
                    <div class="form-group bd-t-0-force mg-md-l--1">
                      <label class="form-control-label"> Jumlah</label>
                      <input class="form-control" type="number" value="{{ $bmn['jumlah'] }}" readonly>
                    </div>
                  </div><!-- col-2 -->
                  <div class="col-md-2">
                    <div class="form-group bd-t-0-force mg-md-l--1">
                      <label class="form-control-label"> Satuan</label>
                      <input class="form-control" type="text" value="{{ $bmn['satuan'] }}" readonly>
                    </div>
                  </div><!-- col-2 -->
                </div>
              @endforeach
            </div><!-- col-12 -->
          
            {{-- <div class="col-md-12">
              <div class="form-group bd-t-0-force mg-md-r--1">
                <label class="form-control-label"> Tanda Tangan</label>
                <div class="d-flex align-items-enter">
                  <canvas id="signature-pad" class="bd"></canvas>
                  <input type="hidden" name="signature_pemohon" id="signature_pemohon" required>
                  <button type="button" onclick="clearPad()" class="btn btn-danger ml-2"><i class="bi bi-trash"></i></button>
                </div>
              </div>
            </div> --}}

          </div><!-- row -->
          <div class="form-layout-footer bd pd-20 bd-t-0">
            <button data-kode="{{ $peminjamanBmn->id }}" type="button" class="btn btn-success tx-10 pd-x-10 pd-y-5 accepted-confirm"><i class="bi bi-patch-check-fill"></i> Accepted</button>
            <a class="btn btn-danger tx-10 pd-x-10 pd-y-5 text-light tx-medium" data-toggle="modal" data-target="#modaldemo{{ $peminjamanBmn->id }}"><i class="bi bi-patch-exclamation-fill"></i> Decline</a>
            <a href="/peminjamanBmn" class="btn btn-secondary">Cancel</a>
          </div><!-- form-group -->
        </form><!-- form-layout -->

        {{-- Modal BMN --}}
        <div id="modaldemo{{ $peminjamanBmn->id }}" class="modal fade">
          <div class="modal-dialog modal w-100" role="document">
            <form class="modal-content bd-0 tx-14" method="POST" id="decline{{ $peminjamanBmn->id }}" action="/peminjamanBmn/{{ $peminjamanBmn->id }}/declined">
              @csrf
              @method('put')
              <div class="modal-header pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Decline</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body pd-20">
                <div class="form-group">
                  <label class="form-control-label">Keterangan Penolakan: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="ket" placeholder="..." required>
                  @error('ket')  
                    <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                  @enderror
                  <input class="form-control" type="hidden" name="status" value="Ditolak">
                </div>
              </div>
              <div class="modal-footer justify-content-end">
                <button data-kode="{{ $peminjamanBmn->id }}" type="submit" class="btn btn-danger tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium decline-confirm">Decline</button>
                <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div><!-- modal-dialog -->
        </div><!-- modal -->

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
    $(".accepted-confirm").click(function(e) {
        id = e.target.dataset.kode;
        if (id) {
            Swal.fire({
                title: 'Anda yakin ingin menyetujui?',
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#23bf08',
                cancelButtonColor: '#868e96',
                confirmButtonText: 'Iya, Setuju!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#accept' + id).submit(); // mensubmit formnya tanpa button submit
                }
            });
        }
    });
    $('.decline-confirm').on('click', function(e) {
      e.preventDefault();                      // cegah submit langsung
      const id   = this.dataset.kode;
      const form = document.getElementById('decline' + id);

      if (!form.checkValidity()) {             // belum valid?
          form.reportValidity();               // tampilkan pesan error
          return;                              // stop, jangan munculkan SweetAlert
      }

      Swal.fire({
          title: 'Anda yakin ingin menolak?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc3545',
          cancelButtonColor: '#2DCE89',
          confirmButtonText: 'Iya, Tolak!',
          cancelButtonText: 'Batal'
      }).then(result => {
          if (result.isConfirmed) {
              form.submit();                   // native submit
          }
      });
    });
  </script>

@endpush