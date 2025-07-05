<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kolektor;
use App\Models\Anggota;
use App\Models\Pinjaman;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KolektorController extends Controller
{
    public function getProfile($id)
    {
        $kolektor = Kolektor::find($id);

        if (!$kolektor) {
            return response()->json(['status' => 'error', 'message' => 'Kolektor tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'kolektor' => $kolektor
        ]);
    }

    public function getAnggotaByKolektor($id)
    {
        try {
            $anggotaIds = DB::table('relasi_kolektor_anggota')
                ->where('kolektor_id', $id)
                ->pluck('anggota_id');
                

            $anggota = Anggota::whereIn('id', $anggotaIds)
                ->get()
                ->map(function ($item) {
                    $pinjamanTerbaru = Pinjaman::where('anggota_id', $item->id)
                        ->orderBy('created_at', 'desc') // atau 'tanggal_pinjaman'
                        ->first();

                    $tagihanHariIni = 0;
                    $bunga = 0;
                    $totalTagihan = 0;

                    if ($pinjamanTerbaru) {
                        $nominalTotal = $pinjamanTerbaru->nominal ?? 0;
                        $lamaAngsuran = $pinjamanTerbaru->lama_angsuran ?? 1;
                        $jumlahHari = $lamaAngsuran * 30;

                        // Hitung bunga 5%
                        $bunga = round($nominalTotal * 0.05, 0);

                        // Hitung total + bunga
                        $totalDenganBunga = $nominalTotal + $bunga;

                        // Hitung angsuran harian (tanpa bunga)
                        if ($jumlahHari > 0) {
                            // ✅ Angsuran harian sudah ditambah bunga
                            $tagihanHariIni = round($totalDenganBunga / $jumlahHari, 0);
                        }

                        // Total tagihan keseluruhan
                        $totalTagihan = $nominalTotal + $bunga;
                    }

                    return [
                        'id' => $item->id,
                        'nama' => $item->nama,
                        'hp' => $item->hp,
                        'rekening' => $item->rekening ?? '—',
                        'bunga' => $bunga,
                        'total_tagihan' => $totalTagihan,
                        'hutang' => $pinjamanTerbaru?->sisa_tagihan ?? 0,
                        // 'tagihan_hari_ini' => $pinjamanTerbaru?->tagihan_hari_ini ?? 0,
                        'tagihan_hari_ini' => $tagihanHariIni,
                        'status' => $pinjamanTerbaru?->status ?? 'Tidak Ada',
                    ];
                });

            return response()->json([
                'status' => 'success',
                'anggota' => $anggota
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data anggota.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getDashboardData($id)
    {
        $totalAnggota = 0;
        $totalTagihanBulanIni = 0;
        $totalDibayar = 0;
        $totalPinjaman = 0;

        try {
            $anggotaIds = DB::table('relasi_kolektor_anggota')
                ->where('kolektor_id', $id)
                ->pluck('anggota_id');

            if ($anggotaIds->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Belum ada anggota yang dinaungi.',
                    'total_anggota' => 0,
                    'total_tagihan_bulan_ini' => 0,
                    'total_tagihan_dibayar' => 0,
                    'total_pinjaman' => 0
                ]);
            }

            $totalAnggota = $anggotaIds->count();

            $totalTagihanBulanIni = Pinjaman::whereIn('anggota_id', $anggotaIds)
                ->whereNotNull('sisa_tagihan')
                ->whereIn('status', ['belum bayar', 'sudah bayar', 'lunas'])
                ->sum('sisa_tagihan');

            // ✅ PERBAIKAN DI SINI:
            $totalDibayar = DB::table('pembayaran_simpanan')
                ->where('jenis', 'tagihan')
                ->where('status', 'diterima')
                ->whereIn('anggota_id', $anggotaIds)
                ->sum('jumlah');

            $totalPinjaman = Pinjaman::whereIn('anggota_id', $anggotaIds)
                ->whereNotNull('nominal')
                ->whereIn('status', ['belum bayar', 'sudah bayar', 'lunas'])
                ->sum('nominal');

            return response()->json([
                'status' => 'success',
                'total_anggota' => $totalAnggota,
                'total_tagihan_bulan_ini' => (float) $totalTagihanBulanIni,
                'total_tagihan_dibayar' => (float) $totalDibayar,
                'total_pinjaman' => (float) $totalPinjaman
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'success',
                'message' => 'Terjadi kesalahan saat mengambil data dashboard.',
                'total_anggota' => $totalAnggota,
                'total_tagihan_bulan_ini' => (float) $totalTagihanBulanIni,
                'total_tagihan_dibayar' => (float) $totalDibayar,
                'total_pinjaman' => (float) $totalPinjaman,
                'warning' => $e->getMessage()
            ], 200);
        }

    }

}


