<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pinjaman;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{

    public function index()
    {
        $pinjaman = \App\Models\Pinjaman::with('anggota')->where('status', '!=', 'lunas')->get();
        return view('admin.pages.pembayaran.index', compact('pinjaman'));
    }


    public function simpanPembayaran(Request $request)
    {
        $request->validate([
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
            'metode' => 'nullable|string'
        ]);

        $pinjaman = Pinjaman::findOrFail($request->pinjaman_id);

        // Simpan pembayaran
        Pembayaran::create([
            'pinjaman_id' => $pinjaman->id,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'metode' => $request->metode,
        ]);

        // Kurangi sisa tagihan
        $pinjaman->sisa_tagihan -= $request->jumlah;

        // Jika sudah lunas
        if ($pinjaman->sisa_tagihan <= 0) {
            $pinjaman->status = 'lunas';
            $pinjaman->sisa_tagihan = 0;
        } else {
            // Update status sesuai hari ini
            $sudahBayarHariIni = $pinjaman->pembayaran()
                ->whereDate('tanggal', \Carbon\Carbon::today())
                ->exists();

            $pinjaman->status = $sudahBayarHariIni ? 'sudah bayar' : 'belum bayar';
        }

        // Rehitung tagihan_hari_ini TETAP dari nominal+bunga
        if ($pinjaman->lama_angsuran > 0) {
            $totalHari = $pinjaman->lama_angsuran * 30;
            $tagihanHariIni = round(($pinjaman->nominal + $pinjaman->bunga) / $totalHari, 2);
            $pinjaman->tagihan_hari_ini = $tagihanHariIni;
        }

        $pinjaman->save();

        return redirect()->route('pinjaman.index')->with('success', 'Pembayaran berhasil.');
    }

}
