<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Kolektor;
use App\Models\Pinjaman;
use App\Models\Simpanan;

class DashboardController extends Controller
{
    public function indexPage()
    {
        $totalKolektor = Kolektor::count();
        $totalAnggota = Anggota::count();
        $totalPinjaman = Pinjaman::sum('nominal');
        $totalSimpanan = Simpanan::sum('total_simpanan_wajib') + Simpanan::sum('total_simpanan_sukarela');

        // Data untuk grafik status pinjaman (pie)
        $statusPinjaman = Pinjaman::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Data untuk grafik jenis simpanan (bar)
        $jenisSimpanan = Simpanan::selectRaw('jenis, COUNT(*) as total')
            ->groupBy('jenis')
            ->pluck('total', 'jenis');

        return view('admin.pages.dashboard.index', compact(
            'totalKolektor',
            'totalAnggota',
            'totalPinjaman',
            'totalSimpanan',
            'statusPinjaman',
            'jenisSimpanan'
        ));
    }
}
