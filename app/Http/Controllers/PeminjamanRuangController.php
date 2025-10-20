<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\PeminjamanRuang;
use App\Models\Ruang;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PeminjamanRuangController extends Controller
{
    public function index()
    {   
        if (Auth::user()->role == 'Super Admin') { // Super Admin
            $peminjamanRuangs = PeminjamanRuang::latest()->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.admin.peminjamanRuang.index', compact('peminjamanRuangs'));

        } elseif (Auth::user()->role == 'Petugas') { // Petugas
            $peminjamanRuangs = PeminjamanRuang::latest()->where('petugas', Auth::user()->id)->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.peminjamanRuang.index', compact('peminjamanRuangs'));

        } elseif (Auth::user()->role == 'Penanggung Jawab') { // Penanggung Jawab
            $peminjamanRuangs = PeminjamanRuang::latest()->where('status', 'Draf')->where('penanggung_jawab', Auth::user()->id)->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.peminjamanRuang.index', compact('peminjamanRuangs'));

        } elseif (Auth::user()->role == 'Verifikator') { // Verifikator (Peminjaman ruang dengan status pengajuan)
            $peminjamanRuangs = PeminjamanRuang::latest()->where('status', 'Pengajuan')->where('verifikator', Auth::user()->id)->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.peminjamanRuang.index', compact('peminjamanRuangs'));

        } elseif (Auth::user()->role == 'Kasubag TU') { // Kasubag TU (Peminjaman ruang dengan status diterima)
            $peminjamanRuangs = PeminjamanRuang::latest()->whereIn('status', ['Diterima', 'Disetujui'])->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab'])->get();
            return view('content.peminjamanRuang.index', compact('peminjamanRuangs'));

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
        $ruangs = Ruang::all();
        if (Auth::user()->role == "Super Admin") {
            return view('content.admin.peminjamanRuang.create', compact('pegawais', 'verifikators', 'penanggungJawabs', 'ruangs'));
        } elseif (Auth::user()->role == "Petugas") {
            return view('content.peminjamanRuang.create', compact('pegawais', 'verifikators', 'penanggungJawabs', 'ruangs'));
        }
    }


    public function store(Request $req)
    {   
        $req['petugas'] = Auth::user()->id;
        
        $req['nomor'] = "---/LK02.02/RT-BMN/" . date('Y'); // $nomorBaru

        $validation = $req->validate([
            'pemohon' => 'required',
            'petugas' => 'required',
            'verifikator' => 'required',
            'penanggung_jawab' => 'required',
            'ruang_id' => 'required',
            'signature_pemohon' => 'required',
            'nomor' => 'required',
            'substansi' => 'required',
            'alat_khusus' => 'required',
            'tanggal_penggunaan' => 'required',
            'tanggal_selesai' => 'required',
            'keperluan' => 'required',
            'status' => 'required',
        ]);

        // Merubah array menjadi json
        $validation['alat_khusus'] = json_encode($req->alat_khusus);

        $mulai = Carbon::parse($req->tanggal_penggunaan);
        $selesai = Carbon::parse($req->tanggal_selesai);

        // Validasi tanggal_penggunaan < tanggal_selesai
        if ($mulai >= $selesai) {
            Alert::toast('Ruang sudah dipakai dalam rentang waktu tersebut!', 'error');
            return back();
        }

        // Cek konflik jadwal
        $conflict = PeminjamanRuang::where('ruang_id', $req->ruang_id)
            ->where(function ($query) use ($mulai, $selesai) {
                $query->whereBetween('tanggal_penggunaan', [$mulai, $selesai])
                    ->orWhereBetween('tanggal_selesai', [$mulai, $selesai])
                    ->orWhere(function ($query) use ($mulai, $selesai) {
                        $query->where('tanggal_penggunaan', '<=', $mulai)
                                ->where('tanggal_selesai', '>=', $selesai);
                    });
            })->exists();

        if ($conflict) {
            Alert::toast('Ruang sudah dipakai dalam rentang waktu tersebut!', 'error');
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

        PeminjamanRuang::Create($validation);
        Alert::toast('Data peminjaman berhasil dibuat!', 'success');

        if (Auth::user()->role == 'Super Admin') {
            return redirect('/manage/peminjamanRuang');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect('/peminjamanRuang');
        }
    }


    public function edit(PeminjamanRuang $peminjamanRuang)
    {
        $pegawais = Pegawai::latest()->get();
        $verifikators = User::where('role', 'Verifikator')->get();
        $penanggungJawabs = User::where('role', 'Penanggung Jawab')->get();
        $ruangs = Ruang::all();
        if (Auth::user()->role == "Super Admin") {
            return view('content.admin.peminjamanRuang.edit', compact('pegawais', 'verifikators', 'penanggungJawabs', 'peminjamanRuang', 'ruangs'));
        } elseif (Auth::user()->role == "Petugas") {
            return view('content.peminjamanRuang.edit', compact('pegawais', 'verifikators', 'penanggungJawabs', 'peminjamanRuang', 'ruangs'));
        }
    }


    public function update(Request $req, PeminjamanRuang $peminjamanRuang)
    {   
        $validation = $req->validate([
            'pemohon' => 'required',
            'verifikator' => 'required',
            'penanggung_jawab' => 'required',
            'ruang_id' => 'required',
            'substansi' => 'required',
            'alat_khusus' => 'required',
            'tanggal_penggunaan' => 'required',
            'tanggal_selesai' => 'required',
            'keperluan' => 'required',
            'status' => 'required',
        ]);

        // Merubah array menjadi json
        $validation['alat_khusus'] = json_encode($req->alat_khusus);

        if (Carbon::parse($req->tanggal_penggunaan) != $peminjamanRuang->tanggal_penggunaan || Carbon::parse($req->tanggal_selesai) != $peminjamanRuang->tanggal_selesai || $req->ruang_id != $peminjamanRuang->ruang_id) {
            $mulai = Carbon::parse($req->tanggal_penggunaan);
            $selesai = Carbon::parse($req->tanggal_selesai);
    
            // Validasi tanggal_penggunaan < tanggal_selesai
            if ($mulai >= $selesai) {
                Alert::toast('Rentang waktu tidak valid!', 'error');
                return back();
            }
    
            // Cek konflik jadwal
            $conflict = PeminjamanRuang::where('ruang_id', $req->ruang_id)
                ->where(function ($query) use ($mulai, $selesai) {
                    $query->whereBetween('tanggal_penggunaan', [$mulai, $selesai])
                        ->orWhereBetween('tanggal_selesai', [$mulai, $selesai])
                        ->orWhere(function ($query) use ($mulai, $selesai) {
                            $query->where('tanggal_penggunaan', '<=', $mulai)
                                    ->where('tanggal_selesai', '>=', $selesai);
                        });
                })->exists();
    
            if ($conflict) {
                Alert::toast('Ruang sudah dipakai dalam rentang waktu tersebut!', 'error');
                return back();
            }
        }

        // Mengecek apakah ada tanda tangan baru atau tidak
        if ($req->signature_pemohon) {

            // Hapus tanda tangan lama
            Storage::disk('public')->delete("signature-pemohon/{$peminjamanRuang->signature_pemohon}");

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
        
        $peminjamanRuang->update($validation);

        Alert::toast('Data peminjaman berhasil diupdate!', 'success');
        if (Auth::user()->role == 'Super Admin') {
            return redirect('/manage/peminjamanRuang');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect('/peminjamanRuang');
        }
    }


    public function destroy(PeminjamanRuang $peminjamanRuang)
    {
        $peminjamanRuang->delete();
        Alert::toast('Data peminjaman berhasil dihapus!', 'success');
        if (Auth::user()->role == 'Super Admin') {
            return redirect('/manage/peminjamanRuang');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect('/peminjamanRuang');
        }
    }


    public function check(PeminjamanRuang $peminjamanRuang)
    {
        return view('content.peminjamanRuang.check', compact('peminjamanRuang'));
    }


    public function accepted(Request $req, PeminjamanRuang $peminjamanRuang)
    {
        $validation = $req->validate([
            'status' => 'required',
        ]);
        
        $peminjamanRuang->update($validation);

        Alert::toast('Pengajuan diterima!', 'success');
        return redirect('/peminjamanRuang');
    }


    public function verifing(PeminjamanRuang $peminjamanRuang)
    {
        return view('content.peminjamanRuang.verifing', compact('peminjamanRuang'));
    }


    public function verifid(Request $req, PeminjamanRuang $peminjamanRuang)
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
        
        $peminjamanRuang->update($validation);

        Alert::toast('Pengajuan diterima!', 'success');
        return redirect('/peminjamanRuang');
    }


    public function approval(Request $req, PeminjamanRuang $peminjamanRuang)
    {
        return view('content.peminjamanRuang.approval', compact('peminjamanRuang'));
    }

    
    public function approved(Request $req, PeminjamanRuang $peminjamanRuang)
    {   
        // Membuat nomor surat otomatis
        $last = PeminjamanRuang::orderBy('created_at', 'desc')->first();

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
        
        $peminjamanRuang->update($validation);

        Alert::toast('Pengajuan disetujui!', 'success');
        return redirect('/peminjamanRuang');
    }


    public function declined(Request $req, PeminjamanRuang $peminjamanRuang)
    {   
        $validation = $req->validate([
            'status' => 'required',
            'ket' => 'required',
        ]);
        
        $peminjamanRuang->update($validation);

        Alert::toast('Pengajuan ditolak!', 'error');
        return redirect('/peminjamanRuang');
    }
}
