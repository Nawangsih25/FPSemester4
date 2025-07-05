<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Simpanan;
use App\Models\Pinjaman;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use App\Models\PembayaranSimpanan;



class LaporanController extends Controller
{
    public function indexPage(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai') ?? now()->startOfMonth()->toDateString();
        $tanggalAkhir = $request->input('tanggal_akhir') ?? now()->endOfMonth()->toDateString();

        $totalSimpanan = PembayaranSimpanan::whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->where('status', 'diterima')
            ->sum('jumlah');

        $totalPinjaman = Pinjaman::whereBetween('tanggal_pinjam', [$tanggalMulai, $tanggalAkhir])->sum('nominal');
        $totalPembayaran = PembayaranSimpanan::whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])->sum('jumlah');
        $totalDenda = Pinjaman::whereBetween('tanggal_pinjam', [$tanggalMulai, $tanggalAkhir])->sum('denda');

        $saldoKas = $totalSimpanan + $totalPembayaran - $totalPinjaman;

        $pinjaman = collect(Pinjaman::with('anggota')
            ->whereBetween('tanggal_pinjam', [$tanggalMulai, $tanggalAkhir])
            ->get()
            ->map(fn($p) => [
                'tanggal' => $p->tanggal_pinjam,
                'jenis' => 'Pinjaman',
                'nama' => $p->anggota->nama ?? '-',
                'keterangan' => 'Pencairan pinjaman',
                'jumlah' => $p->nominal
            ]));

        $pembayaran_pinjaman = collect(Pembayaran::with('pinjaman.anggota')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->get()
            ->map(fn($p) => [
                'tanggal' => $p->tanggal,
                'jenis' => 'Pembayaran',
                'nama' => $p->pinjaman->anggota->nama ?? '-',
                'keterangan' => 'Angsuran',
                'jumlah' => $p->jumlah
            ]));

        $simpanan = collect(PembayaranSimpanan::with('anggota')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->where('status', 'diterima')
            ->get()
            ->map(fn($s) => [
                'tanggal' => $s->tanggal,
                'jenis' => 'Simpanan ' . ucfirst($s->jenis),
                'nama' => $s->anggota->nama ?? '-',
                'keterangan' => 'Setoran simpanan',
                'jumlah' => $s->jumlah
            ]));


        $transaksi = $simpanan->merge($pinjaman)->merge($pembayaran_pinjaman)->sortBy('tanggal');

        return view('admin.pages.laporan.index', compact(
            'totalSimpanan',
            'totalPinjaman',
            'totalPembayaran',
            'totalDenda',
            'saldoKas',
            'transaksi',
            'tanggalMulai',
            'tanggalAkhir'
        ));
    }

    public function exportPDF(Request $request)
    {
        [$tanggalMulai, $tanggalAkhir, $transaksi] = $this->getLaporanData($request);
        $timestamp = now()->format('Y-m-d_H-i-s');
        $pdf = Pdf::loadView('admin.pages.laporan.pdf', compact('transaksi', 'tanggalMulai', 'tanggalAkhir'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan_keuangan.pdf');
    }

    public function exportExcel(Request $request)
    {
        [$tanggalMulai, $tanggalAkhir, $transaksi] = $this->getLaporanData($request);
        $timestamp = now()->format('Y-m-d_H-i-s');
        return Excel::download(new LaporanExport($transaksi), "laporan_keuangan_{$timestamp}.xlsx");
    }

    private function getLaporanData(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai') ?? now()->startOfMonth()->toDateString();
        $tanggalAkhir = $request->input('tanggal_akhir') ?? now()->endOfMonth()->toDateString();

        $pinjaman = collect(Pinjaman::with('anggota')
            ->whereBetween('tanggal_pinjam', [$tanggalMulai, $tanggalAkhir])
            ->get()
            ->map(fn($p) => [
                'tanggal' => $p->tanggal_pinjam,
                'jenis' => 'Pinjaman',
                'nama' => $p->anggota->nama ?? '-',
                'keterangan' => 'Pencairan pinjaman',
                'jumlah' => $p->nominal
            ]));

        $pembayaran = collect(Pembayaran::with('pinjaman.anggota')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->get()
            ->map(fn($p) => [
                'tanggal' => $p->tanggal,
                'jenis' => 'Pembayaran',
                'nama' => $p->pinjaman->anggota->nama ?? '-',
                'keterangan' => 'Angsuran',
                'jumlah' => $p->jumlah
            ]));

        $simpanan = collect(Simpanan::with('anggota')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->get()
            ->map(fn($s) => [
                'tanggal' => $s->tanggal,
                'jenis' => 'Simpanan ' . ucfirst($s->jenis),
                'nama' => $s->anggota->nama ?? '-',
                'keterangan' => 'Setoran simpanan',
                'jumlah' => $s->total_simpanan_wajib + $s->total_simpanan_sukarela
            ]));

        $transaksi = $simpanan->merge($pinjaman)->merge($pembayaran)->sortBy('tanggal')->values();

        return [$tanggalMulai, $tanggalAkhir, $transaksi];
    }
}
