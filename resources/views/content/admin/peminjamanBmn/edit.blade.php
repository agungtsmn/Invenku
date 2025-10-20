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
        <a class="breadcrumb-item" href="/manage/peminjamanBmn">Manage</a>
        <a class="breadcrumb-item" href="/manage/peminjamanBmn">Peminjaman BMN</a>
        <span class="breadcrumb-item active">Edit</span>
      </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
      <h4 class="tx-gray-800 mg-b-5">Edit Peminjaman BMN</h4>
      <p class="mg-b-0">Edit peminjaman BMN to the database</p>
    </div>

    <div class="br-pagebody">
      <div class="br-section-wrapper">

        <form id="signature-form" class="form-layout form-layout-2" action="/manage/peminjamanBmn/{{ $peminjamanBmn->id }}" method="post">
          @csrf
          @method('put')
          <div class="row no-gutters">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label mg-b-0-force">Pemohon <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="pemohon" data-placeholder="Pilih Pegawai" required>
                  <option value="{{ $peminjamanBmn->pemohon }}">{{ $peminjamanBmn->fPemohon->nama }}</option>
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
              <div class="form-group mg-md-l--1 bd-l-0-force">
                <label class="form-control-label mg-b-0-force">Penanggung Jawab <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="penanggung_jawab" data-placeholder="Pilih Penanggung Jawab" required>
                  <option value="{{ $peminjamanBmn->penanggung_jawab }}">{{ $peminjamanBmn->fPenanggungJawab->pegawai->nama }}</option>
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
              <div class="form-group bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Petugas BMN <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="verifikator" data-placeholder="Pilih Verifikator" required>
                  <option value="{{ $peminjamanBmn->verifikator }}">{{ $peminjamanBmn->fVerif->pegawai->nama }}</option>
                  @foreach ($verifikators as $verifikator)
                    <option value="{{ $verifikator->id }}">{{ $verifikator->pegawai->nama }}</option>
                  @endforeach
                </select>
                @error('verifikator')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Status <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="status" data-placeholder="Pilih Status" required>
                  <option value="{{ $peminjamanBmn->status }}">{{ $peminjamanBmn->status }}</option>
                  <option value="Draf">Draf</option>
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
            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Lama Pinjam (Hari) <span class="tx-danger">*</span></label>
                <input class="form-control" type="number" name="lama_pinjam" placeholder="Enter Lama Pinjam" required value="{{ $peminjamanBmn->lama_pinjam }}">
                @error('lama_pinjam')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label">Lokasi Penggunaan <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="lokasi_penggunaan" placeholder="Enter Lokasi Penggunaan" required value="{{ $peminjamanBmn->lokasi_penggunaan }}">
                @error('lokasi_penggunaan')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->

            <div class="col-md-12" id="col-bmn"> <!-- Col BMN -->
              @foreach ($peminjamanBmn->bmn as $bmn)
                <div class="row no-gutters row-bmn"> <!-- Row BMN -->
                  <div class="col-md-2">
                    <div class="form-group bd-t-0-force">
                      <label class="form-control-label"> Jenis BMN <span class="tx-danger">*</span></label>
                      <input class="form-control" type="text" name="jenis[]" placeholder="Enter Jenis BMN" required value="{{ $bmn['jenis'] }}">
                    </div>
                  </div><!-- col-2 -->
                  <div class="col-md-2">
                    <div class="form-group bd-t-0-force mg-md-l--1">
                      <label class="form-control-label"> Merek <span class="tx-danger">*</span></label>
                      <input class="form-control" type="text" name="merek[]" placeholder="Enter Merek" required value="{{ $bmn['merek'] }}">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-md-2">
                    <div class="form-group bd-t-0-force mg-md-l--1">
                      <label class="form-control-label"> NUP <span class="tx-danger">*</span></label>
                      <input class="form-control" type="text" name="nup[]" placeholder="Enter NUP" required value="{{ $bmn['nup'] }}">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-md-2">
                    <div class="form-group bd-t-0-force mg-md-l--1">
                      <label class="form-control-label"> Jumlah <span class="tx-danger">*</span></label>
                      <input class="form-control" type="number" name="jumlah[]" placeholder="Enter Jumlah" required value="{{ $bmn['jumlah'] }}">
                    </div>
                  </div><!-- col-2 -->
                  <div class="col-md-2">
                    <div class="form-group bd-t-0-force mg-md-l--1">
                      <label class="form-control-label"> Satuan <span class="tx-danger">*</span></label>
                      <input class="form-control" type="text" name="satuan[]" placeholder="Enter Satuan" required value="{{ $bmn['satuan'] }}">
                    </div>
                  </div><!-- col-2 -->
                  <div class="col-md-2">
                    <div class="form-group bd-t-0-force mg-md-l--1 mg-md-r--1 text-center">
                      <button type="button" class="btn btn-teal btn-tambah mr-2"><i class="bi bi-plus-lg"></i></button>
                      <button type="button" class="btn btn-danger btn-hapus"><i class="bi bi-trash"></i></button>
                    </div>
                  </div><!-- col-3 -->
                </div>
              @endforeach
            </div><!-- col-12 -->
          
            <div class="col-md-12">
              <div class="form-group bd-t-0-force mg-md-r--1">
                <label class="form-control-label"> Tanda Tangan <span class="tx-danger">*</span></label>
                <div class="d-flex align-items-enter">
                  <canvas id="signature-pad" class="bd"></canvas>
                  <input type="hidden" name="signature_pemohon" id="signature_pemohon" required>
                  <button type="button" onclick="clearPad()" class="btn btn-danger ml-2"><i class="bi bi-trash"></i></button>
                </div>
                {{-- <button type="button"  class="btn btn-danger btn-hapus"><i class="bi bi-trash"></i></button> --}}
              </div>
            </div><!-- col-12 -->

          </div><!-- row -->
          <div class="form-layout-footer bd pd-20 bd-t-0">
            <button type="submit" class="btn btn-info">Submit Form</button>
            <a href="/manage/peminjamanBmn" class="btn btn-secondary">Cancel</a>
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

  <script>
    $(document).ready(function () {
      // Tambah baris
      $(document).on('click', '.btn-tambah', function () {
        const parent = $(this).closest('#col-bmn');
        const newRow = parent.find('.row-bmn').first().clone();

        // Kosongkan nilai input di row yang dikloning
        newRow.find('input').val('');

        // Append row baru
        parent.append(newRow);
      });

      // Hapus baris
      $(document).on('click', '.btn-hapus', function () {
        const parent = $(this).closest('#col-bmn');
        const rowCount = parent.find('.row-bmn').length;

        // Hapus hanya jika jumlah baris lebih dari 1
        if (rowCount > 1) {
          $(this).closest('.row-bmn').remove();
        } else {
          alert('Minimal harus ada satu baris input.');
        }
      });
    });
  </script>

@endpush