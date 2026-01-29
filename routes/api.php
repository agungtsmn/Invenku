<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ApiAuthController;
use App\Http\Controllers\Api\ApiPermintaanAtkController;

Route::post('/login', [ApiAuthController::class, 'loginProcess']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/permintaanAtk', [ApiPermintaanAtkController::class, 'index']);

});
