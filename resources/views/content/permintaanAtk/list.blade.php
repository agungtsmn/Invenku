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

    @media (min-width: 992px) {
      .br-section-wrapper {
        padding: 40px 60px 40px 60px;
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
        <a class="breadcrumb-item" href="/manage/permintaanAtk">Permintaan ATK / Suvenir</a>
        <span class="breadcrumb-item active">List Pengajuan ATK</span>
      </nav>
    </div><!-- br-pageheader -->

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
                    {{ $permintaanAtk->fKatim->pegawai->nama }} <br>
                    <span class="tx-12">{{ $permintaanAtk->fPetugasBmn->pegawai->nama ?? "Petugas BMN Belum ditentukan" }}</span>
                  </td>
                  <td>
                    @if ($permintaanAtk->status == "Pengajuan")
                      <span class="px-3 py-1 tx-12 text-light rounded" style="background-color: #546E7A">{{ $permintaanAtk->status }}</span>
                    @elseif ($permintaanAtk->status == "Acc Katim")
                      <span class="px-2 py-1 tx-12 text-light rounded" style="background-color: #1E88E5">{{ $permintaanAtk->status }}</span>
                    @elseif ($permintaanAtk->status == "Acc PPK")
                      <span class="px-2 py-1 tx-12 text-light rounded" style="background-color: #8E24AA">{{ $permintaanAtk->status }}</span>
                    @elseif ($permintaanAtk->status == "Acc Kasubag")
                      <span class="px-2 py-1 tx-12 text-light rounded" style="background-color: #2E7D32">{{ $permintaanAtk->status }}</span>
                    @elseif ($permintaanAtk->status == "Pembelian")
                      <span class="px-2 py-1 tx-12 text-light rounded" style="background-color: #F4511E">{{ $permintaanAtk->status }}</span>
                    @elseif ($permintaanAtk->status == "Tersedia")
                      <span class="px-2 py-1 tx-12 text-light rounded" style="background-color: #00ACC1">{{ $permintaanAtk->status }}</span>
                    @elseif ($permintaanAtk->status == "Ditolak")
                      <span class="px-2 py-1 tx-12 text-light rounded" style="background-color: #d22926">{{ $permintaanAtk->status }}</span>
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
                                  {{-- <th>Kesediaan</th> --}}
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($permintaanAtk->atk as $atk)
                                  <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $atk['nama'] }}</td>
                                    <td>{{ $atk['jumlah'] }} {{ $atk['satuan'] }}</td>
                                    <td>{{ $atk['spesifikasi'] }}</td>
                                    {{-- @if (isset($atk['kesediaan']))
                                      @if ($atk['kesediaan'] == 'Tersedia')
                                        <td><i class="bi bi-patch-check-fill tx-success"></i> {{ $atk['kesediaan'] }}</td>
                                      @else
                                        <td><i class="bi bi-patch-exclamation-fill tx-danger"></i> {{ $atk['kesediaan'] }}</td>
                                      @endif
                                    @else
                                      <td><i class="bi bi-patch-question-fill tx-warning"></i></td>
                                    @endif --}}
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
                  {{-- @if (Auth::user()->role == 'Petugas')
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
                  @if (Auth::user()->role == 'Katim')
                    <td class="text-center">
                      @if ($permintaanAtk->status == 'Pengajuan')
                        <a href="/permintaanAtk/{{ $permintaanAtk->id }}/cekKatim" class="btn btn-warning tx-14 pd-x-15 pd-y-7"><i class="bi bi-clipboard-check"></i> Proses</a>
                      @else
                        <i class="bi bi-patch-check-fill tx-success mr-1"></i>
                      @endif
                    </td>
                  @endif
                  @if (Auth::user()->role == 'PPK')
                    <td class="text-center">
                      <a href="/permintaanAtk/{{ $permintaanAtk->id }}/cekPpk" class="btn btn-warning tx-14 pd-x-15 pd-y-7"><i class="bi bi-clipboard-check"></i> Proses</a>
                    </td>
                  @endif
                  @if (Auth::user()->role == 'Kasubag TU')
                    <td class="text-center">
                      @if ($permintaanAtk->status == 'Acc PPK')
                        <a href="/permintaanAtk/{{ $permintaanAtk->id }}/cekKasubag" class="btn btn-warning tx-14 pd-x-12 pd-y-7"><i class="bi bi-clipboard-check"></i> Proses</a>
                      @else
                        <i class="bi bi-patch-check-fill tx-success mr-1"></i>
                      @endif
                    </td>
                  @endif
                  @if (Auth::user()->role == 'Petugas BMN')
                    <td class="text-center">
                      @if ($permintaanAtk->status == 'Acc PPK')
                        <a href="/permintaanAtk/{{ $permintaanAtk->id }}/cekKasubag" class="btn btn-warning tx-14 pd-x-12 pd-y-7"><i class="bi bi-clipboard-check"></i> Proses Khusus</a>
                      @elseif($permintaanAtk->status == 'Acc Kasubag')
                        <a href="/permintaanAtk/{{ $permintaanAtk->id }}/cekBmn" class="btn btn-warning tx-14 pd-x-12 pd-y-7"><i class="bi bi-clipboard-check"></i> Proses</a>
                      @endif
                    </td>
                  @endif --}}
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
        pageLength: 100,
        lengthMenu: [50, 100, 200],
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
@endpush