<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use Carbon\Carbon;

class PinjamanController extends Controller
{
    public function getPinjamanAktif($anggota_id)
    {
        try {
            $jumlah = Pinjaman::where('anggota_id', $anggota_id)
                ->whereIn('status', ['belum bayar', 'pending'])
                ->count();

            return response()->json([
                'status' => 'success',
                'data' => $jumlah
            ]);
        } catch (\Exception $e) {
            Log::error('Error getPinjamanAktif:', ['message' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan.'], 500);
        }
    }

    public function getTagihanBelumBayar($anggota_id)
    {
        try {
            $tagihan = Pinjaman::where('anggota_id', $anggota_id)
                ->where('status', 'belum bayar')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'amount' => 'Rp ' . number_format($item->tagihan_hari_ini, 0, ',', '.'),
                        'details' => [
                            'tenor' => $item->lama_angsuran . ' bulan',
                            'tagihan' => 'Rp ' . number_format($item->tagihan_hari_ini, 0, ',', '.'),
                            'jatuhTempo' => Carbon::parse($item->tanggal_pinjam)->addDays(7)->format('d M Y'),
                        ],
                        'checked' => false,
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data' => $tagihan
            ]);
        } catch (\Exception $e) {
            Log::error('Error getTagihanBelumBayar:', ['message' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil data tagihan.'], 500);
        }
    }

    public function simpanRequest(Request $request)
    {
        try {
            Log::info('User dari token:', ['user' => $request->user()]);
            $user = $request->user();

            if (!$user) {
                return response()->json(['message' => 'Token tidak valid atau user tidak dikenali'], 401);
            }

            $request->validate([
                'nominal' => 'required|numeric|min:100000',
                'lama_angsuran' => 'required|numeric|min:1'
            ]);

            $hariAngsuran = $request->lama_angsuran * 30;

            $bunga = $request->nominal * 0.05;
            $sisaTagihan = $request->nominal + $bunga;

            
            $pinjaman = Pinjaman::create([
                'anggota_id'     => $user->id,
                'nominal'        => $request->nominal,
                'tanggal_pinjam' => now(),
                'lama_angsuran'  => $request->lama_angsuran,
                'bunga'          => $bunga,
                'sisa_tagihan'   => $sisaTagihan,
                'status'         => 'pending'
            ]);

            return response()->json([
                'message' => 'Permintaan pinjaman berhasil dikirim',
                'data' => $pinjaman
            ], 200);

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan request pinjaman:', [
                'exception_message' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan di server.',
                'error' => $e->getMessage()
            ], 500);
        }

    }

}
