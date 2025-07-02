<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\PinjamanController;
use App\Http\Controllers\Admin\SimpananController;
use App\Http\Controllers\Admin\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Login API (untuk anggota/kolektor via Ionic)
Route::post('/login/angkolektor', [LoginController::class, 'processAngKolektorLogin']);

// API untuk anggota mengajukan pinjaman
Route::middleware('auth:sanctum')->prefix('anggota')->group(function () {
    Route::post('/pinjaman/request', [PinjamanController::class, 'simpanRequest']);
    Route::post('/pinjaman/ajukan', [PinjamanController::class, 'simpanPengajuan']);
    Route::get('/pinjaman', [PinjamanController::class, 'indexAPI']);
});

// Contoh endpoint tambahan untuk melihat daftar pinjaman
Route::middleware('auth:sanctum')->get('/pinjaman', [PinjamanController::class, 'indexAPI']);

