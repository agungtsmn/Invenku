<?php

namespace App\Http\Controllers;

use App\Models\TandaTangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class TandaTanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('content.tandaTangan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {   
        $validation = $req->validate([
            'pegawai_id' => 'required',
            'tanda_tangan' => 'required',
        ]);

        // Proses merubah nama file tanda tangan agar tidak base64
        $signature = $req->tanda_tangan;
        $signature = str_replace('data:image/png;base64,', '', $signature);
        $signature = str_replace(' ', '+', $signature);
        $signatureName = 'tanda_tangan' . time() . '.png';

        // Proses simpan tanda tangan
        Storage::disk('public')->put("tanda_tangan/$signatureName", base64_decode($signature));

        // Ganti isi field di $validation agar hanya simpan nama file, bukan base64
        $validation['tanda_tangan'] = $signatureName;
        
        TandaTangan::updateOrCreate(
            ['pegawai_id' => $validation['pegawai_id']], // kondisi cek
            $validation // data update / create
        );

        Alert::toast('Tanda tangan berhasil dibuat!', 'success');

        return redirect('/tanda-tangan');
    }

    /**
     * Display the specified resource.
     */
    public function show(TandaTangan $tandaTangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TandaTangan $tandaTangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TandaTangan $tandaTangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TandaTangan $tandaTangan)
    {
        //
    }
}
