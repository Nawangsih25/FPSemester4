<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kolektor;
use App\Models\Anggota;
use App\Models\RelasiKolektorAnggota;

class RelasiKolektorController extends Controller
{
    public function index()
    {
        $kolektor = Kolektor::all();
        $anggota = Anggota::all();
        $relasi = RelasiKolektorAnggota::with(['kolektor', 'anggota'])->get();

        return view('admin.pages.relasianggotakolektor.index', compact('kolektor', 'anggota', 'relasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kolektor_id' => 'required|exists:kolektor,id',
            'anggota_id' => 'required|exists:anggota,id',
        ]);

        // Cek apakah sudah 5 anggota
        $jumlahRelasi = RelasiKolektorAnggota::where('kolektor_id', $request->kolektor_id)->count();
        if ($jumlahRelasi >= 5) {
            return back()->with('error', 'Kolektor ini sudah memiliki 5 anggota.');
        }

        // Cek apakah relasi sudah ada
        $sudahAda = RelasiKolektorAnggota::where([
            'kolektor_id' => $request->kolektor_id,
            'anggota_id' => $request->anggota_id
        ])->exists();

        if ($sudahAda) {
            return back()->with('error', 'Anggota ini sudah ditugaskan ke kolektor tersebut.');
        }

        // Simpan relasi
        RelasiKolektorAnggota::create([
            'kolektor_id' => $request->kolektor_id,
            'anggota_id' => $request->anggota_id
        ]);

        return redirect()->route('relasi.index')->with('success', 'Relasi berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $relasi = RelasiKolektorAnggota::findOrFail($id);
        $relasi->delete();

        return back()->with('success', 'Relasi berhasil dihapus.');
    }

    public function kelola($id)
    {
        $kolektor = Kolektor::findOrFail($id);
        $anggotaNaungan = $kolektor->anggota; // relasi hasManyThrough atau hasMany
        $semuaAnggota = Anggota::whereDoesntHave('kolektor')->get(); // hanya yang belum dinaungi

        return view('admin.pages.relasianggotakolektor.kelola', compact('kolektor', 'anggotaNaungan', 'semuaAnggota'));
    }

}
