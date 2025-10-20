<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\PermintaanAtk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PermintaanAtkController extends Controller
{
    public function index()
    {   
        if (Auth::user()->role == 'Super Admin') { // Super Admin
            $permintaanAtks = PermintaanAtk::latest()->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.admin.permintaanAtk.index', compact('permintaanAtks'));

        } elseif (Auth::user()->role == 'Petugas') { // Petugas
            $permintaanAtks = PermintaanAtk::latest()->where('petugas', Auth::user()->id)->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.permintaanAtk.index', compact('permintaanAtks'));

        } elseif (Auth::user()->role == 'Penanggung Jawab') { // Penanggung Jawab
            $permintaanAtks = PermintaanAtk::latest()->where('status', 'Draf')->where('penanggung_jawab', Auth::user()->id)->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.permintaanAtk.index', compact('permintaanAtks'));

        } elseif (Auth::user()->role == 'Verifikator') { // Verifikator (Permintaan ATK dengan status pengajuan)
            $permintaanAtks = PermintaanAtk::latest()->where('status', 'Pengajuan')->where('verifikator', Auth::user()->id)->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.permintaanAtk.index', compact('permintaanAtks'));

        } elseif (Auth::user()->role == 'Kasubag TU') { // Kasubag TU (Permintaan ATK dengan status diterima)
            $permintaanAtks = PermintaanAtk::latest()->whereIn('status', ['Diterima', 'Disetujui'])->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.permintaanAtk.index', compact('permintaanAtks'));

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
            return view('content.admin.permintaanAtk.create', compact('pegawais', 'verifikators', 'penanggungJawabs'));
        } elseif (Auth::user()->role == "Petugas") {
            return view('content.permintaanAtk.create', compact('pegawais', 'verifikators', 'penanggungJawabs'));
        }
    }


    public function store(Request $req)
    {   
        // Menyimpan array ke dalam variabel
        $namaAtk = $req->input('nama');
        $jumlahAtk = $req->input('jumlah');
        $satuanAtk = $req->input('satuan');
        $spesifikasiAtk = $req->input('spesifikasi');

        $arrayAtk = [];

        //  Memasukkan array ke dalam variabel arrayAtk
        for ($i = 0; $i < count($namaAtk); $i++) {
            $arrayAtk[] = [
                'nama'              => $namaAtk[$i],
                'jumlah'            => $jumlahAtk[$i],
                'satuan'            => $satuanAtk[$i],
                'spesifikasi'       => $spesifikasiAtk[$i],
            ];
        }

        $req['atk'] = $arrayAtk;
        $req['petugas'] = Auth::user()->id;

        $req['nomor'] = "---/LK02.02/RT-BMN/" . date('Y'); // $nomorBaru

        $validation = $req->validate([
            'pemohon' => 'required',
            'petugas' => 'required',
            'verifikator' => 'required',
            'penanggung_jawab' => 'required',
            'signature_pemohon' => 'required',
            'nomor' => 'required',
            'atk' => 'required',
            'lokasi' => 'required',
            'jenis' => 'required',
            'tanggal' => 'required',
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
        
        PermintaanAtk::Create($validation);
        Alert::toast('Data permintaan berhasil dibuat!', 'success');

        if (Auth::user()->role == 'Super Admin') {
            return redirect('/manage/permintaanAtk');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect('/permintaanAtk');
        }
    }


    public function edit(PermintaanAtk $permintaanAtk)
    {
        $pegawais = Pegawai::latest()->get();
        $verifikators = User::where('role', 'Verifikator')->get();
        $penanggungJawabs = User::where('role', 'Penanggung Jawab')->get();
        // $permintaanAtk = PermintaanAtk::where('id', $permintaanAtk->id)->with(['fPemohon', 'fVerif', 'fPenanggungJawab'])->first();
        if (Auth::user()->role == "Super Admin") {
            return view('content.admin.permintaanAtk.edit', compact('pegawais', 'verifikators', 'penanggungJawabs', 'permintaanAtk'));
        } elseif (Auth::user()->role == "Petugas") {
            return view('content.permintaanAtk.edit', compact('pegawais', 'verifikators', 'penanggungJawabs', 'permintaanAtk'));
        }
    }


    public function update(Request $req, PermintaanAtk $permintaanAtk)
    {
        // Menyimpan array ke dalam variabel
        $namaAtk = $req->input('nama');
        $jumlahAtk = $req->input('jumlah');
        $satuanAtk = $req->input('satuan');
        $spesifikasiAtk = $req->input('spesifikasi');

        $arrayAtk = [];

        //  Memasukkan array ke dalam variabel arrayAtk
        for ($i = 0; $i < count($namaAtk); $i++) {
            $arrayAtk[] = [
                'nama'              => $namaAtk[$i],
                'jumlah'            => $jumlahAtk[$i],
                'satuan'            => $satuanAtk[$i],
                'spesifikasi' => $spesifikasiAtk[$i],
            ];
        }

        $req['atk'] = $arrayAtk;

        $validation = $req->validate([
            'pemohon' => 'required',
            'verifikator' => 'required', 
            'penanggung_jawab' => 'required',
            'atk' => 'required',
            'lokasi' => 'required',
            'jenis' => 'required',
            'tanggal' => 'required',
            'status' => 'required',
        ]);
        
        // Mengecek apakah ada tanda tangan baru atau tidak
        if ($req->signature_pemohon) {
            // Hapus tanda tangan lama
            Storage::disk('public')->delete("signature-pemohon/{$permintaanAtk->signature_pemohon}");

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
        
        $permintaanAtk->update($validation);

        Alert::toast('Data permintaan berhasil diupdate!', 'success');
        if (Auth::user()->role == 'Super Admin') {
            return redirect('/manage/permintaanAtk');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect('/permintaanAtk');
        }
    }


    public function destroy(PermintaanAtk $permintaanAtk)
    {
        $permintaanAtk->delete();
        Alert::toast('Data permintaan berhasil dihapus!', 'success');
        if (Auth::user()->role == 'Super Admin') {
            return redirect('/manage/permintaanAtk');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect('/permintaanAtk');
        }
    }


    public function check(PermintaanAtk $permintaanAtk)
    {
        return view('content.permintaanAtk.check', compact('permintaanAtk'));
    }


    public function accepted(Request $req, PermintaanAtk $permintaanAtk)
    {
        $validation = $req->validate([
            'status' => 'required',
        ]);
        
        $permintaanAtk->update($validation);

        Alert::toast('Pengajuan diterima!', 'success');
        return redirect('/permintaanAtk');
    }


    public function verifing(PermintaanAtk $permintaanAtk)
    {
        return view('content.permintaanAtk.verifing', compact('permintaanAtk'));
    }


    public function verifid(Request $req, PermintaanAtk $permintaanAtk)
    {   
        // Menyimpan array ke dalam variabel
        $namaAtk = $req->input('nama');
        $jumlahAtk = $req->input('jumlah');
        $satuanAtk = $req->input('satuan');
        $spesifikasiAtk = $req->input('spesifikasi');
        $kesediaanAtk = $req->input('kesediaan');

        $arrayAtk = [];

        //  Memasukkan array ke dalam variabel arrayAtk
        for ($i = 0; $i < count($namaAtk); $i++) {
            $arrayAtk[] = [
                'nama'              => $namaAtk[$i],
                'jumlah'            => $jumlahAtk[$i],
                'satuan'            => $satuanAtk[$i],
                'spesifikasi'       => $spesifikasiAtk[$i],
                'kesediaan'         => $kesediaanAtk[$i] ?? 'Tidak Tersedia',
            ];
        }

        $req['atk'] = $arrayAtk;
        
        $validation = $req->validate([
            'atk' => 'required',
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
        
        $permintaanAtk->update($validation);

        Alert::toast('Pengajuan diterima!', 'success');
        return redirect('/permintaanAtk');
    }


    public function approval(Request $req, PermintaanAtk $permintaanAtk)
    {
        return view('content.permintaanAtk.approval', compact('permintaanAtk'));
    }

    
    public function approved(Request $req, PermintaanAtk $permintaanAtk)
    {   
        // Membuat nomor surat otomatis
        $last = PermintaanAtk::orderBy('created_at', 'desc')->first();

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
        
        $permintaanAtk->update($validation);

        Alert::toast('Pengajuan disetujui!', 'success');
        return redirect('/permintaanAtk');
    }

    
    public function declined(Request $req, PermintaanAtk $permintaanAtk)
    {   
        $validation = $req->validate([
            'status' => 'required',
            'ket' => 'required',
        ]);
        
        $permintaanAtk->update($validation);

        Alert::toast('Pengajuan ditolak!', 'error');
        return redirect('/permintaanAtk');
    }
}
