<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Simpanan;

class SimpananController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jenis' => 'required|in:wajib,sukarela',
            'jumlah' => 'required|numeric|min:10000',
            'tanggal' => 'required|date',
        ]);

        // Pisahkan nilai berdasarkan jenis
        $simpananData = [
            'anggota_id' => $request->anggota_id,
            'jenis' => $request->jenis,
            'tanggal' => $request->tanggal,
            'total_simpanan_wajib' => $request->jenis === 'wajib' ? $request->jumlah : 0,
            'total_simpanan_sukarela' => $request->jenis === 'sukarela' ? $request->jumlah : 0,
        ];

        // Simpan data simpanan
        $simpanan = Simpanan::create($simpananData);

        return response()->json([
            'status' => 'success',
            'message' => 'Simpanan berhasil disimpan',
            'data' => $simpanan,
        ]);
    }

    public function konfirmasi($id)
    {
        $simpanan = Simpanan::findOrFail($id);
        $simpanan->status = 'terkonfirmasi'; // atau 'diterima'
        $simpanan->save();

        return redirect()->back()->with('success', 'Simpanan berhasil dikonfirmasi.');
    }

}
