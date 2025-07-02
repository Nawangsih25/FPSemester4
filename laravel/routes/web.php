<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AnggotaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KolektorController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PinjamanController;
use App\Http\Controllers\Admin\SimpananController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\RelasiKolektorController;
use App\Http\Controllers\Admin\PembayaranController;


// Testing
use Illuminate\Http\Request;
use App\Models\Simpanan;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// -- Auth Routes Login/logout --
Route::get('/login', [LoginController::class, 'indexPage'])->name('login');
Route::post('/login', [LoginController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/login/angkolektor', [LoginController::class, 'angKolektorLoginPage'])->name('login.angkolektor');
Route::post('/login/angkolektor', [LoginController::class, 'processAngKolektorLogin'])->name('login.angkolektor.process');

// ✅ Group route dengan prefix 'admin' + middleware auth
Route::prefix('admin')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'indexPage'])->name('dashboard');
    // Halaman Lainnya
    Route::get('/about', [AboutController::class, 'indexPage'])->name('about');
    Route::get('/kolektor', [KolektorController::class, 'indexPage'])->name('kolektor.index');
    Route::get('/anggota', [AnggotaController::class, 'indexPage'])->name('anggota.index');
    Route::get('/transaksi', [TransaksiController::class, 'indexPage'])->name('transaksi.index');
    Route::get('/pinjaman', [PinjamanController::class, 'indexPage'])->name('pinjaman.index');
    Route::get('/laporan', [LaporanController::class, 'indexPage'])->name('laporan.index');
    Route::get('/simpanan', [SimpananController::class, 'indexPage'])->name('simpanan.index');
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');

    // Tambah Data
    Route::get('/kolektor/tambah', [KolektorController::class, 'tambahData'])->name('kolektor.tambah');
    Route::get('/anggota/tambah', [AnggotaController::class, 'tambahData'])->name('anggota.tambah');
    Route::get('/pinjaman/tambah', [PinjamanController::class, 'tambah'])->name('pinjaman.tambah');

    // Simpan Data
    Route::post('/anggota/tambah', [AnggotaController::class, 'simpanData'])->name('anggota.simpan');
    Route::post('/kolektor/tambah', [KolektorController::class, 'simpanData'])->name('kolektor.simpan');
    Route::post('/pinjaman/simpan', [PinjamanController::class, 'simpan'])->name('pinjaman.simpan');
    Route::post('/simpanan/simpan', [SimpananController::class, 'simpan'])->name('simpanan.simpan');
    Route::post('/admin/pembayaran/simpan', [PembayaranController::class, 'simpanPembayaran'])->name('pembayaran.simpan');

    // Detail
    Route::get('/anggota/{id}', [AnggotaController::class, 'detail'])->name('anggota.detail');
    Route::get('/kolektor/{id}', [KolektorController::class, 'detail'])->name('kolektor.detail');

    // Edit
    Route::get('/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::get('/kolektor/{id}/edit', [KolektorController::class, 'edit'])->name('kolektor.edit');
    Route::get('/simpanan/{id}/edit', [SimpananController::class, 'edit'])->name('simpanan.edit');
    
    // Hapus
    Route::delete('/anggota/{id}', [AnggotaController::class, 'hapus'])->name('anggota.hapus');
    Route::delete('/kolektor/{id}', [KolektorController::class, 'hapus'])->name('kolektor.hapus');
    Route::delete('/simpanan/{id}', [SimpananController::class, 'destroy'])->name('simpanan.hapus');
    
    // Update Data
    Route::put('/anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::put('/kolektor/{id}', [KolektorController::class, 'update'])->name('kolektor.update');
    Route::put('/simpanan/{id}', [SimpananController::class, 'update'])->name('simpanan.update');

    // Permintaan, Setujui, Tolak
    Route::get('/pinjaman/permintaan', [PinjamanController::class, 'permintaan'])->name('pinjaman.permintaan');
    Route::post('/pinjaman/{id}/setujui', [PinjamanController::class, 'setujui'])->name('pinjaman.setujui');
    Route::post('/pinjaman/{id}/tolak', [PinjamanController::class, 'tolak'])->name('pinjaman.tolak');

    Route::get('/pinjaman/{id}/review', [PinjamanController::class, 'formReview'])->name('pinjaman.review.form');
    Route::put('/pinjaman/{id}/review', [PinjamanController::class, 'prosesReview'])->name('pinjaman.review');

    // Relasi Kolektor
    Route::get('/relasi-kolektor', [RelasiKolektorController::class, 'index'])->name('relasi.index');
    Route::post('/relasi-kolektor', [RelasiKolektorController::class, 'store'])->name('relasi.store');
    Route::delete('/relasi-kolektor/{id}', [RelasiKolektorController::class, 'destroy'])->name('relasi.destroy');
    Route::get('/kolektor/{id}/naungi', [RelasiKolektorController::class, 'kelola'])->name('kolektor.naungi');

    Route::post('/pinjaman/{id}/status', [PinjamanController::class, 'ubahStatus'])->name('pinjaman.ubahStatus');
    
    Route::get('/admin/pinjaman/cetak-pdf', [PinjamanController::class, 'cetakPDF'])->name('pinjaman.cetak.pdf');
    Route::get('/admin/simpanan/cetak', [SimpananController::class, 'cetakPDF'])->name('simpanan.cetak');

    Route::get('admin/laporan/export/pdf', [LaporanController::class, 'exportPDF'])->name('laporan.export.pdf');
    Route::get('admin/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');



});

Route::fallback(function () {
    return 'Halaman tidak ditemukan. Pastikan URL sudah benar.';
});

Route::middleware(['auth'])->prefix('anggota')->group(function () {
    Route::get('/pinjaman/request', [PinjamanController::class, 'formRequest'])->name('pinjaman.request');
    Route::post('/pinjaman/request', [PinjamanController::class, 'simpanRequest'])->name('pinjaman.request.simpan');
});

Route::middleware('auth')->group(function () {
    Route::get('/pinjaman/ajukan', [PinjamanController::class, 'formPengajuan'])->name('pinjaman.form');
    Route::post('/pinjaman/ajukan', [PinjamanController::class, 'simpanPengajuan'])->name('pinjaman.ajukan');
});


// Form test insert pinjaman
Route::get('/test/pinjaman', function () {
    return view('test.pinjaman');
});

// Simpan test pinjaman
Route::post('/test/pinjaman', function (\Illuminate\Http\Request $request) {
    \App\Models\Pinjaman::create([
        'anggota_id'       => $request->anggota_id,
        'nominal'          => $request->nominal,
        'tanggal_pinjam'   => $request->tanggal_pinjam,
        'status'           => 'pending' // default
    ]);
    return redirect('/test/pinjaman')->with('success', 'Data berhasil ditambahkan');
});

// Testing simpanan
Route::get('/test/simpanan', function () {
    $anggota = \App\Models\Anggota::all();
    return view('test.simpanan', compact('anggota'));
})->name('test.simpanan');

Route::post('/test/simpanan', function (Request $request) {
    $request->validate([
        'anggota_id' => 'required|exists:anggota,id',
        'jenis' => 'required|in:wajib,sukarela',
        'tanggal' => 'required|date',
        'nominal' => 'required|numeric|min:1000'
    ]);

    \App\Models\Simpanan::create([
        'anggota_id' => $request->anggota_id,
        'jenis' => $request->jenis,
        'tanggal' => $request->tanggal,
        'total_simpanan_wajib' => $request->jenis == 'wajib' ? $request->nominal : 0,
        'total_simpanan_sukarela' => $request->jenis == 'sukarela' ? $request->nominal : 0,
    ]);

    return back()->with('success', 'Simpanan berhasil ditambahkan');
});




