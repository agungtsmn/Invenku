s@extends('layout.main')

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
        <a class="breadcrumb-item" href="/manage/peminjamanKendaraan">Manage</a>
        <a class="breadcrumb-item" href="/manage/peminjamanKendaraan">Peminjaman Kendaraan</a>
        <span class="breadcrumb-item active">Edit</span>
      </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
      <h4 class="tx-gray-800 mg-b-5">Edit Peminjaman Kendaraan</h4>
      <p class="mg-b-0">Edit peminjaman kendaraan to the database</p>
    </div>

    <div class="br-pagebody">
      <div class="br-section-wrapper">

        <form id="signature-form" class="form-layout form-layout-2" action="/manage/peminjamanKendaraan/{{ $peminjamanKendaraan->id }}" method="post">
          @csrf
          @method('put')
          <div class="row no-gutters">
            <div class="col-md-6"> 
              <div class="form-group">
                <label class="form-control-label mg-b-0-force">Pegawai <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="pemohon" data-placeholder="Pilih Pegawai" required>
                  <option value="{{ $peminjamanKendaraan->pemohon }}">{{ $peminjamanKendaraan->fPemohon->nama }}</option>
                  @foreach ($pegawais as $pegawai)
                    <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
                  @endforeach
                </select>
                @error('pemohon')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Substansi <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="substansi" placeholder="Enter Substansi" required value="{{ $peminjamanKendaraan->substansi }}">
                @error('substansi')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Penanggung Jawab <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="penanggung_jawab" data-placeholder="Pilih Penanggung Jawab" required>
                  <option value="{{ $peminjamanKendaraan->penanggung_jawab }}">{{ $peminjamanKendaraan->fPenanggungJawab->pegawai->nama }}</option>
                  @foreach ($penanggungJawabs as $penanggungJawab)
                    <option value="{{ $penanggungJawab->id }}">{{ $penanggungJawab->pegawai->nama }}</option>
                  @endforeach
                </select>
                @error('penanggung_jawab')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Petugas BMN <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="verifikator" data-placeholder="Pilih Verifikator" required>
                  <option value="{{ $peminjamanKendaraan->verifikator }}">{{ $peminjamanKendaraan->fVerif->pegawai->nama }}</option>
                  @foreach ($verifikators as $verifikator)
                    <option value="{{ $verifikator->id }}">{{ $verifikator->pegawai->nama }}</option>
                  @endforeach
                </select>
                @error('verifikator')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-12">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Kendaraan <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="kendaraan_id" data-placeholder="Pilih Kendaraan" required>
                  <option value="{{ $peminjamanKendaraan->kendaraan_id }}">{{ $peminjamanKendaraan->kendaraan->merek . " " . $peminjamanKendaraan->kendaraan->nama}} | <b>{{ $peminjamanKendaraan->kendaraan->no_polisi }}</b></option>
                  @foreach ($kendaraans as $kendaraan)
                    <option value="{{ $kendaraan->id }}">{{ $kendaraan->merek . " " . $kendaraan->nama}} | <b>{{ $kendaraan->no_polisi }}</b></option>
                  @endforeach
                </select>
                @error('kendaraan_id')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-12 -->
            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Tanggal/Jam Penggunaan <span class="tx-danger">*</span></label>
                <input class="form-control" type="datetime-local" name="tanggal_penggunaan" placeholder="Enter Tanggal Penggunaan" required value="{{ $peminjamanKendaraan->tanggal_penggunaan }}">
                @error('tanggal_penggunaan')  
                <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label">Tanggal/Jam Selesai <span class="tx-danger">*</span></label>
                <input class="form-control" type="datetime-local" name="tanggal_selesai" placeholder="Enter Tanggal Selesai" required value="{{ $peminjamanKendaraan->tanggal_selesai }}">
                @error('tanggal_selesai')  
                <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Keperluan <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="keperluan" placeholder="Enter Keperluan" required value="{{ $peminjamanKendaraan->keperluan }}">
                @error('keperluan')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Status <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="status" data-placeholder="Pilih Status" required>
                  <option value="{{ $peminjamanKendaraan->status }}">{{ $peminjamanKendaraan->status }}</option>
                  {{-- <option value="Draf">Draf</option> --}}
                  <option value="Pengajuan">Pengajuan</option>
                  <option value="Diterima">Diterima</option>
                  <option value="Disetujui">Disetujui</option>
                  <option value="Ditolak">Ditolak</option>
                </select>
                @error('status')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->

            <div class="col-md-12">
              <div class="form-group bd-t-0-force mg-md-r--1">
                <label class="form-control-label"> Tanda Tangan <span class="tx-danger">*</span></label>
                <div class="d-md-flex align-items-enter">
                  <canvas id="signature-pad" class="bd signature-pad"></canvas>
                  <input type="hidden" name="signature_pemohon" id="signature_pemohon" required>
                  <button type="button" onclick="clearPad()" class="btn btn-danger ml-md-2"><i class="bi bi-trash"></i></button>
                </div>
                {{-- <button type="button"  class="btn btn-danger btn-hapus"><i class="bi bi-trash"></i></button> --}}
              </div>
            </div><!-- col-12 -->

          </div><!-- row -->
          <div class="form-layout-footer bd pd-20 bd-t-0">
            <button type="submit" class="btn btn-warning">Update Form</button>
            <a href="/manage/peminjamanKendaraan" class="btn btn-secondary">Cancel</a>
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
        // Kosongkan nilai input hidden
        document.getElementById('signature_pemohon').value = '';
      } else {
        // Kalau tidak kosong, simpan ke input hidden
        const dataURL = signaturePad.toDataURL();
        document.getElementById('signature_pemohon').value = dataURL;
      }
    });
  </script>

@endpush