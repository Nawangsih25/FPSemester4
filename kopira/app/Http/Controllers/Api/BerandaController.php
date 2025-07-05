<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Simpanan;
use App\Models\Pinjaman;
use App\Models\Transaksi;

class BerandaController extends Controller
{
    public function getBerandaData($anggota_id)
    {
        $anggota = Anggota::find($anggota_id);

        if (!$anggota) {
            return response()->json(['status' => 'error', 'message' => 'Anggota tidak ditemukan']);
        }

        $saldoWajib = Simpanan::where('anggota_id', $anggota_id)
            ->sum('total_simpanan_wajib');

        $saldoSukarela = Simpanan::where('anggota_id', $anggota_id)
            ->sum('total_simpanan_sukarela');

        $pinjamanTerpakai = Pinjaman::where('anggota_id', $anggota_id)
            ->whereIn('status', ['belum bayar', 'sudah bayar'])
            ->sum('sisa_tagihan');

        $riwayat = Transaksi::where('anggota_id', $anggota_id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($trx) {
                return [
                    'jenis' => $trx->jenis,
                    'jumlah' => $trx->jumlah,
                    'tanggal' => \Carbon\Carbon::parse($trx->tanggal)->format('d M Y'),
                    'keterangan' => $trx->keterangan,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => [
                    'limit_pinjaman' => $anggota->limit_pinjaman,
                    'saldo_wajib' => $saldoWajib,
                    'saldo_sukarela' => $saldoSukarela,
                    'pinjaman_terpakai' => $pinjamanTerpakai,
                    'riwayat' => $riwayat
                ]
            ]);
    }
}
