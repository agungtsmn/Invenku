<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function dashboard()
    {   
        // $response = Http::get('https://script.google.com/macros/s/AKfycbykmHraZSEEVtMdM3wyvfhv6AAqY17vanj_2pdM5Xhc2dzqzNlEXwrhVc-ZWgfVuhM2/exec');
        // $pegawai = $response->json();
        $title = 'Dashboard';
        return view('content.dashboard', compact('title'));
    }
}
