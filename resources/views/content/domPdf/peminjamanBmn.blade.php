<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Form Permintaan ATK</title>
  <link rel="icon" href="">
  <style>
    @page {
      margin: 12mm;
      size: A4;
    }

    .logo{
      width: 125px;
      float: left;
    }

    .tx-16{
      font-size: 16px;
      line-height: 20px;
      margin: 0;
    }

    .tx-14{
      font-size: 14px;
      line-height: 18px;
      margin: 0;
    }

    .text-center{
      text-align: center;
    }

    .table-component {
      overflow: auto;
      width: 100%;
      border-collapse: collapse;
    }

    .table-component table {
      border: 1px solid #dededf;
      height: 100%;
      width: 100%;
      table-layout: fixed;
      border-spacing: 0px;
      text-align: left;
    }

    .table-component caption {
      caption-side: top;
      text-align: left;
    }

    .table-component th {
      border: 1px solid #2f2f2f;
      background-color: #1d7cbf;
      color: #fff;
      padding: 5px;
    }

    .table-component td {
      border: 1px solid #2f2f2f;
      background-color: #ffffff;
      color: #000000;
      padding: 5px;
    }

    .table-sign{
      overflow: auto;
      width: 100%;
    }

    .table-sign tr th, .table-sign tr td{
      text-align: left;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <header>
    <img class="logo" src="https://invenku.pusmendik.com/storage/logokemdikbud.png" alt="">
    <div class="text-center">
      <p class="tx-16"><b>KEMENTERIAN PENDIDIKAN DASAR DAN MENENGAH</b></p>
      <p class="tx-16"><b>BADAN STANDAR, KURIKULUM, DAN ASESMEN PENDIDIKAN <br>PUSAT ASESMEN PENDIDIKAN</b></p>
      <p class="tx-14">Jalan Gardu, Srengseng Sawah, Jagakarsa, Jakarta Selatan, 12640</p>
      <p class="tx-14">Telpon: (021) 72743412, Faksimile: (021) 3505341, Laman: pusmendik.kemendikbud.go.id</p>
      <p class="tx-14">Posel: pusmendik@kemendikbud.go.id</p>
    </div>
  </header>
  <br>
  <hr>
  <section><br>
    <div class="text-center" tabindex="0">
      <p class="tx-16"><b>FORM PEMINJAMAN BMN</b></p>
      <p class="tx-14">NOMOR : {{ $data->nomor ?? "-" }}</p>
    </div><br>
    <table class="table-component">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Barang</th>
          <th>Merek</th>
          <th>NUP</th>
          <th>Jumlah</th>
          <th>Satuan</th>
          <th>Kesediaan</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data->bmn as $atk)
          <tr>
            <td class="text-center tx-14">{{ $loop->iteration }}</td>
            <td class="tx-14">{{ $atk['jenis'] ?? "-" }}</td>
            <td class="tx-14">{{ $atk['merek'] ?? "-" }}</td>
            <td class="text-center tx-14">{{ $atk['nup'] ?? "-" }}</td>
            <td class="text-center tx-14">{{ $atk['jumlah'] ?? "-"  }}</td>
            <td class="text-center tx-14">{{ $atk['satuan'] ?? "-" }}</td>
            <td class="tx-14">{{ $atk['kesediaan'] ?? "-" }}</td>
          </tr>
        @endforeach
      </tbody>
    </table><br>
    <table class="table-sign">
      <thead>
        <tr>
          <td>Mengetahui/Menyetujui <br><b>Kepala Subbagian Tata Usaha</b></td>
          <td>Mengetahui <br><b>Petugas BMN/Persediaan</b></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          @if ($data->signature_kasubag_tu)
            <td>
              <img src="{{ asset('storage/signature-kasubag-tu/' . $data->signature_kasubag_tu) }}" alt="Tanda Tangan Kasubag TU" width="200px">
              <br><b>{{ $kasubagTu->pegawai->nama ?? "-" }}</b><br>NIP.{{ $kasubagTu->pegawai->nip ?? "-" }}
            </td>
          @else
            <td><br><br><br><br><br><b>{{ $kasubagTu->pegawai->nama ?? "-" }}</b><br>NIP.{{ $kasubagTu->pegawai->nip ?? "-" }}</td>
          @endif
          @if ($data->signature_verifikator)
            <td>
              <img src="{{ asset('storage/signature-verifikator/' . $data->signature_verifikator) }}" alt="Tanda Tangan Verifikator" width="200px">
              <br><b>{{ $data->fVerif->pegawai->nama ?? "-" }}</b><br>NIP.{{ $data->fVerif->pegawai->nip  ?? "-" }}
            </td>
          @else
            <td><br><br><br><br><br><b>{{ $data->fVerif->pegawai->nama ?? "-" }}</b><br>NIP.{{ $data->fVerif->pegawai->nip  ?? "-" }}</td>
          @endif
        </tr>
      </tbody>
    </table><br><br>
    <table class="table-sign">
      <thead>
        <tr>
          <td>Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} <br><b>Pemohon</b></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <img src="{{ asset('storage/signature-pemohon/' . $data->signature_pemohon) }}" alt="Tanda Tangan Pemohon" width="200px">
            <br><b>{{ $data->fPemohon->nama ?? "-" }}</b><br>NIP.{{ $data->fPemohon->nip  ?? "-" }}
          </td>
        </tr>
      </tbody>
    </table>
  </section>
</body>
</html>