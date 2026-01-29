<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanBmnController;
use App\Http\Controllers\PermintaanAtkController;
use App\Http\Controllers\PeminjamanRuangController;
use App\Http\Controllers\PengembalianBmnController;
use App\Http\Controllers\PeminjamanKendaraanController;
use App\Http\Controllers\TandaTanganController;

Route::middleware(['guest'])->group(function()
{
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess']);
});

Route::middleware(('auth'))->group(function()
{
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['checkRole:Super Admin'])->group(function()
{   
    // Pengelolaan user, jabatan, pegawai, pemintaanAtk
    Route::resource('/manage/user', UserController::class);
    Route::resource('/manage/jabatan', JabatanController::class);
    Route::resource('/manage/pegawai', PegawaiController::class);
    Route::resource('/manage/permintaanAtk', PermintaanAtkController::class);
    Route::resource('/manage/peminjamanRuang', PeminjamanRuangController::class);
    Route::resource('/manage/peminjamanKendaraan', PeminjamanKendaraanController::class);
    // Route::resource('/manage/peminjamanBmn', PeminjamanBmnController::class);
    // Route::resource('/manage/pengembalianBmn', PengembalianBmnController::class);
});

// Ekspor PDF (untuk 5 role)
Route::middleware(['checkRole:Petugas,Petugas BMN,Katim,Kasubag TU,Super Admin'])->group(function () {

    // Ekspor form permintaan Atk
    Route::get('/permintaanAtk/{permintaanAtk}/pdf', [PdfController::class, 'permintaanAtkPdf']);
    
    // Ekspor form peminjaman ruang
    Route::get('/peminjamanRuang/{peminjamanRuang}/pdf', [PdfController::class, 'peminjamanRuangPdf']);
    
    // Ekspor form peminjaman kendaraan
    Route::get('/peminjamanKendaraan/{peminjamanKendaraan}/pdf', [PdfController::class, 'peminjamanKendaraanPdf']);
    
    // Ekspor form peminjaman Bmn
    // Route::get('/peminjamanBmn/{peminjamanBmn}/pdf', [PdfController::class, 'peminjamanBmnPdf']);
});

// Menampilkan data permintaan Atk, peminjaman, dll
Route::middleware(['checkRole:Petugas,Petugas BMN,Katim,PPK,Kasubag TU,Resepsionis'])->group(function () {

    // Menampilkan data permintaan Atk
    Route::get('/permintaanAtk', [PermintaanAtkController::class, 'index']);

    // Menampilkan data peminjaman ruang
    Route::get('/peminjamanRuang', [PeminjamanRuangController::class, 'index']);

    // Menampilkan data peminjaman kendaraan
    Route::get('/peminjamanKendaraan', [PeminjamanKendaraanController::class, 'index']);

    // Menampilkan data peminjaman Bmn
    // Route::get('/peminjamanBmn', [PeminjamanBmnController::class, 'index']);
});

// Petugas bisa ajukan permintaan Atk, peminjaman, dll
Route::middleware(['checkRole:Petugas'])->group(function () {

    // Mengajukan permintaan Atk
    Route::get('/permintaanAtk/create', [PermintaanAtkController::class, 'create']);
    Route::post('/permintaanAtk', [PermintaanAtkController::class, 'store']);
    Route::get('/permintaanAtk/{permintaanAtk}/edit', [PermintaanAtkController::class, 'edit']);
    Route::put('/permintaanAtk/{permintaanAtk}', [PermintaanAtkController::class, 'update']);
    Route::delete('/permintaanAtk/{permintaanAtk}', [PermintaanAtkController::class, 'destroy']);

    // Mengajukan peminjaman ruang
    Route::get('/peminjamanRuang/create', [PeminjamanRuangController::class, 'create']);
    Route::post('/peminjamanRuang', [PeminjamanRuangController::class, 'store']);
    Route::get('/peminjamanRuang/{peminjamanRuang}/edit', [PeminjamanRuangController::class, 'edit']);
    Route::put('/peminjamanRuang/{peminjamanRuang}', [PeminjamanRuangController::class, 'update']);
    Route::delete('/peminjamanRuang/{peminjamanRuang}', [PeminjamanRuangController::class, 'destroy']);

    // Mengajukan peminjaman kendaraan
    Route::get('/peminjamanKendaraan/create', [PeminjamanKendaraanController::class, 'create']);
    Route::post('/peminjamanKendaraan', [PeminjamanKendaraanController::class, 'store']);
    Route::get('/peminjamanKendaraan/{peminjamanKendaraan}/edit', [PeminjamanKendaraanController::class, 'edit']);
    Route::put('/peminjamanKendaraan/{peminjamanKendaraan}', [PeminjamanKendaraanController::class, 'update']);
    Route::delete('/peminjamanKendaraan/{peminjamanKendaraan}', [PeminjamanKendaraanController::class, 'destroy']);

    // Mengajukan peminjaman Bmn
    // Route::get('/peminjamanBmn/create', [PeminjamanBmnController::class, 'create']);
    // Route::post('/peminjamanBmn', [PeminjamanBmnController::class, 'store']);
    // Route::get('/peminjamanBmn/{peminjamanBmn}/edit', [PeminjamanBmnController::class, 'edit']);
    // Route::put('/peminjamanBmn/{peminjamanBmn}', [PeminjamanBmnController::class, 'update']);
    // Route::delete('/peminjamanBmn/{peminjamanBmn}', [PeminjamanBmnController::class, 'destroy']);
});

// Katim mengAcc permintaan Atk, peminjaman, dll
Route::middleware(['checkRole:Katim'])->group(function () {

    // Mengecek permintaan Atk
    Route::get('/permintaanAtk/{permintaanAtk}/cekKatim', [PermintaanAtkController::class, 'cekKatim']);
    Route::put('/permintaanAtk/{permintaanAtk}/accKatim', [PermintaanAtkController::class, 'accKatim']);

    // Mengecek peminjaman ruang
    Route::get('/peminjamanRuang/{peminjamanRuang}/check', [PeminjamanRuangController::class, 'check']);
    Route::put('/peminjamanRuang/{peminjamanRuang}/accepted', [PeminjamanRuangController::class, 'accepted']);

    // Mengecek peminjaman kendaraan
    Route::get('/peminjamanKendaraan/{peminjamanKendaraan}/check', [PeminjamanKendaraanController::class, 'check']);
    Route::put('/peminjamanKendaraan/{peminjamanKendaraan}/accepted', [PeminjamanKendaraanController::class, 'accepted']);

    // Mengecek peminjaman Bmn
    // Route::get('/peminjamanBmn/{peminjamanBmn}/check', [PeminjamanBmnController::class, 'check']);
    // Route::put('/peminjamanBmn/{peminjamanBmn}/accepted', [PeminjamanBmnController::class, 'accepted']);
});

// PPK mengAcc permintaan Atk, peminjaman, dll
Route::middleware(['checkRole:PPK'])->group(function () {

    // Mengecek permintaan Atk
    Route::get('/permintaanAtk/{permintaanAtk}/cekPpk', [PermintaanAtkController::class, 'cekPpk']);
    Route::put('/permintaanAtk/{permintaanAtk}/accPpk', [PermintaanAtkController::class, 'accPpk']);

    // Mengecek peminjaman ruang
    // Route::get('/peminjamanRuang/{peminjamanRuang}/check', [PeminjamanRuangController::class, 'check']);
    // Route::put('/peminjamanRuang/{peminjamanRuang}/accepted', [PeminjamanRuangController::class, 'accepted']);

    // Mengecek peminjaman kendaraan
    // Route::get('/peminjamanKendaraan/{peminjamanKendaraan}/check', [PeminjamanKendaraanController::class, 'check']);
    // Route::put('/peminjamanKendaraan/{peminjamanKendaraan}/accepted', [PeminjamanKendaraanController::class, 'accepted']);

    // Mengecek peminjaman Bmn
    // Route::get('/peminjamanBmn/{peminjamanBmn}/check', [PeminjamanBmnController::class, 'check']);
    // Route::put('/peminjamanBmn/{peminjamanBmn}/accepted', [PeminjamanBmnController::class, 'accepted']);
});

// Kasubag TU / Petugas BMN mengAcc permintaan Atk, peminjaman, dll
Route::middleware(['checkRole:Kasubag TU,Petugas BMN'])->group(function () {

    // Menyetujui permintaan Atk
    Route::get('/permintaanAtk/{permintaanAtk}/cekKasubag', [PermintaanAtkController::class, 'cekKasubag']);
    Route::put('/permintaanAtk/{permintaanAtk}/accKasubag', [PermintaanAtkController::class, 'accKasubag']);

    // Menyetujui peminjaman ruang
    Route::get('/peminjamanRuang/{peminjamanRuang}/approval', [PeminjamanRuangController::class, 'approval']);
    Route::put('/peminjamanRuang/{peminjamanRuang}/approved', [PeminjamanRuangController::class, 'approved']);

    // Menyetujui peminjaman kendaraan
    Route::get('/peminjamanKendaraan/{peminjamanKendaraan}/approval', [PeminjamanKendaraanController::class, 'approval']);
    Route::put('/peminjamanKendaraan/{peminjamanKendaraan}/approved', [PeminjamanKendaraanController::class, 'approved']);

    // Menyetujui peminjaman Bmn
    // Route::get('/peminjamanBmn/{peminjamanBmn}/approval', [PeminjamanBmnController::class, 'approval']);
    // Route::put('/peminjamanBmn/{peminjamanBmn}/approved', [PeminjamanBmnController::class, 'approved']);
});

// Petugas BMN mengAcc permintaan Atk, peminjaman, dll
Route::middleware(['checkRole:Petugas BMN'])->group(function () {

    // Memverifikasi permintaan Atk
    Route::get('/permintaanAtk/{permintaanAtk}/cekBmn', [PermintaanAtkController::class, 'cekBmn']);
    Route::put('/permintaanAtk/{permintaanAtk}/accBmn', [PermintaanAtkController::class, 'accBmn']);

    // Memverifikasi peminjaman ruang
    Route::get('/peminjamanRuang/{peminjamanRuang}/verifing', [PeminjamanRuangController::class, 'verifing']);
    Route::put('/peminjamanRuang/{peminjamanRuang}/verifid', [PeminjamanRuangController::class, 'verifid']);

    // Memverifikasi peminjaman kendaraan
    Route::get('/peminjamanKendaraan/{peminjamanKendaraan}/verifing', [PeminjamanKendaraanController::class, 'verifing']);
    Route::put('/peminjamanKendaraan/{peminjamanKendaraan}/verifid', [PeminjamanKendaraanController::class, 'verifid']);

    // Memverifikasi peminjaman Bmn
    // Route::get('/peminjamanBmn/{peminjamanBmn}/verifing', [PeminjamanBmnController::class, 'verifing']);
    // Route::put('/peminjamanBmn/{peminjamanBmn}/verifid', [PeminjamanBmnController::class, 'verifid']);
});

// Katim, Petugas BMN, dan kasubag TU menolak permintaan Atk, peminjaman, dll dengan seluruh status
Route::middleware(['checkRole:Petugas BMN,Katim,Kasubag TU'])->group(function () {

    // Menolak permintaan Atk
    Route::get('permintaanAtk/list', [PermintaanAtkController::class, 'listAtk']);

});

// PPK, Petugas BMN, dan kasubag TU menolak permintaan Atk, peminjaman, dall
Route::middleware(['checkRole:Petugas BMN,PPK,Kasubag TU'])->group(function () {

    // Menolak permintaan Atk
    Route::put('/permintaanAtk/{permintaanAtk}/declined', [PermintaanAtkController::class, 'declined']);

    // Menolak peminjaman ruang
    Route::put('/peminjamanRuang/{peminjamanRuang}/declined', [PeminjamanRuangController::class, 'declined']);

    // Menolak peminjaman kendaraan
    Route::put('/peminjamanKendaraan/{peminjamanKendaraan}/declined', [PeminjamanKendaraanController::class, 'declined']);

    // Menolak peminjaman Bmn
    // Route::put('/peminjamanBmn/{peminjamanBmn}/declined', [PeminjamanBmnController::class, 'declined']);
});

Route::middleware(['checkRole:Resepsionis'])->group(function () {

    // Menampilkan halaman konfirmasi kesediaan ATK
    Route::get('permintaanAtk/{permintaanAtk}/cekKesediaan', [PermintaanAtkController::class, 'cekKesediaan']);

    // Mengkonfirmasi kesediaan ATK
    Route::put('permintaanAtk/{permintaanAtk}/konfirmasiKesediaan', [PermintaanAtkController::class, 'konfirmasiKesediaan']);

    // Menampilkan halaman konfirmasi selesai ATK
    Route::get('permintaanAtk/{permintaanAtk}/cekSelesai', [PermintaanAtkController::class, 'cekSelesai']);

    // Mengkonfirmasi selesai ATK
    Route::put('permintaanAtk/{permintaanAtk}/konfirmasiSelesai', [PermintaanAtkController::class, 'konfirmasiSelesai']);

});

Route::middleware(['checkRole:Petugas BMN,Kasubag TU'])->group(function () {

    // Menampilkan halaman upload tanda tangan
    Route::get('/tanda-tangan', [TandaTanganController::class, 'index']);

    // Upload tanda tangan ke sistem
    Route::post('/tanda-tangan', [TandaTanganController::class, 'store']);

});

