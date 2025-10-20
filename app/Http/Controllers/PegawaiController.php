<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawais = Pegawai::latest()->with('user', 'jabatan')->get();
        return view('content.admin.pegawai.index', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $jabatans = Jabatan::latest()->get();
        return view('content.admin.pegawai.create', compact('jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {   
        $validation = $req->validate([
            'nip' => 'required',
            'nama' => 'required',
            'jabatan_id' => 'required',
        ]);

        try {
            Pegawai::Create($validation);
            Alert::toast('Data user berhasil dibuat!', 'success');
            return redirect('/manage/pegawai');
        } catch (QueryException $e) {
            Alert::error('Oops', 'Tidak dapat merubah data pegawai dengan NIP yang sama');
            return redirect('/manage/pegawai');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        $users = User::latest()->get();
        $jabatans = Jabatan::latest()->get();
        return view('content.admin.pegawai.edit', compact('users', 'jabatans', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, Pegawai $pegawai)
    {
        $validation = $req->validate([
            'nip' => 'required',
            'nama' => 'required',
            'jabatan_id' => 'required',
        ]);

        try {
            $pegawai->update($validation);
            Alert::toast('Data user barhasil diupdate!', 'success');
            return redirect('/manage/pegawai');
        } catch (QueryException $e) {
            Alert::error('Oops', 'Tidak dapat merubah data pegawai dengan NIP yang sama');
            return redirect('/manage/pegawai');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {   
        try {
            Pegawai::findOrFail($pegawai->id)->delete();
            Alert::toast('Data user berhasil dihapus!', 'success');
            return redirect('/manage/pegawai');
        } catch (QueryException $e) {
            Alert::error('Opps', 'Tidak dapat menghapus data pegawai karena masih digunakan pada data lain');
            return redirect('/manage/pegawai');
        }
    }
}
