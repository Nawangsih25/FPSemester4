<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    // Menampilkan riwayat transaksi berdasarkan anggota_id
    public function riwayat($anggota_id)
    {
        $transaksi = Transaksi::where('anggota_id', $anggota_id)
                        ->orderBy('tanggal', 'desc')
                        ->take(5)
                        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $transaksi
        ]);
    }
}
