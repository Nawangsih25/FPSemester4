<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PembayaranSimpanan;
use App\Models\Simpanan;

class PembayaranSimpananController extends Controller
{
    // Menampilkan daftar pembayaran simpanan yang menunggu verifikasi
    public function index()
    {
        $data = PembayaranSimpanan::with('anggota')->latest()->get();
        return view('admin.pages.pembayaran.index', compact('data'));
    }

    // Konfirmasi valid -> masukkan ke tabel simpanan
    public function konfirmasi($id)
    {
        $bayar = PembayaranSimpanan::findOrFail($id);

        if ($bayar->jenis === 'tagihan') {
            // Ambil pinjaman aktif milik anggota
            $pinjaman = \App\Models\Pinjaman::where('anggota_id', $bayar->anggota_id)
                ->whereIn('status', ['belum bayar', 'sudah bayar'])
                ->orderBy('tanggal_pinjam', 'asc')
                ->first();

            if ($pinjaman) {
                // Kurangi sisa tagihan
                $pinjaman->sisa_tagihan -= $bayar->jumlah;

                // Jika sisa tagihan sudah lunas
                if ($pinjaman->sisa_tagihan <= 0) {
                    $pinjaman->status = 'lunas';
                    $pinjaman->sisa_tagihan = 0;
                } else {
                    $pinjaman->status = 'sudah bayar';
                }

                $pinjaman->save();
            }
        } else {
            // Simpan ke tabel simpanan jika bukan tagihan
            Simpanan::create([
                'anggota_id' => $bayar->anggota_id,
                'jenis' => $bayar->jenis,
                'jumlah' => $bayar->jumlah,
                'metode' => $bayar->metode,
                'tanggal' => $bayar->tanggal,
                'bukti_pembayaran' => $bayar->bukti_pembayaran,
                'total_simpanan_wajib' => $bayar->jenis === 'wajib' ? $bayar->jumlah : 0,
                'total_simpanan_sukarela' => $bayar->jenis === 'sukarela' ? $bayar->jumlah : 0,
            ]);
        }

        // Update status pembayaran simpanan (bukti tagihan)
        $bayar->status = 'diterima';
        $bayar->save();

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }


    // Jika tidak valid
    public function tolak($id)
    {
        $bayar = PembayaranSimpanan::findOrFail($id);
        $bayar->status = 'ditolak';
        $bayar->save();

        return back()->with('success', 'Pembayaran simpanan ditolak.');
    }
}
