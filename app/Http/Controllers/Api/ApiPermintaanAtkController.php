<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PermintaanAtk;
use Illuminate\Http\Request;

class ApiPermintaanAtkController extends Controller
{
    public function index(Request $req)
    {   
        $permintaanAtk = PermintaanAtk::where('petugas', $req->user_id)->get();
        return response()->json([
            'message' => 'Sukses mengambil data Permintaan ATK!',
            'error' => false,
            'data' => $permintaanAtk,
        ]);
    }
}
