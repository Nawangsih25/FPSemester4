<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Simpanan;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $anggotaId = $request->user()->id;

        $pembayaran = Pembayaran::whereHas('pinjaman', function ($query) use ($anggotaId) {
            $query->where('anggota_id', $anggotaId);
        })->with('pinjaman')->latest()->get();

        return response()->json($pembayaran);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pinjaman_id' => 'required|exists:pinjaman,id',
            'tanggal_pembayaran' => 'required|date',
            'jumlah_pembayaran' => 'required|integer|min:1000',
            'metode' => 'nullable|string',
            'bukti_pembayaran' => 'nullable|image|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $pembayaran = Pembayaran::create([
            'pinjaman_id' => $request->pinjaman_id,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'jumlah_pembayaran' => $request->jumlah_pembayaran,
            'bukti_pembayaran' => $buktiPath,
            'status_verifikasi' => 'pending',
            'metode' => $request->metode,
        ]);

        return response()->json(['message' => 'Pembayaran berhasil dikirim', 'data' => $pembayaran], 201);
    }

    public function simpanan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'anggota_id' => 'required|exists:anggota,id',
            'jenis' => 'required|in:wajib,sukarela',
            'jumlah' => 'required|integer|min:1000',
            'metode' => 'nullable|string',
            'tanggal' => 'required|date',
            'bukti_pembayaran' => 'required|image|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti', 'public');
        }

        $simpanan = Simpanan::create([
            'anggota_id' => $request->anggota_id,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'metode' => $request->metode,
            'tanggal' => $request->tanggal,
            'status' => 'pending',
            'bukti_pembayaran' => $buktiPath,
        ]);

        return response()->json([
            'message' => 'Simpanan berhasil dikirim',
            'data' => $simpanan
        ], 201);
    }

    public function konfirmasiAnggota($id)
    {
        $data = \App\Models\Pembayaran::with('pinjaman.anggota')->findOrFail($id);
        $data->status_verifikasi = 'diterima';
        $data->save();

        $nama = $data->pinjaman->anggota->nama ?? 'Anggota';
        $jumlah = number_format($data->jumlah_pembayaran, 0, ',', '.');

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran anggota telah dikonfirmasi.',
            'notif' => [
                'title' => 'Pembayaran Dikonfirmasi',
                'message' => "Hai $nama, pembayaran kamu sebesar Rp$jumlah telah dikonfirmasi oleh admin.",
                'date' => now()->toDateTimeString()
            ]
        ]);
    }

    public function getNotifikasi($anggota_id)
    {
        $pembayaran = Pembayaran::whereHas('pinjaman', function ($q) use ($anggota_id) {
            $q->where('anggota_id', $anggota_id);
        })->latest()->first();

        if ($pembayaran && $pembayaran->status_verifikasi === 'diterima') {
            return response()->json([
                'success' => true,
                'notif' => [
                    'title' => 'Pembayaran Dikonfirmasi',
                    'message' => 'Pembayaran kamu sebesar Rp' . number_format($pembayaran->jumlah_pembayaran, 0, ',', '.') . ' telah dikonfirmasi oleh admin.',
                    'date' => now()->toDateTimeString()
                ]
            ]);
        }

        return response()->json(['success' => false]);
    }


}

