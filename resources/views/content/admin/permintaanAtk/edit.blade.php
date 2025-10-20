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
        <a class="breadcrumb-item" href="/manage/permintaanAtk">Manage</a>
        <a class="breadcrumb-item" href="/manage/permintaanAtk">Permintaan ATK / Suvenir</a>
        <span class="breadcrumb-item active">Edit</span>
      </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
      <h4 class="tx-gray-800 mg-b-5">Edit Permintaan ATK / Suvenir</h4>
      <p class="mg-b-0">Edit permintaan ATK / Suvenir in the database</p>
    </div>

    <div class="br-pagebody">
      <div class="br-section-wrapper">

        <form id="signature-form" class="form-layout form-layout-2" action="/manage/permintaanAtk/{{ $permintaanAtk->id }}" method="post">
          @csrf
          @method('put')
          <div class="row no-gutters">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label mg-b-0-force"> Pemohon <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="pemohon" data-placeholder="Pilih Pegawai" required>
                  <option value="{{ $permintaanAtk->pemohon }}">{{ $permintaanAtk->fPemohon->nama }}</option>
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
                <label class="form-control-label mg-b-0-force">Penanggung Jawab <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="penanggung_jawab" data-placeholder="Pilih Penanggung Jawab" required>
                  <option value="{{ $permintaanAtk->penanggung_jawab }}">{{ $permintaanAtk->fPenanggungJawab->pegawai->nama }}</option>
                  @foreach ($penanggungJawabs as $penanggungJawab)
                    <option value="{{ $penanggungJawab->id }}">{{ $penanggungJawab->nama }}</option>
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
                <select class="form-control select2-show-search" name="verifikator" data-placeholder="Pilih Petugas BMN" required>
                  <option value="{{ $permintaanAtk->verifikator }}">{{ $permintaanAtk->fVerif->pegawai->nama }}</option>
                  @foreach ($verifikators as $verifikator)
                    <option value="{{ $verifikator->id }}">{{ $verifikator->nama }}</option>
                  @endforeach
                </select>
                @error('verifikator')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Jenis <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="jenis" data-placeholder="Pilih Jenis" required>
                  <option value="{{ $permintaanAtk->jenis }}">{{ $permintaanAtk->jenis }}</option>
                  <option value="ATK">ATK</option>
                  <option value="Suvenir">Suvenir</option>
                </select>
                @error('jenis')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Tanggal <span class="tx-danger">*</span></label>
                <input class="form-control" type="date" name="tanggal" placeholder="Enter Tanggal" required value="{{ $permintaanAtk->tanggal }}">
                @error('tanggal')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-6">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label">Lokasi <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="lokasi" placeholder="Enter Lokasi" required value="{{ $permintaanAtk->lokasi }}">
                @error('lokasi')  
                  <span style="color: #ed5646; font-size: 12px">{{ $message }}</span>
                @enderror
              </div>
            </div><!-- col-6 -->
            <div class="col-md-12">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Status <span class="tx-danger">*</span></label>
                <select class="form-control select2-show-search" name="status" data-placeholder="Pilih Status" required>
                  <option value="{{ $permintaanAtk->status }}">{{ $permintaanAtk->status }}</option>
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
            </div><!-- col-12 -->

            <div class="col-md-12" id="col-atk"> <!-- Col ATK -->
              @foreach ($permintaanAtk->atk as $atk)
                <div class="row no-gutters row-atk"> <!-- Row ATK -->
                  <div class="col-md-3">
                    <div class="form-group bd-t-0-force">
                      <label class="form-control-label"> Nama ATK / Suvenir <span class="tx-danger">*</span></label>
                      <input class="form-control" type="text" name="nama[]" placeholder="Enter Nama ATK / Suvenir" required value="{{ $atk['nama'] }}">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-md-2">
                    <div class="form-group bd-t-0-force mg-md-l--1">
                      <label class="form-control-label"> Jumlah <span class="tx-danger">*</span></label>
                      <input class="form-control" type="text" name="jumlah[]" placeholder="Enter Jumlah" required value="{{ $atk['jumlah'] }}">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-md-2">
                    <div class="form-group bd-t-0-force mg-md-l--1">
                      <label class="form-control-label"> Satuan <span class="tx-danger">*</span></label>
                      <input class="form-control" type="text" name="satuan[]" placeholder="Enter Satuan" required value="{{ $atk['satuan'] }}">
                    </div>
                  </div><!-- col-3 -->
                  <div class="col-md-3">
                    <div class="form-group bd-t-0-force mg-md-l--1">
                      <label class="form-control-label"> Lokasi Penggunaan <span class="tx-danger">*</span></label>
                      <input class="form-control" type="text" name="spesifikasi[]" placeholder="Enter Spesifikasi" required value="{{ $atk['spesifikasi'] }}">
                    </div>
                  </div><!-- col-3 -->
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
                  <input type="hidden" name="signature_pemohon" id="signature">
                  <button type="button" onclick="clearPad()" class="btn btn-danger ml-2"><i class="bi bi-trash"></i></button>
                </div>
              </div>
            </div><!-- col-12 -->
          </div><!-- row -->
          <div class="form-layout-footer bd pd-20 bd-t-0">
            <button type="submit" class="btn btn-warning">Update Form</button>
            <a href="/manage/permintaanAtk" class="btn btn-secondary">Cancel</a>
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
        document.getElementById('signature').value = '';
      } else {
        // Kalau tidak kosong, simpan ke input hidden
        const dataURL = signaturePad.toDataURL();
        document.getElementById('signature').value = dataURL;
      }
    });
  </script>

  <script>
    $(document).ready(function () {
      // Tambah baris
      $(document).on('click', '.btn-tambah', function () {
        const parent = $(this).closest('#col-atk');
        const newRow = parent.find('.row-atk').first().clone();

        // Kosongkan nilai input di row yang dikloning
        newRow.find('input').val('');

        // Append row baru
        parent.append(newRow);
      });

      // Hapus baris
      $(document).on('click', '.btn-hapus', function () {
        const parent = $(this).closest('#col-atk');
        const rowCount = parent.find('.row-atk').length;

        // Hapus hanya jika jumlah baris lebih dari 1
        if (rowCount > 1) {
          $(this).closest('.row-atk').remove();
        } else {
          alert('Minimal harus ada satu baris input.');
        }
      });
    });
  </script>

@endpush