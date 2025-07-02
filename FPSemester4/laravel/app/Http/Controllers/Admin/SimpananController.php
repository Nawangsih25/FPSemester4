<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Simpanan;
use App\Models\Anggota;
use Barryvdh\DomPDF\Facade\Pdf;

class SimpananController extends Controller
{
    public function indexPage(Request $request)
    {
        $filter = $request->filter;

        $query = Simpanan::with('anggota');

        if (in_array($filter, ['wajib', 'sukarela'])) {
            $query->where('jenis', $filter);
        }

        $simpanan = $query->get();

        $saldoWajib = Simpanan::where('jenis', 'wajib')->sum('total_simpanan_wajib');
        $saldoSukarela = Simpanan::where('jenis', 'sukarela')->sum('total_simpanan_sukarela');
        $saldoPokok = Anggota::sum('deposito_awal');

        $anggotaList = Anggota::with('simpanan')->get();
        $statusPembayaran = [];

        foreach ($anggotaList as $anggota) {
            $tanggalSekarang = Carbon::now();
            $tanggalToleransi = $tanggalSekarang->copy()->day(5);

            $tanggalDaftar = Carbon::parse($anggota->tanggal_daftar);
            $bulanSetelahDaftar = $tanggalDaftar->copy()->addMonth()->startOfMonth();
            $bulanIni = $tanggalSekarang->copy()->startOfMonth();

            if ($bulanIni < $bulanSetelahDaftar) {
                $status = 'belum wajib membayar simpanan';
            } else {
                $bulanSebelumIni = $bulanIni->copy()->subMonth();
                $periode = CarbonPeriod::create($bulanSetelahDaftar, '1 month', $bulanSebelumIni);

                $telat = false;

                foreach ($periode as $bulan) {
                    $sudahBayar = $anggota->simpanan()
                        ->where('jenis', 'wajib')
                        ->whereMonth('tanggal', $bulan->month)
                        ->whereYear('tanggal', $bulan->year)
                        ->exists();

                    if (!$sudahBayar) {
                        $telat = true;
                        break;
                    }
                }

                $sudahBayarBulanIni = $anggota->simpanan()
                    ->where('jenis', 'wajib')
                    ->whereMonth('tanggal', $tanggalSekarang->month)
                    ->whereYear('tanggal', $tanggalSekarang->year)
                    ->exists();

                if ($sudahBayarBulanIni) {
                    $status = 'sudah membayar simpanan wajib';
                } elseif ($tanggalSekarang->greaterThan($tanggalToleransi)) {
                    $status = 'telat membayar simpanan wajib';
                } else {
                    $status = 'belum membayar simpanan wajib bulan ini';
                }

                if ($telat) {
                    $status = 'telat membayar simpanan wajib';
                }
            }

            $statusPembayaran[$anggota->id] = $status;
        }

        return view('admin.pages.simpanan.index', compact(
            'simpanan',
            'saldoWajib',
            'saldoSukarela',
            'saldoPokok',
            'filter',
            'statusPembayaran'
        ));
    }

    public function edit($id)
    {
        $simpanan = Simpanan::with('anggota')->findOrFail($id);
        return view('admin.pages.simpanan.edit', compact('simpanan'));
    }

    public function update(Request $request, $id)
    {
        $simpanan = Simpanan::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:wajib,sukarela',
            'nominal' => 'required|numeric|min:1000'
        ]);

        $simpanan->update([
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'total_simpanan_wajib' => $request->jenis === 'wajib' ? $request->nominal : 0,
            'total_simpanan_sukarela' => $request->jenis === 'sukarela' ? $request->nominal : 0
        ]);

        return redirect()->route('simpanan.index')->with('success', 'Simpanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $simpanan = Simpanan::findOrFail($id);
        $simpanan->delete();

        return redirect()->route('simpanan.index')->with('success', 'Simpanan berhasil dihapus.');
    }

    public function cetakPDF(Request $request)
    {
        $filter = $request->filter;

        $query = Simpanan::with('anggota');

        if (in_array($filter, ['wajib', 'sukarela'])) {
            $query->where('jenis', $filter);
        }

        $simpanan = $query->get();

        return Pdf::loadView('admin.pages.simpanan.pdf', compact('simpanan', 'filter'))
            ->setPaper('a4', 'landscape')
            ->stream('laporan_simpanan.pdf');
    }

    
}
