<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kolektor;
use App\Models\Anggota;

class RelasiKolektorAnggotaController extends Controller
{
    public function kelola($id)
    {
        $kolektor = Kolektor::findOrFail($id);
        $anggotaNaungan = $kolektor->anggota ?? []; // gunakan relasi jika tersedia
        $semuaAnggota = Anggota::all();

        return view('admin.pages.relasianggotakolektor.index', compact('kolektor', 'anggotaNaungan', 'semuaAnggota'));
    }
}
