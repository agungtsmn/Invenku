<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $users = User::latest()->with('pegawai')->get();
        return view('content.admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $pegawais = Pegawai::latest()->get();
        return view('content.admin.user.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $validation = $req->validate([
            'pegawai_id' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required',
        ]);

        User::Create($validation);

        Alert::toast('Data user berhasil dibuat!', 'success');
        return redirect('/manage/user');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {   

        $pegawais = Pegawai::latest()->get();
        return view('content.admin.user.edit', compact('user', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, User $user)
    {
        $validation = $req->validate([
            'pegawai_id' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        if ($req['password']) {
            $validation['password'] = Hash::make($req['password']);
        }

        $user->update($validation);

        Alert::toast('Data user berhasil diupdate!', 'success');
        return redirect('/manage/user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {   
        $user->delete();
        Alert::toast('Data user berhasil dihapus!', 'success');
        return redirect('/manage/user');
    }
}
