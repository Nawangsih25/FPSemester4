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
        $pembayaran = Pembayaran::with('pinjaman.anggota')->latest()->get();
        $pinjaman = \App\Models\Pinjaman::with('anggota')->where('status', '!=', 'lunas')->get();
        return view('admin.pages.pembayaran.index', compact('pembayaran'));
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
            'jumlah_pembayaran' => $request->jumlah,
            'tanggal_pembayaran' => $request->tanggal,
            'metode' => $request->metode,
            'status_verifikasi' => 'diterima'
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

    // ✅ Menampilkan daftar pembayaran dari anggota (dengan bukti)
    public function indexKonfirmasi()
    {
        $pembayaran = Pembayaran::with('pinjaman.anggota')->latest()->get();
        return view('admin.pages.pembayaran.index', compact('pembayaran'));
    }

    // ✅ Konfirmasi
    public function konfirmasi($id)
    {
        $data = Pembayaran::findOrFail($id);
        $data->status_verifikasi = 'diterima';
        $data->save();

        return back()->with('success', 'Pembayaran anggota telah dikonfirmasi.');
    }

    // ✅ Tolak
    public function tolak($id)
    {
        $data = Pembayaran::findOrFail($id);
        $data->status_verifikasi = 'ditolak';
        $data->save();

        return back()->with('success', 'Pembayaran anggota telah ditolak.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:1000',
        ]);

        \App\Models\Pembayaran::create([
            'pinjaman_id' => $request->pinjaman_id,
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
        ]);

        return back()->with('success', 'Pembayaran berhasil disimpan.');
    }


}
