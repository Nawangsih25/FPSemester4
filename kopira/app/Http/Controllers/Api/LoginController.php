<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Kolektor;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
        ]);

        // Cek di Anggota
        $anggota = \App\Models\Anggota::where('nik', $request->nik)
                ->where('nama', $request->nama)->first();

        if ($anggota) {
            $token = $anggota->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token' => $token,
                'role' => 'anggota',
                'user_id' => $anggota->id,
                'user_nama' => $anggota->nama,
                'user_role' => 'anggota'
            ]);
        }


        // Cek di Kolektor
        $kolektor = \App\Models\Kolektor::where('nik', $request->nik)
                ->where('nama', $request->nama)->first();

        if ($kolektor) {
            $token = $kolektor->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token' => $token,
                'role' => 'kolektor',
                'user_id' => $kolektor->id,
                'user_nama' => $kolektor->nama,
                'user_role' => 'kolektor'
            ]);
        }
        // Jika tidak ditemukan
        return response()->json([
            'status' => 'error',
            'message' => 'NIK atau Nama salah',
        ], 401);
    }
}

