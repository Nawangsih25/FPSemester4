<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;
use App\Models\Kolektor;

class LoginController extends Controller
{
    public function indexPage()
    {
        return view('admin.pages.login.index');
    }

    public function angKolektorLoginPage()
    {
        return view('admin.pages.login.anggotakolektor');
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function processAngKolektorLogin(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
        ]);

        $user = Anggota::where('nik', $request->nik)->where('nama', $request->nama)->first();

        if (!$user) {
            $user = Kolektor::where('nik', $request->nik)->where('nama', $request->nama)->first();
        }

        if ($user) {
            session(['user_role' => $user instanceof Anggota ? 'anggota' : 'kolektor']);
            session(['user_id' => $user->id]);
            session(['user_nama' => $user->nama]);

            return redirect('/dashboard')->with('success', 'Login berhasil sebagai ' . session('user_role'));
        }

        return back()->with('error', 'NIK atau nama tidak ditemukan.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
