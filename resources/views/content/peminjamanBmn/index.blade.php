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
        <span class="breadcrumb-item active">Peminjaman BMN</span>
      </nav>
    </div><!-- br-pageheader -->
    
    @include('partials.crud-alert')

    <div class="pd-x-20 pd-sm-x-30 pd-t-2 d-flex align-items-center justify-content-between flex-wrap">
      <div>
        <h4 class="tx-gray-800 mg-b-5">Peminjaman BMN</h4>
        <p class="mg-b-0">Pengajuan Peminjaman BMN</p>
      </div>
      @if (Auth::user()->role == "Petugas")
        <a href="/peminjamanBmn/create" class="btn btn-teal btn-create">Buat Pengajuan <i class="bi bi-plus"></i></a>
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
                <th class="wd-15p">Status & Nomor</th>
                <th class="wd-15p text-center">BMN</th>
                <th class="wd-15p">Durasi & Lokasi</th>
                <th class="wd-15p text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($peminjamanBmns as $peminjamanBmn)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    {{ $peminjamanBmn->fPemohon->nama }} <br>
                    <span class="tx-12 tx-teal">Petugas : {{ $peminjamanBmn->fPetugas->pegawai->nama ?? '-' }}</span>
                  </td>
                  <td>
                    {{ $peminjamanBmn->fPenanggungJawab->pegawai->nama }} <br>
                    <span class="tx-12">{{ $peminjamanBmn->fVerif->pegawai->nama }}</span>
                  </td>
                  <td>
                    <div class="mb-1">
                      @if ($peminjamanBmn->status == "Draf")
                        <span class="px-3 py-1 tx-12 bg-secondary text-light rounded">{{ $peminjamanBmn->status }}</span>
                      @elseif ($peminjamanBmn->status == "Pengajuan")
                        <span class="px-2 py-1 tx-12 bg-warning text-light rounded">{{ $peminjamanBmn->status }}</span>
                      @elseif ($peminjamanBmn->status == "Diterima")
                        <span class="px-2 py-1 tx-12 bg-info text-light rounded">{{ $peminjamanBmn->status }}</span>
                      @elseif ($peminjamanBmn->status == "Disetujui")
                        <span class="px-2 py-1 tx-12 bg-success text-light rounded">{{ $peminjamanBmn->status }}</span>
                      @elseif ($peminjamanBmn->status == "Selesai")
                        <span class="px-2 py-1 tx-12 bg-indigo text-light rounded">{{ $peminjamanBmn->status }}</span>
                      @elseif ($peminjamanBmn->status == "Ditolak")
                        <span class="px-2 py-1 tx-12 bg-danger text-light rounded">{{ $peminjamanBmn->status }}</span>
                      @endif
                      <a target="_blank" href="/peminjamanBmn/{{ $peminjamanBmn->id }}/pdf" class="px-2 py-1 tx-12 bg-info text-light rounded"><i class="bi bi-filetype-pdf"></i> Pdf</a>
                    </div>
                    <span class="tx-12">{{ $peminjamanBmn->nomor }}</span>
                  </td>
                  <td class="text-center">
                    <a class="btn btn-teal tx-10 pd-x-10 pd-y-5 text-light tx-medium" data-toggle="modal" data-target="#modaldemo{{ $peminjamanBmn->id }}">Detail BMN</a>
                    {{-- Modal BMN --}}
                    <div id="modaldemo{{ $peminjamanBmn->id }}" class="modal fade">
                      <div class="modal-dialog modal-lg w-100" role="document">
                        <div class="modal-content bd-0 tx-14">
                          <div class="modal-header pd-x-20">
                            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detail BMN</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body pd-20">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Jenis BMN</th>
                                  <th>Merek</th>
                                  <th>NUP</th>
                                  <th>Jumlah</th>
                                  <th>Kesediaan</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($peminjamanBmn->bmn as $bmn)
                                  <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bmn['jenis'] }}</td>
                                    <td>{{ $bmn['merek'] }}</td>
                                    <td>{{ $bmn['nup'] }}</td>
                                    <td>{{ $bmn['jumlah'] . ' ' . $bmn['satuan'] }}</td>
                                    @if (isset($bmn['kesediaan']))
                                      @if ($bmn['kesediaan'] == 'Tersedia')
                                        <td><i class="bi bi-patch-check-fill tx-success"></i> {{ $bmn['kesediaan'] }}</td>
                                      @else
                                        <td><i class="bi bi-patch-exclamation-fill tx-danger"></i> {{ $bmn['kesediaan'] }}</td>
                                      @endif
                                    @else
                                      <td><i class="bi bi-patch-question-fill tx-warning"></i></td>
                                    @endif
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                          <div class="modal-footer justify-content-end">
                            <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div><!-- modal-dialog -->
                    </div><!-- modal -->
                  </td>
                  <td>
                    {{ $peminjamanBmn->lama_pinjam }} Hari
                    @php
                      $tanggalPinjam = \Carbon\Carbon::parse($peminjamanBmn->updated_at);
                      $batasWaktu = $tanggalPinjam->copy()->addDays($peminjamanBmn->lama_pinjam);
                      $hariIni = \Carbon\Carbon::now();
                      $selisihHari = $hariIni->diffInDays($batasWaktu, false);
                    @endphp

                    @if ($peminjamanBmn->status == 'Disetujui' && $selisihHari < 0)
                      <span class="text-light btn btn-oblong tx-12 bg-warning py-1 px-2"><i class="bi bi-exclamation-diamond-fill"></i> Terlambat {{ intval(abs($selisihHari)) }} hari!</span> 
                    @endif
                    <br>
                    <span class="tx-12">{{ $peminjamanBmn->lokasi_penggunaan }}</span>
                  </td>
                  @if (Auth::user()->role == 'Petugas')
                    <td>
                      <div class="d-flex flex-column justify-content-center align-items-center">
                        @if ($peminjamanBmn->status == 'Draf')
                          <a href="/peminjamanBmn/{{ $peminjamanBmn->id }}/edit" class="btn btn-warning tx-10 pd-x-15 pd-y-5 mb-2"><i class="bi bi-pen mr-1"></i> Edit</a>
                          <div data-kode="{{ $peminjamanBmn->id }}" class="btn btn-danger tx-10 pd-x-10 pd-y-5 swal-confirm">
                            <form action="/peminjamanBmn/{{ $peminjamanBmn->id }}" id="delete{{ $peminjamanBmn->id }}" method="post">
                              @csrf
                              @method('delete')
                            </form>
                            <i class="bi bi-trash mr-1"></i>
                            Delete
                          </div>
                        @endif
                      </div>
                    </td>
                  @endif
                  @if (Auth::user()->role == 'Penanggung Jawab')
                    <td class="text-center">
                      <a href="/peminjamanBmn/{{ $peminjamanBmn->id }}/check" class="btn btn-warning tx-14 pd-x-15 pd-y-7"><i class="bi bi-clipboard-check"></i> Setujui</a>
                    </td>
                  @endif
                  @if (Auth::user()->role == 'Verifikator')
                    <td class="text-center">
                      <a href="/peminjamanBmn/{{ $peminjamanBmn->id }}/verifing" class="btn btn-teal tx-14 pd-x-12 pd-y-7"><i class="bi bi-patch-check"></i> Verifikasi</a>
                    </td>
                  @endif
                  @if (Auth::user()->role == 'Kasubag TU')
                    <td class="text-center">
                      @if ($peminjamanBmn->status == 'Diterima')
                        <a href="/peminjamanBmn/{{ $peminjamanBmn->id }}/approval" class="btn btn-warning tx-14 pd-x-12 pd-y-7"><i class="bi bi-clipboard-check"></i> Aproval</a>
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