<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $jabatans = Jabatan::latest()->get();
        return view('content.admin.jabatan.index', compact('jabatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        return view('content.admin.jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {   
        $validation = $req->validate([
            'nama_jabatan' => 'required',
        ]);

        Jabatan::Create($validation);

        Alert::toast('Data berhasil dibuat!', 'success');
        return redirect('/manage/jabatan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan)
    {   
        $title = 'Edit Jabatan';
        $jabatan = Jabatan::where('id', $jabatan->id)->first();
        // dd($jabatan);
        return view('content.admin.jabatan.edit', compact('title', 'jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, Jabatan $jabatan)
    {
        $validation = $req->validate([
            'nama_jabatan' => 'required',
        ]);
        
        $jabatan->update($validation);

        Alert::toast('Data berhasil diupdate!', 'success');
        return redirect('/manage/jabatan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        try {
            Jabatan::findOrFail($jabatan->id)->delete();
            Alert::toast('Data berhasil dihapus!', 'success');
            return redirect('/manage/jabatan');
        } catch (QueryException $e) {
            Alert::error('Opps', 'Tidak dapat menghapus jabatan karena masih digunakan pada data lain');
            return redirect('/manage/jabatan');
        }
    }
}
