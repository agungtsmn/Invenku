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
        <span class="breadcrumb-item active">Permintaan ATK / Suvenir</span>
      </nav>
    </div><!-- br-pageheader -->
    
    @include('partials.crud-alert')

    <div class="pd-x-20 pd-sm-x-30 pd-t-2 d-flex align-items-center justify-content-between flex-wrap">
      <div>
        <h4 class="tx-gray-800 mg-b-5">Permintaan ATK / Suvenir</h4>
        <p class="mg-b-0">Pengajuan Permintaan ATK / Suvenir</p>
      </div>
      @if (Auth::user()->role == 'Petugas')  
        <a href="/permintaanAtk/create" class="btn btn-teal btn-create">Buat Pengajuan <i class="bi bi-plus"></i></a>
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
                <th class="wd-20p text-center">ATK / Suvenir</th>
                <th class="wd-15p text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($permintaanAtks as $permintaanAtk)
                <tr>
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    {{ $permintaanAtk->fPemohon->nama }} <br>
                    <span class="tx-12">{{ $permintaanAtk->fPetugas->pegawai->nama }} ( {{ $permintaanAtk->fPetugas->role }} )</span>
                  </td>
                  <td>
                    {{ $permintaanAtk->fPenanggungJawab->pegawai->nama }} <br>
                    <span class="tx-12">{{ $permintaanAtk->fVerif->pegawai->nama }}</span>
                  </td>
                  <td>
                    @if ($permintaanAtk->status == "Draf")
                      <span class="px-3 py-1 tx-12 bg-secondary text-light rounded">{{ $permintaanAtk->status }}</span>
                    @elseif ($permintaanAtk->status == "Pengajuan")
                      <span class="px-2 py-1 tx-12 bg-warning text-light rounded">{{ $permintaanAtk->status }}</span>
                    @elseif ($permintaanAtk->status == "Diterima")
                      <span class="px-2 py-1 tx-12 bg-info text-light rounded">{{ $permintaanAtk->status }}</span>
                    @elseif ($permintaanAtk->status == "Disetujui")
                      <span class="px-2 py-1 tx-12 bg-success text-light rounded">{{ $permintaanAtk->status }}</span>
                    @elseif ($permintaanAtk->status == "Ditolak")
                      <span class="px-2 py-1 tx-12 bg-danger text-light rounded">{{ $permintaanAtk->status }}</span>
                    @endif
                    <a target="_blank" href="/permintaanAtk/{{ $permintaanAtk->id }}/pdf" class="px-2 py-1 tx-12 bg-info text-light rounded"><i class="bi bi-filetype-pdf"></i> Pdf</a> <br>
                    <span class="tx-12">{{ $permintaanAtk->nomor }}</span>
                  </td>   
                  <td  class="text-center">
                    <a class="btn btn-teal tx-10 pd-x-10 pd-y-5 text-light tx-medium" data-toggle="modal" data-target="#modaldemo{{ $permintaanAtk->id }}">Detail ATK / Suvenir</a>
                    {{-- Modal ATK --}}
                    <div id="modaldemo{{ $permintaanAtk->id }}" class="modal fade">
                      <div class="modal-dialog modal-lg w-100" role="document">
                        <div class="modal-content bd-0 tx-14">
                          <div class="modal-header pd-x-20">
                            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detail ATK / Suvenir</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body pd-20">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Nama ATK / Suvenir</th>
                                  <th>Jumlah</th>
                                  <th>Spesifikasi</th>
                                  <th>Kesediaan</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($permintaanAtk->atk as $atk)
                                  <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $atk['nama'] }}</td>
                                    <td>{{ $atk['jumlah'] }} {{ $atk['satuan'] }}</td>
                                    <td>{{ $atk['spesifikasi'] }}</td>
                                    @if (isset($atk['kesediaan']))
                                      @if ($atk['kesediaan'] == 'Tersedia')
                                        <td><i class="bi bi-patch-check-fill tx-success"></i> {{ $atk['kesediaan'] }}</td>
                                      @else
                                        <td><i class="bi bi-patch-exclamation-fill tx-danger"></i> {{ $atk['kesediaan'] }}</td>
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
                  @if (Auth::user()->role == 'Petugas')
                    <td>
                      <div class="d-flex justify-content-center">
                        @if ($permintaanAtk->status == 'Draf')
                          <a href="/permintaanAtk/{{ $permintaanAtk->id }}/edit" class="btn btn-warning tx-10 pd-x-10 pd-y-5 mr-2"><i class="bi bi-pen mr-1"></i> Edit</a>
                        @endif
                        <div data-kode="{{ $permintaanAtk->id }}" class="btn btn-danger tx-10 pd-x-10 pd-y-5 swal-confirm">
                          <form action="/permintaanAtk/{{ $permintaanAtk->id }}" id="delete{{ $permintaanAtk->id }}" method="post">
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
                      <a href="/permintaanAtk/{{ $permintaanAtk->id }}/check" class="btn btn-warning tx-14 pd-x-15 pd-y-7"><i class="bi bi-clipboard-check"></i> Setujui</a>
                    </td>
                  @endif
                  @if (Auth::user()->role == 'Verifikator')
                    <td class="text-center">
                      <a href="/permintaanAtk/{{ $permintaanAtk->id }}/verifing" class="btn btn-teal tx-14 pd-x-12 pd-y-7"><i class="bi bi-patch-check"></i> Verifikasi</a>
                    </td>
                  @endif
                  @if (Auth::user()->role == 'Kasubag TU')
                    <td class="text-center">
                      @if ($permintaanAtk->status == 'Diterima')
                        <a href="/permintaanAtk/{{ $permintaanAtk->id }}/approval" class="btn btn-warning tx-14 pd-x-12 pd-y-7"><i class="bi bi-clipboard-check"></i> Aproval</a>
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