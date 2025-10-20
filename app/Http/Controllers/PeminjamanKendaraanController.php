<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PeminjamanKendaraan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PeminjamanKendaraanController extends Controller
{
    public function index()
    {   
        if (Auth::user()->role == 'Super Admin') { // Super Admin
            $peminjamanKendaraans = PeminjamanKendaraan::latest()->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.admin.peminjamanKendaraan.index', compact('peminjamanKendaraans'));

        } elseif (Auth::user()->role == 'Petugas') { // Petugas
            $peminjamanKendaraans = PeminjamanKendaraan::latest()->where('petugas', Auth::user()->id)->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.peminjamanKendaraan.index', compact('peminjamanKendaraans'));

        } elseif (Auth::user()->role == 'Penanggung Jawab') { // Penanggung Jawab
            $peminjamanKendaraans = PeminjamanKendaraan::latest()->where('status', 'Draf')->where('penanggung_jawab', Auth::user()->id)->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.peminjamanKendaraan.index', compact('peminjamanKendaraans'));

        } elseif (Auth::user()->role == 'Verifikator') { // Verifikator (Peminjaman kendaraan dengan status pengajuan)
            $peminjamanKendaraans = PeminjamanKendaraan::latest()->where('status', 'Pengajuan')->where('verifikator', Auth::user()->id)->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.peminjamanKendaraan.index', compact('peminjamanKendaraans'));

        } elseif (Auth::user()->role == 'Kasubag TU') { // Kasubag TU (Peminjaman kendaraan dengan status diterima)
            $peminjamanKendaraans = PeminjamanKendaraan::latest()->whereIn('status', ['Diterima', 'Disetujui'])->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.peminjamanKendaraan.index', compact('peminjamanKendaraans'));

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
        $kendaraans = Kendaraan::all();
        if (Auth::user()->role == "Super Admin") {
            return view('content.admin.peminjamanKendaraan.create', compact('pegawais', 'verifikators', 'penanggungJawabs', 'kendaraans'));
        } elseif (Auth::user()->role == "Petugas") {
            return view('content.peminjamanKendaraan.create', compact('pegawais', 'verifikators', 'penanggungJawabs', 'kendaraans'));
        }
    }

    public function store(Request $req)
    {
        $req['petugas'] = Auth::user()->id;
        
        $req['nomor'] = "---/LK02.02/RT-BMN/" . date('Y'); // $nomorBaru

        $validation = $req->validate([
            'pemohon' => 'required',
            'substansi' => 'required',
            'petugas' => 'required',
            'penanggung_jawab' => 'required',
            'verifikator' => 'required',
            'kendaraan_id' => 'required',
            'tanggal_penggunaan' => 'required',
            'tanggal_selesai' => 'required',
            'nomor' => 'required',
            'signature_pemohon' => 'required',
            'keperluan' => 'required',
            'status' => 'required',
        ]);

        $mulai = Carbon::parse($req->tanggal_penggunaan);
        $selesai = Carbon::parse($req->tanggal_selesai);

        // Validasi tanggal_penggunaan < tanggal_selesai
        if ($mulai >= $selesai) {
            Alert::toast('Kendaraan sudah dipakai dalam rentang waktu tersebut!', 'error');
            return back();
        }

        // Cek konflik jadwal
        $conflict = PeminjamanKendaraan::where('kendaraan_id', $req->kendaraan_id)
            ->where(function ($query) use ($mulai, $selesai) {
                $query->whereBetween('tanggal_penggunaan', [$mulai, $selesai])
                    ->orWhereBetween('tanggal_selesai', [$mulai, $selesai])
                    ->orWhere(function ($query) use ($mulai, $selesai) {
                        $query->where('tanggal_penggunaan', '<=', $mulai)
                                ->where('tanggal_selesai', '>=', $selesai);
                    });
            })->exists();

        if ($conflict) {
            Alert::toast('Kendaraan sudah dipakai dalam rentang waktu tersebut!', 'error');
            return back();
        }

        // Proses merubah nama file tanda tangan agar tidak base64
        $signature = $req->signature_pemohon;
        $signature = str_replace('data:image/png;base64,', '', $signature);
        $signature = str_replace(' ', '+', $signature);
        $signatureName = 'signature_pemohon_' . time() . '.png';

        // Proses simpan tanda tangan
        Storage::disk('public')->put("signature-pemohon/$signatureName", base64_decode($signature));

        // Ganti isi field di $validation agar hanya simpan nama file, bukan base64
        $validation['signature_pemohon'] = $signatureName;

        PeminjamanKendaraan::Create($validation);
        Alert::toast('Data peminjaman berhasil dibuat!', 'success');

        if (Auth::user()->role == 'Super Admin') {
            return redirect('/manage/peminjamanKendaraan');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect('/peminjamanKendaraan');
        }
    }

    public function edit(PeminjamanKendaraan $peminjamanKendaraan)
    {   
        $pegawais = Pegawai::latest()->get();
        $penanggungJawabs = User::where('role', 'Penanggung Jawab')->get();
        $verifikators = User::where('role', 'Verifikator')->get();
        $kendaraans = Kendaraan::all();
        if (Auth::user()->role == "Super Admin") {
            return view('content.admin.peminjamanKendaraan.edit', compact('pegawais', 'verifikators', 'penanggungJawabs', 'kendaraans', 'peminjamanKendaraan'));
        } elseif (Auth::user()->role == "Petugas") {
            return view('content.peminjamanKendaraan.edit', compact('pegawais', 'verifikators', 'penanggungJawabs', 'kendaraans', 'peminjamanKendaraan'));
        }
    }

    public function update(Request $req, PeminjamanKendaraan $peminjamanKendaraan)
    {   
        $validation = $req->validate([
            'pemohon' => 'required',
            'substansi' => 'required',
            'penanggung_jawab' => 'required',
            'verifikator' => 'required',
            'kendaraan_id' => 'required',
            'tanggal_penggunaan' => 'required',
            'tanggal_selesai' => 'required',
            'keperluan' => 'required',
            'status' => 'required',
        ]);

        if (Carbon::parse($req->tanggal_penggunaan) != $peminjamanKendaraan->tanggal_penggunaan || Carbon::parse($req->tanggal_selesai) != $peminjamanKendaraan->tanggal_selesai || $req->ruang_id != $peminjamanKendaraan->ruang_id) {
            $mulai = Carbon::parse($req->tanggal_penggunaan);
            $selesai = Carbon::parse($req->tanggal_selesai);
    
            // Validasi tanggal_penggunaan < tanggal_selesai
            if ($mulai >= $selesai) {
                Alert::toast('Rentang waktu tidak valid!', 'error');
                return back();
            }

            // Cek konflik jadwal
            $conflict = PeminjamanKendaraan::where('kendaraan_id', $req->kendaraan_id)
                ->where(function ($query) use ($mulai, $selesai) {
                    $query->whereBetween('tanggal_penggunaan', [$mulai, $selesai])
                        ->orWhereBetween('tanggal_selesai', [$mulai, $selesai])
                        ->orWhere(function ($query) use ($mulai, $selesai) {
                            $query->where('tanggal_penggunaan', '<=', $mulai)
                                    ->where('tanggal_selesai', '>=', $selesai);
                        });
                })->exists();

            if ($conflict) {
                Alert::toast('Kendaraan sudah dipakai dalam rentang waktu tersebut!', 'error');
                return back();
            }
        }

        // Mengecek apakah ada tanda tangan baru atau tidak
        if ($req->signature_pemohon) {

            // Hapus tanda tangan lama
            Storage::disk('public')->delete("signature-pemohon/{$peminjamanKendaraan->signature_pemohon}");

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
        
        $peminjamanKendaraan->update($validation);

        Alert::toast('Data peminjaman berhasil diupdate!', 'success');
        if (Auth::user()->role == 'Super Admin') {
            return redirect('/manage/peminjamanKendaraan');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect('/peminjamanKendaraan');
        }
    }

    public function destroy(PeminjamanKendaraan $peminjamanKendaraan)
    {
        $peminjamanKendaraan->delete();
        Alert::toast('Data peminjaman berhasil dihapus!', 'success');
        if (Auth::user()->role == 'Super Admin') {
            return redirect('/manage/peminjamanKendaraan');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect('/peminjamanKendaraan');
        }
    }

    public function check(PeminjamanKendaraan $peminjamanKendaraan)
    {
        return view('content.peminjamanKendaraan.check', compact('peminjamanKendaraan'));
    }


    public function accepted(Request $req, PeminjamanKendaraan $peminjamanKendaraan)
    {
        $validation = $req->validate([
            'status' => 'required',
        ]);
        
        $peminjamanKendaraan->update($validation);

        Alert::toast('Pengajuan diterima!', 'success');
        return redirect('/peminjamanKendaraan');
    }


    public function verifing(PeminjamanKendaraan $peminjamanKendaraan)
    {
        return view('content.peminjamanKendaraan.verifing', compact('peminjamanKendaraan'));
    }


    public function verifid(Request $req, PeminjamanKendaraan $peminjamanKendaraan)
    {   
        $validation = $req->validate([
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
        
        $peminjamanKendaraan->update($validation);

        Alert::toast('Pengajuan diterima!', 'success');
        return redirect('/peminjamanKendaraan');
    }


    public function approval(Request $req, PeminjamanKendaraan $peminjamanKendaraan)
    {
        return view('content.peminjamanKendaraan.approval', compact('peminjamanKendaraan'));
    }

    
    public function approved(Request $req, PeminjamanKendaraan $peminjamanKendaraan)
    {   
        // Membuat nomor surat otomatis
        $last = PeminjamanKendaraan::orderBy('created_at', 'desc')->first();

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
        
        $peminjamanKendaraan->update($validation);

        Alert::toast('Pengajuan disetujui!', 'success');
        return redirect('/peminjamanKendaraan');
    }


    public function declined(Request $req, PeminjamanKendaraan $peminjamanKendaraan)
    {   
        $validation = $req->validate([
            'status' => 'required',
            'ket' => 'required',
        ]);
        
        $peminjamanKendaraan->update($validation);

        Alert::toast('Pengajuan ditolak!', 'error');
        return redirect('/peminjamanKendaraan');
    }

}