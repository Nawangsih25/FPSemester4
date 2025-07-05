<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\BerandaController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\PinjamanController;
use App\Http\Controllers\Api\KolektorController;
use App\Http\Controllers\Api\PembayaranController;
use App\Http\Controllers\Api\SimpananController;
use App\Http\Controllers\Api\PembayaranSimpananController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua endpoint API terdaftar di sini dan diatur oleh middleware serta guard
| sesuai role pengguna.
|--------------------------------------------------------------------------
*/

// ✅ Authenticated API untuk pengguna umum (provider: users)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ✅ Login API untuk anggota/kolektor dari aplikasi Ionic
Route::post('/login/angkolektor', [LoginController::class, 'processAngKolektorLogin']);
Route::post('/login', [LoginController::class, 'login']);

// ✅ API publik (tanpa auth)
Route::get('/beranda-data/{anggota_id}', [BerandaController::class, 'getBerandaData']);
Route::get('/riwayat-transaksi/{anggota_id}', [BerandaController::class, 'getBerandaData']);
Route::get('/tagihan-belum-bayar/{anggota_id}', [PinjamanController::class, 'getTagihanBelumBayar']);
Route::get('/pinjaman-aktif/{anggota_id}', [PinjamanController::class, 'getPinjamanAktif']);

// ✅ API khusus untuk anggota dengan guard `anggota-api`
Route::middleware('auth:anggota-api')->prefix('anggota')->group(function () {
    Route::post('/pinjaman/request', [PinjamanController::class, 'simpanRequest']);
    Route::post('/pinjaman/ajukan', [PinjamanController::class, 'simpanPengajuan']);
    Route::get('/pinjaman', [PinjamanController::class, 'indexAPI']);
});

// API khusus Kolektor
Route::middleware('auth:sanctum')->get('/kolektor/{id}', [KolektorController::class, 'getProfile']);
Route::get('/kolektor/{id}/anggota', [KolektorController::class, 'getAnggotaByKolektor']);
Route::get('/kolektor/dashboard/{id}', [KolektorController::class, 'getDashboardData']);


// ✅ Tambahan untuk melihat semua daftar pinjaman (guard default: users)
Route::middleware('auth:sanctum')->get('/pinjaman', [PinjamanController::class, 'indexAPI']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/anggota/pembayaran', [PembayaranController::class, 'store']);
    Route::get('/anggota/pembayaran', [PembayaranController::class, 'index']);
    Route::post('/anggota/simpanan', [SimpananController::class, 'store']);

});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/anggota/pembayaran-simpanan', [PembayaranSimpananController::class, 'store']);
});

Route::post('/anggota/pembayaran/konfirmasi/{id}', [PembayaranController::class, 'konfirmasiAnggota']);

Route::get('/notifikasi/{anggota_id}', [PembayaranController::class, 'getNotifikasi']);

Route::post('/pembayaran-simpanan/dari-kolektor', [PembayaranSimpananController::class, 'storeDariKolektor']);
