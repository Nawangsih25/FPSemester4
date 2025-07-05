<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\PembayaranSimpanan;
use Illuminate\Support\Facades\Validator;
use App\Models\Pinjaman;

class PembayaranSimpananController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang diterima dari frontend
        $request->validate([
            'jenis' => 'required|string|in:wajib,sukarela,tagihan',
            'jumlah' => 'required|numeric|min:1000',
            'metode' => 'required|string',
            'tanggal' => 'required|date',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            // Pastikan user dari token sudah terverifikasi
            $user = $request->user();
            if (!$user) {
                return response()->json(['message' => 'User tidak dikenali. Harap login ulang.'], 401);
            }

            // Simpan file gambar bukti pembayaran
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_simpanan', 'public');

            // Buat data pembayaran baru
            $data = PembayaranSimpanan::create([
                'anggota_id' => $user->id,
                'jenis' => $request->jenis,
                'jumlah' => $request->jumlah,
                'metode' => $request->metode,
                'tanggal' => $request->tanggal,
                'bukti_pembayaran' => $buktiPath,
                'status' => 'pending',
            ]);

            return response()->json([
                'message' => '✅ Pembayaran berhasil dikirim. Menunggu verifikasi admin.',
                'data' => $data,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan pembayaran simpanan:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => '❌ Terjadi kesalahan di server.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeDariKolektor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'anggota_id' => 'required|exists:anggota,id',
            'jumlah' => 'required|integer|min:1000',
            'metode' => 'nullable|string',
            'tanggal' => 'required|date',
            'kolektor_id' => 'required|exists:kolektor,id'
        ]);

        if ($validator->fails()) {
            Log::error('Validasi gagal:', $validator->errors()->all());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Simpan ke tabel pembayaran_simpanan
        $pembayaran = PembayaranSimpanan::create([
            'anggota_id' => $request->anggota_id,
            'jenis' => 'tagihan',
            'jumlah' => $request->jumlah,
            'metode' => $request->metode,
            'tanggal' => $request->tanggal,
            'status' => 'pending'
        ]);

        // Ambil pinjaman aktif milik anggota
        $pinjaman = Pinjaman::where('anggota_id', $request->anggota_id)
            ->whereIn('status', ['belum bayar', 'sudah bayar'])
            ->orderBy('created_at', 'desc') // ambil yang terbaru
            ->first();

        if ($pinjaman) {
            $sisaBaru = $pinjaman->sisa_tagihan - $request->jumlah;
            $pinjaman->update([
                'sisa_tagihan' => max($sisaBaru, 0),
                'status' => $sisaBaru <= 0 ? 'lunas' : 'sudah bayar'
            ]);
        }

        return response()->json([
            'message' => 'Pembayaran oleh kolektor berhasil dikirim',
            'data' => $pembayaran
        ], 201);
    }

    public function getRiwayatTransaksiKolektor($kolektor_id)
    {
        $transaksi = \App\Models\PembayaranSimpanan::with('anggota')
            ->where('kolektor_id', $kolektor_id)
            ->where('jenis', 'tagihan')
            ->where('status', 'diterima')
            ->orderByDesc('tanggal')
            ->get();

        return response()->json([
            'status' => 'success',
            'transaksi' => $transaksi
        ]);
    }


}
