<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\PeminjamanBmn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PeminjamanBmnController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'Super Admin') { // Super Admin
            $peminjamanBmns = PeminjamanBmn::latest()->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab', 'pengembalianBmn'])->get();
            return view('content.admin.peminjamanBmn.index', compact('peminjamanBmns'));

        } elseif (Auth::user()->role == 'Petugas') { // Petugas
            $peminjamanBmns = PeminjamanBmn::latest()->where('petugas', Auth::user()->id)->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab', 'pengembalianBmn'])->get();
            return view('content.peminjamanBmn.index', compact('peminjamanBmns'));

        } elseif (Auth::user()->role == 'Penanggung Jawab') { // Penanggung Jawab
            $peminjamanBmns = PeminjamanBmn::latest()->where('status', 'Draf')->where('penanggung_jawab', Auth::user()->id)->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab', 'pengembalianBmn'])->get();
            return view('content.peminjamanBmn.index', compact('peminjamanBmns'));

        } elseif (Auth::user()->role == 'Verifikator') { // Verifikator (Permintaan ATK dengan status pengajuan)
            $peminjamanBmns = PeminjamanBmn::latest()->where('status', 'Pengajuan')->where('verifikator', Auth::user()->id)->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab', 'pengembalianBmn'])->get();
            return view('content.peminjamanBmn.index', compact('peminjamanBmns'));

        } elseif (Auth::user()->role == 'Kasubag TU') { // Kasubag TU (Permintaan ATK dengan status diterima)
            $peminjamanBmns = PeminjamanBmn::latest()->whereIn('status', ['Diterima', 'Disetujui'])->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab', 'pengembalianBmn'])->get();
            return view('content.peminjamanBmn.index', compact('peminjamanBmns'));

        } else {
            Alert::error('Oops', 'Sorry bro ga boleh masuk');
            return redirect('/dashboard');
        }
    }

    public function create()
    {
        $pegawais = Pegawai::latest()->get();
        $penanggungJawabs = User::where('role', 'Penanggung Jawab')->get();
        $verifikators = User::where('role', 'Verifikator')->get();
        if (Auth::user()->role == "Super Admin") {
            return view('content.admin.peminjamanBmn.create', compact('pegawais', 'verifikators', 'penanggungJawabs'));
        } elseif (Auth::user()->role == "Petugas") {
            return view('content.peminjamanBmn.create', compact('pegawais', 'verifikators', 'penanggungJawabs'));
        }
    }

    public function store(Request $req)
    {
        // Menyimpan array ke dalam variabel
        $jenisBmn = $req->input('jenis');
        $merekBmn = $req->input('merek');
        $nupBmn = $req->input('nup');
        $jumlahBmn = $req->input('jumlah');
        $SatuanBmn = $req->input('satuan');

        $arrayBmn = [];

        //  Memasukkan array ke dalam variabel arrayBmn
        for ($i = 0; $i < count($jenisBmn); $i++) {
            $arrayBmn[] = [
                'jenis'  => $jenisBmn[$i],
                'merek'  => $merekBmn[$i],
                'nup'    => $nupBmn[$i],
                'jumlah' => $jumlahBmn[$i],
                'satuan' => $SatuanBmn[$i],
            ];
        }

        $req['bmn'] = $arrayBmn;
        $req['petugas'] = Auth::user()->id;

        $req['nomor'] = "---/LK02.02/RT-BMN/" . date('Y'); // $nomorBaru

        $validation = $req->validate([
            'pemohon' => 'required',
            'petugas' => 'required',
            'verifikator' => 'required',
            'penanggung_jawab' => 'required',
            'signature_pemohon' => 'required',
            'nomor' => 'required',
            'bmn' => 'required',
            'lama_pinjam' => 'required',
            'lokasi_penggunaan' => 'required',
            'status' => 'required',
        ]);

        // Proses merubah nama file tanda tangan agar tidak base64
        $signature = $req->signature_pemohon;
        $signature = str_replace('data:image/png;base64,', '', $signature);
        $signature = str_replace(' ', '+', $signature);
        $signatureName = 'signature_pemohon_' . time() . '.png';

        // Proses simpan tanda tangan
        Storage::disk('public')->put("signature-pemohon/$signatureName", base64_decode($signature));

        // Ganti isi field di $validation agar hanya simpan nama file, bukan base64
        $validation['signature_pemohon'] = $signatureName;
        
        PeminjamanBmn::Create($validation);
        Alert::toast('Data peminjaman berhasil dibuat!', 'success');

        if (Auth::user()->role == 'Super Admin') {
            return redirect('/manage/peminjamanBmn');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect('/peminjamanBmn');
        }
    }

    public function edit(PeminjamanBmn $peminjamanBmn)
    {
        $pegawais = Pegawai::latest()->get();
        $penanggungJawabs = User::where('role', 'Penanggung Jawab')->get();
        $verifikators = User::where('role', 'Verifikator')->get();
        if (Auth::user()->role == "Super Admin") {
            return view('content.admin.peminjamanBmn.edit', compact('pegawais', 'verifikators', 'penanggungJawabs', 'peminjamanBmn'));
        } elseif (Auth::user()->role == "Petugas") {
            return view('content.peminjamanBmn.edit', compact('pegawais', 'verifikators', 'penanggungJawabs', 'peminjamanBmn'));
        }
    }

    public function update(Request $req, PeminjamanBmn $peminjamanBmn)
    {
        // Menyimpan array ke dalam variabel
        $jenisBmn = $req->input('jenis');
        $merekBmn = $req->input('merek');
        $nupBmn = $req->input('nup');
        $jumlahBmn = $req->input('jumlah');
        $satuanBmn = $req->input('satuan');

        $arrayBmn = [];

        //  Memasukkan array ke dalam variabel arrayBmn
        for ($i = 0; $i < count($jenisBmn); $i++) {
            $arrayBmn[] = [
                'jenis'  => $jenisBmn[$i],
                'merek'  => $merekBmn[$i],
                'nup'    => $nupBmn[$i],
                'jumlah' => $jumlahBmn[$i],
                'satuan' => $satuanBmn[$i],
            ];
        }

        $req['bmn'] = $arrayBmn;

        $validation = $req->validate([
            'pemohon' => 'required',
            'verifikator' => 'required',
            'penanggung_jawab' => 'required',
            'bmn' => 'required',
            'lama_pinjam' => 'required',
            'lokasi_penggunaan' => 'required',
            'status' => 'required',
        ]);

        if ($req->signature_pemohon) {
            // Hapus tanda tangan lama
            Storage::disk('public')->delete("signature-pemohon/{$peminjamanBmn->signature_pemohon}");

            // Proses merubah nama file tanda tangan agar tidak base64
            $signature = $req->signature_pemohon;
            $signature = str_replace('data:image/png;base64,', '', $signature);
            $signature = str_replace(' ', '+', $signature);
            $signatureName = 'signature_pemohon_' . time() . '.png';
    
            // Proses simpan tanda tangan
            Storage::disk('public')->put("signature-pemohon/$signatureName", base64_decode($signature));
    
            // Ganti isi field di $validation agar hanya simpan nama file, bukan base64
            $validation['signature_pemohon'] = $signatureName;
        }

        $peminjamanBmn->update($validation);
        Alert::toast('Data peminjaman berhasil diupdate!', 'success');

        if (Auth::user()->role == 'Super Admin') {
            return redirect('/manage/peminjamanBmn');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect('/peminjamanBmn');
        }
    }

    public function destroy(PeminjamanBmn $peminjamanBmn)
    {
        $peminjamanBmn->delete();
        Alert::toast('Data peminjaman berhasil dihapus!', 'success');
        if (Auth::user()->role == 'Super Admin') {
            return redirect('/manage/peminjamanBmn');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect('/peminjamanBmn');
        }
    }

    public function check(PeminjamanBmn $peminjamanBmn)
    {
        return view('content.peminjamanBmn.check', compact('peminjamanBmn'));
    }


    public function accepted(Request $req, PeminjamanBmn $peminjamanBmn)
    {
        $validation = $req->validate([
            'status' => 'required',
        ]);
        
        $peminjamanBmn->update($validation);

        Alert::toast('Pengajuan diterima!', 'success');
        return redirect('/peminjamanBmn');
    }

    public function verifing(PeminjamanBmn $peminjamanBmn)
    {
        return view('content.peminjamanBmn.verifing', compact('peminjamanBmn'));
    }


    public function verifid(Request $req, PeminjamanBmn $peminjamanBmn)
    {   
        // Menyimpan array ke dalam variabel
        $jenisBmn = $req->input('jenis');
        $merekBmn = $req->input('merek');
        $nupBmn = $req->input('nup');
        $jumlahBmn = $req->input('jumlah');
        $satuanBmn = $req->input('satuan');
        $kesediaanBmn = $req->input('kesediaan');

        $arrayBmn = [];

        //  Memasukkan array ke dalam variabel arrayBmn
        for ($i = 0; $i < count($jenisBmn); $i++) {
            $arrayBmn[] = [
                'jenis'     => $jenisBmn[$i],
                'merek'     => $merekBmn[$i],
                'nup'       => $nupBmn[$i],
                'jumlah'    => $jumlahBmn[$i],
                'satuan'    => $satuanBmn[$i],
                'kesediaan' => $kesediaanBmn[$i] ?? 'Tidak Tersedia',
            ];
        }

        $req['bmn'] = $arrayBmn;

        $validation = $req->validate([
            'bmn' => 'required',
            'status' => 'required',
            'signature_verifikator' => 'required',
        ]);

        // Proses merubah nama file tanda tangan agar tidak base64
        $signature = $req->signature_verifikator;
        $signature = str_replace('data:image/png;base64,', '', $signature);
        $signature = str_replace(' ', '+', $signature);
        $signatureName = 'signature_verifikator_' . time() . '.png';

        // Proses simpan tanda tangan
        Storage::disk('public')->put("signature-verifikator/$signatureName", base64_decode($signature));

        // Ganti isi field di $validation agar hanya simpan nama file, bukan base64
        $validation['signature_verifikator'] = $signatureName;
        
        $peminjamanBmn->update($validation);

        Alert::toast('Pengajuan diterima!', 'success');
        return redirect('/peminjamanBmn');
    }

    public function approval(Request $req, PeminjamanBmn $peminjamanBmn)
    {
        return view('content.peminjamanBmn.approval', compact('peminjamanBmn'));
    }

    
    public function approved(Request $req, PeminjamanBmn $peminjamanBmn)
    {   
        // Membuat nomor surat otomatis
        $last = PeminjamanBmn::orderBy('created_at', 'desc')->first();

        if ($last && preg_match('/^(\d+)\//', $last->nomor, $match)) {
            $lastNumber = (int) $match[1]; // Ambil angka di depan sebelum "/"
        } else {
            $lastNumber = 0; // Jika belum ada data
        }

        $newNumber = $lastNumber + 1;
        // Format 3 digit: 001, 002, dst.
        $formattedNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        $nomorBaru = $formattedNumber . "/LK02.02/RT-BMN/" . date('Y');

        $req['nomor'] = $nomorBaru;

        $validation = $req->validate([
            'nomor' => 'required',
            'status' => 'required',
            'signature_kasubag_tu' => 'required',
        ]);

        // Proses merubah nama file tanda tangan agar tidak base64
        $signature = $req->signature_kasubag_tu;
        $signature = str_replace('data:image/png;base64,', '', $signature);
        $signature = str_replace(' ', '+', $signature);
        $signatureName = 'signature_kasubag_tu_' . time() . '.png';

        // Proses simpan tanda tangan
        Storage::disk('public')->put("signature-kasubag-tu/$signatureName", base64_decode($signature));

        // Ganti isi field di $validation agar hanya simpan nama file, bukan base64
        $validation['signature_kasubag_tu'] = $signatureName;
        
        $peminjamanBmn->update($validation);

        Alert::toast('Pengajuan disetujui!', 'success');
        return redirect('/peminjamanBmn');
    }

    public function declined(Request $req, PeminjamanBmn $peminjamanBmn)
    {   
        $validation = $req->validate([
            'status' => 'required',
            'ket' => 'required',
        ]);
        
        $peminjamanBmn->update($validation);

        Alert::toast('Pengajuan ditolak!', 'error');
        return redirect('/peminjamanBmn');
    }
}
