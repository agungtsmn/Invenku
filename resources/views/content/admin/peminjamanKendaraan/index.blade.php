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
        <a class="breadcrumb-item" href="/manage/peminjamanKendaraan">Manage</a>
        <span class="breadcrumb-item active">Peminjaman Kendaraan</span>
      </nav>
    </div><!-- br-pageheader -->
    
    @include('partials.crud-alert')

    <div class="pd-x-20 pd-sm-x-30 pd-t-2 d-flex align-items-center justify-content-between flex-wrap">
      <div>
        <h4 class="tx-gray-800 mg-b-5">Management Peminjaman Kendaraan</h4>
        <p class="mg-b-0">Menambah, Mengedit, dan Menghapus Data Peminjaman Kendaraan</p>
      </div>
      <a href="/manage/peminjamanKendaraan/create" class="btn btn-teal btn-create">Create Data <i class="bi bi-plus"></i></a>
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
                <th class="wd-20p">Kendaraan</th>
                <th class="wd-20p">Keperluan</th>
                <th class="wd-15p text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($peminjamanKendaraans as $peminjamanKendaraan)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    {{ $peminjamanKendaraan->fPemohon->nama }} <br>
                    <span class="tx-12 tx-teal">{{ $peminjamanKendaraan->substansi }}</span><br>
                    <span class="tx-12">Petugas : {{ $peminjamanKendaraan->fPetugas->pegawai->nama ?? '-' }}</span>
                  </td>
                  <td>
                    {{ $peminjamanKendaraan->fPenanggungJawab->pegawai->nama }} <br>
                    <span class="tx-12">{{ $peminjamanKendaraan->fVerif->pegawai->nama }}</span>
                  </td>
                  <td>
                    <div class="mb-1">
                      @if ($peminjamanKendaraan->status == "Draf")
                        <span class="px-3 py-1 tx-12 bg-secondary text-light rounded">{{ $peminjamanKendaraan->status }}</span>
                      @elseif ($peminjamanKendaraan->status == "Pengajuan")
                        <span class="px-2 py-1 tx-12 bg-warning text-light rounded">{{ $peminjamanKendaraan->status }}</span>
                      @elseif ($peminjamanKendaraan->status == "Diterima")
                        <span class="px-2 py-1 tx-12 bg-info text-light rounded">{{ $peminjamanKendaraan->status }}</span>
                      @elseif ($peminjamanKendaraan->status == "Disetujui")
                        <span class="px-2 py-1 tx-12 bg-success text-light rounded">{{ $peminjamanKendaraan->status }}</span>
                      @elseif ($peminjamanKendaraan->status == "Ditolak")
                        <span class="px-2 py-1 tx-12 bg-danger text-light rounded">{{ $peminjamanKendaraan->status }}</span>
                      @endif
                      <a target="_blank" href="/peminjamanKendaraan/{{ $peminjamanKendaraan->id }}/pdf" class="px-2 py-1 tx-12 bg-info text-light rounded"><i class="bi bi-filetype-pdf"></i> Pdf</a>
                    </div>
                    <span class="tx-12">{{ $peminjamanKendaraan->nomor }}</span>
                  </td>
                  <td>
                    <span class="tx-teal">{{ $peminjamanKendaraan->kendaraan->merek . " " . $peminjamanKendaraan->kendaraan->nama}} | <b>{{ $peminjamanKendaraan->kendaraan->no_polisi }}</span><br>
                    <span class="tx-12">{{ \Carbon\Carbon::parse($peminjamanKendaraan->tanggal_penggunaan)->translatedFormat('d M Y - H.i') }}</span><br>
                    <span class="tx-12">{{ \Carbon\Carbon::parse($peminjamanKendaraan->tanggal_selesai)->translatedFormat('d M Y - H.i') }}</span>
                  </td>
                  <td>{{ $peminjamanKendaraan->keperluan }}</td>
                  <td>
                    <div class="d-flex flex-column justify-content-center align-items-center">
                      <a href="/manage/peminjamanKendaraan/{{ $peminjamanKendaraan->id }}/edit" class="btn btn-warning tx-10 pd-x-15 pd-y-5 mb-2"><i class="bi bi-pen mr-1"></i> Edit</a>
                      <div data-kode="{{ $peminjamanKendaraan->id }}" class="btn btn-danger tx-10 pd-x-10 pd-y-5 swal-confirm">
                        <form action="/manage/peminjamanKendaraan/{{ $peminjamanKendaraan->id }}" id="delete{{ $peminjamanKendaraan->id }}" method="post">
                            @csrf
                            @method('delete')
                        </form>
                        <i class="bi bi-trash mr-1"></i>
                        Delete
                      </div>
                    </div>
                  </td>
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