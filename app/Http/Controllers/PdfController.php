<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PeminjamanBmn;
use App\Models\PermintaanAtk;
use App\Models\PeminjamanRuang;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PeminjamanKendaraan;
use App\Models\TandaTangan;

class PdfController extends Controller
{
    private function generatePdf($data, string $viewName)
    {
        $kasubagTu = User::where('role', 'Kasubag TU')->first();

        $payload = [
            'data' => $data,
            'kasubagTu' => $kasubagTu,
        ];

        return Pdf::loadView($viewName, $payload)
            ->setPaper('A4')
            ->setOption(['isRemoteEnabled' => true])
            ->stream();
    }

    public function permintaanAtkPdf(PermintaanAtk $permintaanAtk)
    {   
        $userAtasNama = User::where('pegawai_id', $permintaanAtk->atas_nama)->with('pegawai.tandaTangan')->first();
        $permintaanAtk->nama_an = $userAtasNama->pegawai->nama;
        $permintaanAtk->tanda_tangan_an = $userAtasNama->pegawai->tandaTangan->tanda_tangan;
        return $this->generatePdf($permintaanAtk, 'content.domPdf.permintaanAtk');
    }

    public function peminjamanRuangPdf(PeminjamanRuang $peminjamanRuang)
    {   
        return $this->generatePdf($peminjamanRuang, 'content.domPdf.peminjamanRuang');
    }

    public function peminjamanKendaraanPdf(PeminjamanKendaraan $peminjamanKendaraan)
    {
        return $this->generatePdf($peminjamanKendaraan, 'content.domPdf.peminjamanKendaraan');
    }

    public function peminjamanBmnPdf(PeminjamanBmn $peminjamanBmn)
    {
        return $this->generatePdf($peminjamanBmn, 'content.domPdf.peminjamanBmn');
    }
}
