@extends('layout.main')

@push('css')
  <!-- vendor css -->
  <link href="{{ asset('template') }}/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/Ionicons/css/ionicons.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/highlightjs/github.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/datatables/jquery.dataTables.css" rel="stylesheet">
  <link href="{{ asset('template') }}/lib/select2/css/select2.min.css" rel="stylesheet">

  <!-- Bracket CSS -->
  <link rel="stylesheet" href="{{ asset('template') }}/css/bracket.css">

  <style>
    .btn-create{
      margin-top: 15px;
    }

    @media (min-width: 575.98px) {
      .btn-create{
        margin-top: 0px;
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
        <span class="breadcrumb-item active">Peminjaman Ruang</span>
      </nav>
    </div><!-- br-pageheader -->
    
    @include('partials.crud-alert')

    <div class="pd-x-20 pd-sm-x-30 pd-t-2 d-flex align-items-center justify-content-between flex-wrap">
      <div>
        <h4 class="tx-gray-800 mg-b-5">Peminjaman Ruang</h4>
        <p class="mg-b-0">Pengajuan Peminjaman Ruang</p>
      </div>
      @if (Auth::user()->role == 'Petugas')  
        <a href="/peminjamanRuang/create" class="btn btn-teal btn-create">Buat Pengajuan <i class="bi bi-plus"></i></a>
      @endif
    </div>

    <div class="br-pagebody">
      <div class="br-section-wrapper">
        {{-- <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Basic Responsive DataTable</h6>
        <p class="mg-b-25 mg-lg-b-50">Searching, ordering and paging goodness will be immediately added to the table, as shown in this example.</p> --}}

        <div class="table-wrapper">
          <table id="datatable1" class="table display responsive nowrap">
            <thead>
              <tr>
                <th class="wd-5p text-center">No</th>
                <th class="wd-20p">Pemohon</th>
                <th class="wd-20p">Mengetahui</th>
                <th class="wd-20p">Status & Nomor</th>
                <th class="wd-20p">Ruang</th>
                <th class="wd-20p">Alat Khusus</th>
                <th class="wd-15p text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($peminjamanRuangs as $peminjamanRuang)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    {{ $peminjamanRuang->fPemohon->nama }} <br>
                    <span class="tx-12 tx-teal">{{ $peminjamanRuang->substansi }}</span><br>
                    <span class="tx-12">Petugas : {{ $peminjamanRuang->fPetugas->pegawai->nama ?? '-' }}</span>
                  </td>
                  <td>
                    {{ $peminjamanRuang->fPenanggungJawab->pegawai->nama }} <br>
                    <span class="tx-12">{{ $peminjamanRuang->fVerif->pegawai->nama }}</span>
                  </td>
                  <td>
                    @if ($peminjamanRuang->status == "Draf")
                      <span class="px-3 py-1 tx-12 bg-secondary text-light rounded">{{ $peminjamanRuang->status }}</span>
                    @elseif ($peminjamanRuang->status == "Pengajuan")
                      <span class="px-2 py-1 tx-12 bg-warning text-light rounded">{{ $peminjamanRuang->status }}</span>
                    @elseif ($peminjamanRuang->status == "Diterima")
                      <span class="px-2 py-1 tx-12 bg-info text-light rounded">{{ $peminjamanRuang->status }}</span>
                    @elseif ($peminjamanRuang->status == "Disetujui")
                      <span class="px-2 py-1 tx-12 bg-success text-light rounded">{{ $peminjamanRuang->status }}</span>
                    @elseif ($peminjamanRuang->status == "Ditolak")
                      <span class="px-2 py-1 tx-12 bg-danger text-light rounded">{{ $peminjamanRuang->status }}</span>
                    @endif
                    <a target="_blank" href="/peminjamanRuang/{{ $peminjamanRuang->id }}/pdf" class="px-2 py-1 tx-12 bg-info text-light rounded"><i class="bi bi-filetype-pdf"></i> Pdf</a> <br>
                    <span class="tx-12">{{ $peminjamanRuang->nomor }}</span>
                  </td>
                  <td>
                    <span class="tx-teal">{{ $peminjamanRuang->ruang->nama }}</span><br>
                    <span class="tx-12">{{ \Carbon\Carbon::parse($peminjamanRuang->tanggal_penggunaan)->translatedFormat('d M Y - H.i') }}</span><br>
                    <span class="tx-12">{{ \Carbon\Carbon::parse($peminjamanRuang->tanggal_selesai)->translatedFormat('d M Y - H.i') }}</span>
                  </td>
                  <td class="pb-0">
                    <ul class="pl-3">
                      {{-- <li></li> --}}
                      @foreach (json_decode($peminjamanRuang->alat_khusus, true) as $alat_khusus)
                        @if ($alat_khusus != null)
                          <li><span class="tx-12">{{ $alat_khusus }}</span></li>
                        @endif
                      @endforeach
                    </ul>
                  </td>
                  @if (Auth::user()->role == 'Petugas')
                    <td>
                      <div class="d-flex flex-column justify-content-center align-items-center">
                        @if ($peminjamanRuang->status == "Draf")  
                          <a href="/peminjamanRuang/{{ $peminjamanRuang->id }}/edit" class="btn btn-warning tx-10 pd-x-15 pd-y-5 mb-2"><i class="bi bi-pen mr-1"></i> Edit</a>
                        @endif
                        <div data-kode="{{ $peminjamanRuang->id }}" class="btn btn-danger tx-10 pd-x-10 pd-y-5 swal-confirm">
                          <form action="/peminjamanRuang/{{ $peminjamanRuang->id }}" id="delete{{ $peminjamanRuang->id }}" method="post">
                              @csrf
                              @method('delete')
                          </form>
                          <i class="bi bi-trash mr-1"></i>
                          Delete
                        </div>
                      </div>
                    </td>
                  @endif
                  @if (Auth::user()->role == 'Penanggung Jawab')
                    <td class="text-center">
                      {{-- <a href="/peminjamanRuang/{{ $peminjamanRuang->id }}/check" class="btn btn-warning tx-14 pd-x-15 pd-y-7"><i class="bi bi-clipboard-check"></i> Setujui</a> --}}
                    </td>
                  @endif
                  @if (Auth::user()->role == 'Verifikator')
                    <td class="text-center">
                      <a href="/peminjamanRuang/{{ $peminjamanRuang->id }}/verifing" class="btn btn-teal tx-14 pd-x-12 pd-y-7"><i class="bi bi-patch-check"></i> Verifikasi</a>
                    </td>
                  @endif
                  @if (Auth::user()->role == 'Kasubag TU')
                    <td class="text-center">
                      @if ($peminjamanRuang->status == 'Diterima')
                        <a href="/peminjamanRuang/{{ $peminjamanRuang->id }}/approval" class="btn btn-warning tx-14 pd-x-12 pd-y-7"><i class="bi bi-clipboard-check"></i> Aproval</a>
                      @else
                        <i class="bi bi-patch-check-fill tx-success mr-1"></i>
                      @endif
                    </td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- table-wrapper -->

      </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->

    @include('partials.footer')

  </div><!-- br-mainpanel -->
  <!-- ########## END: MAIN PANEL ########## -->
@endsection

@push('js')
  {{-- sweetalert2 --}}
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script src="{{ asset('template') }}/lib/jquery/jquery.js"></script>
  <script src="{{ asset('template') }}/lib/popper.js/popper.js"></script>
  <script src="{{ asset('template') }}/lib/bootstrap/bootstrap.js"></script>
  <script src="{{ asset('template') }}/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
  <script src="{{ asset('template') }}/lib/moment/moment.js"></script>
  <script src="{{ asset('template') }}/lib/jquery-ui/jquery-ui.js"></script>
  <script src="{{ asset('template') }}/lib/jquery-switchbutton/jquery.switchButton.js"></script>
  <script src="{{ asset('template') }}/lib/peity/jquery.peity.js"></script>
  <script src="{{ asset('template') }}/lib/highlightjs/highlight.pack.js"></script>
  <script src="{{ asset('template') }}/lib/datatables/jquery.dataTables.js"></script>
  <script src="{{ asset('template') }}/lib/datatables-responsive/dataTables.responsive.js"></script>
  <script src="{{ asset('template') }}/lib/select2/js/select2.min.js"></script>

  <script src="{{ asset('template') }}/js/bracket.js"></script>
  <script>
    $(function(){
      'use strict';

      $('#datatable1').DataTable({
        responsive: true,
        language: {
          searchPlaceholder: 'Search...',
          sSearch: '',
          lengthMenu: '_MENU_ items/page',
        }
      });

      $('#datatable2').DataTable({
        bLengthChange: false,
        searching: false,
        responsive: true
      });

      // Select2
      $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    });
  </script>
  <script>
    $(".swal-confirm").click(function(e) {
        id = e.target.dataset.kode;
        if (id) {
            Swal.fire({
                title: 'Anda yakin ingin menghapus?',
                text: "Jika sudah terhapus data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F5365C',
                cancelButtonColor: '#2DCE89',
                confirmButtonText: 'Iya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete' + id).submit();
                }
            });
        }
    });
  </script>
@endpush