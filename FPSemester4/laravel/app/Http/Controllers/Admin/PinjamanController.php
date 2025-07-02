<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pinjaman;
use App\Models\Anggota;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PinjamanController extends Controller
{
    public function indexPage(Request $request)
    {
        $filter = $request->filter;

        $query = Pinjaman::with('anggota');

        if (in_array($filter, ['lunas', 'belum bayar', 'sudah bayar', 'pending', 'ditolak'])) {
            $query->where('status', $filter);
        }

        $pinjaman = $query->get();

        foreach ($pinjaman as $p) {
            if (in_array($p->status, ['pending', 'ditolak', 'lunas'])) {
                continue;
            }

            $sudahBayarHariIni = $p->pembayaran()
                ->whereDate('tanggal', Carbon::today())
                ->exists();

            $statusBaru = $p->status;

            if (
                !$sudahBayarHariIni &&
                $p->status === 'sudah bayar' &&
                Carbon::parse($p->tanggal_respon)->format('Y-m-d') !== now()->format('Y-m-d')
            ) {
                $statusBaru = 'belum bayar';
            }

            $totalHari = $p->lama_angsuran * 30;
            $tagihanHariIni = $totalHari > 0 ? round(($p->nominal + $p->bunga) / $totalHari, 2) : 0;

            $p->update([
                'status' => $statusBaru,
                'tagihan_hari_ini' => $tagihanHariIni,
            ]);

            if ($statusBaru === 'belum bayar') {
                $selisihHari = Carbon::parse($p->tanggal_pinjam)->diffInDays(now());
                if ($selisihHari >= 7 && $p->denda == 0) {
                    $p->update(['denda' => $p->nominal * 0.02]);
                }
            }

            if (!is_null($p->sisa_tagihan) && $p->sisa_tagihan <= 0 && $statusBaru !== 'lunas') {
                $p->update(['status' => 'lunas']);
            }
        }

        return view('admin.pages.pinjaman.index', compact('pinjaman'));
    }

    public function tambah()
    {
        $anggota = Anggota::all();
        return view('admin.pages.pinjaman.tambah', compact('anggota'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'anggota_id'        => 'required|exists:anggota,id',
            'nominal'           => 'required|numeric|min:1',
            'tanggal_pinjam'    => 'required|date',
            'lama_angsuran'     => 'required|integer|min:1',
            'status'            => 'required|in:aktif,lunas',
        ]);

        $bunga = $request->nominal * 0.05;
        $sisa_tagihan = $request->nominal + $bunga;

        Pinjaman::create([
            'anggota_id'     => $request->anggota_id,
            'nominal'        => $request->nominal,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'lama_angsuran'  => $request->lama_angsuran,
            'status'         => $request->status,
            'bunga'          => $bunga,
            'sisa_tagihan'   => $sisa_tagihan,
            'tanggal_respon' => now()
        ]);

        return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil ditambahkan.');
    }

    public function formRequest() 
    {
        return view('anggota.pinjaman.request');
    }

    // public function simpanRequest(Request $request) 
    // {
    //     $request->validate([
    //         'nominal' => 'required|numeric|min:100000',
    //     ]);

    //     Pinjaman::create([
    //         'anggota_id'     => Auth::id(),
    //         'nominal'        => $request->nominal,
    //         'tanggal_pinjam' => now(),
    //         'status'         => 'pending',
    //     ]);

    //     return redirect()->route('anggota.dashboard')->with('success', 'Permintaan pinjaman dikirim.');
    // }

    public function simpanRequest(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:100000',
        ]);

        $pinjaman = Pinjaman::create([
            'anggota_id'     => Auth::id(),
            'nominal'        => $request->nominal,
            'tanggal_pinjam' => now(),
            'status'         => 'pending',
        ]);

        return response()->json([
            'message' => 'Permintaan pinjaman dikirim',
            'data' => $pinjaman
        ], 201);
    }


    public function formPengajuan()
    {
        return view('pinjaman.pengajuan');
    }

    public function simpanPengajuan(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:100000',
            'tanggal_pinjam' => 'required|date',
        ]);

        Pinjaman::create([
            'anggota_id' => Auth::id(),
            'nominal' => $request->nominal,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status' => 'pending'
        ]);

        return redirect()->route('pinjaman.form')->with('success', 'Permintaan pinjaman berhasil diajukan.');
    }

    public function permintaan()
    {
        $data = Pinjaman::with('anggota')->where('status', 'pending')->get();
        return view('admin.pages.pinjaman.permintaan', compact('data'));
    }

    public function setujui(Request $request, $id)
    {
        $request->validate(['lama_angsuran' => 'required|integer|min:1']);

        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->update([
            'status' => 'aktif',
            'lama_angsuran' => $request->lama_angsuran,
            'tanggal_respon' => now()
        ]);

        return redirect()->route('pinjaman.permintaan')->with('success', 'Pinjaman disetujui.');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate(['alasan_penolakan' => 'required']);

        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
            'tanggal_respon' => now()
        ]);

        return redirect()->route('pinjaman.permintaan')->with('success', 'Pinjaman ditolak.');
    }

    public function formReview($id)
    {
        $pinjaman = Pinjaman::with('anggota')->findOrFail($id);
        return view('admin.pages.pinjaman.request', compact('pinjaman'));
    }

    public function prosesReview(Request $request, $id)
    {
        $pinjaman = Pinjaman::findOrFail($id);

        if ($request->tindakan === 'setujui') {
            $request->validate(['lama_angsuran' => 'required|integer|min:1']);

            $bunga = $pinjaman->nominal * 0.05;
            $sisa_tagihan = $pinjaman->nominal + $bunga;

            $totalHari = $request->lama_angsuran * 30;
            $tagihanHariIni = $totalHari > 0 ? round(($pinjaman->nominal + $bunga) / $totalHari, 2) : 0;

            $pinjaman->update([
                'status' => 'sudah bayar',
                'lama_angsuran' => $request->lama_angsuran,
                'tanggal_respon' => now(),
                'bunga' => $bunga,
                'sisa_tagihan' => $sisa_tagihan,
                'tagihan_hari_ini' => $tagihanHariIni,
                'alasan_penolakan' => null
            ]);

        } elseif ($request->tindakan === 'tolak') {
            $request->validate(['alasan_penolakan' => 'required|string']);

            $pinjaman->update([
                'status' => 'ditolak',
                'alasan_penolakan' => $request->alasan_penolakan,
                'tanggal_respon' => now()
            ]);
        }

        return redirect()->route('pinjaman.permintaan')->with('success', 'Permintaan pinjaman diproses.');
    }

    public function ubahStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,ditolak,belum bayar,sudah bayar,lunas'
        ]);

        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pinjaman berhasil diperbarui.');
    }

    public function cetakPDF(Request $request)
    {
        $filter = $request->filter;

        $query = Pinjaman::with('anggota');

        if (in_array($filter, ['lunas', 'belum bayar', 'sudah bayar', 'pending', 'ditolak'])) {
            $query->where('status', $filter);
        }

        $pinjaman = $query->get();

        $pdf = Pdf::loadView('admin.pages.pinjaman.pdf', compact('pinjaman', 'filter'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan_pinjaman.pdf');
    }

    


}
