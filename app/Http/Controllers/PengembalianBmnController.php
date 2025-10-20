<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBmn;
use App\Models\PengembalianBmn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PengembalianBmnController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'Super Admin') { // Super Admin
            $peminjamanBmns = PeminjamanBmn::latest()->whereIn('status', ['Disetujui', 'Selesai'])->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab', 'pengembalianBmn'])->get();
            return view('content.admin.pengembalianBmn.index', compact('peminjamanBmns'));

        } elseif (Auth::user()->role == 'Petugas') { // Petugas
            $peminjamanBmns = PeminjamanBmn::latest()->where('petugas', Auth::user()->id)->whereIn('status', ['Disetujui', 'Selesai'])->with(['fPemohon', 'fPetugas', 'fVerif', 'fPenanggungJawab', 'pengembalianBmn'])->get();
            return view('content.pengembalianBmn.index', compact('peminjamanBmns'));

        }  else {
            Alert::error('Oops', 'Sorry bro ga boleh masuk');
            return redirect('/dashboard');
        }
    }


    public function create()
    {
        //
    }


    public function store(Request $req)
    {   
        $validation = $req->validate([
            'peminjaman_bmn_id' => 'required',
            'catatan' => 'required',
        ]);

        PengembalianBmn::create($validation);

        // Update 1 kolom pada tabel peminjaman_bmns
        PeminjamanBmn::where('id', $req->peminjaman_bmn_id)->update(['status' => 'Selesai']);
        
        Alert::toast('Data pengembalian berhasil dibuat!', 'success');

        if (Auth::user()->role == 'Super Admin') {
            return redirect('/manage/pengembalianBmn');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect('/pengembalianBmn');
        }
    }


    public function show(PengembalianBmn $pengembalianBmn)
    {
        //
    }


    public function edit(PengembalianBmn $pengembalianBmn)
    {
        //
    }


    public function update(Request $req, PengembalianBmn $pengembalianBmn)
    {
        //
    }


    public function destroy(PengembalianBmn $pengembalianBmn)
    {
        //
    }
}
