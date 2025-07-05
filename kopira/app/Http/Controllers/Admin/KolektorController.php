<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kolektor;
use App\Models\Anggota;
use Illuminate\Support\Facades\Storage;


class KolektorController extends Controller
{
    public function indexPage(){
        $data = Kolektor::all();
        return view('admin.pages.kolektor.index', compact('data'));
    }


    public function tambahData(){
        return view('admin.pages.kolektor.tambahkolektor');
    }

    public function simpanData(Request $request)
    {
        $request->validate([
            'nama'              => 'required|string|max:255',
            'email'             => 'required|email|unique:kolektor,email',
            'telepon'           => 'required|string|max:20',
            'alamat'            => 'required|string',
            'nik'               => 'required|digits:16|unique:kolektor,nik',
            'tanggal_lahir'     => 'required|date',
            'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
            'pendidikan'        => 'nullable|string|max:100',
            'tanggal_daftar'    => 'required|date',
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('kolektor/foto', 'public');
        }

         Kolektor::create([
            'nama'              => $request->nama,
            'email'             => $request->email,
            'telepon'           => $request->telepon,
            'alamat'            => $request->alamat,
            'nik'               => $request->nik,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'pendidikan'        => $request->pendidikan,
            'tanggal_daftar'    => $request->tanggal_daftar,
            'foto'              => $fotoPath,
        ]);

        return redirect()->route('kolektor.index')->with('success', 'Data kolektor berhasil disimpan.');
    }

    public function detail($id)
    {
        $kolektor = kolektor::findOrFail($id);
        return view('admin.pages.kolektor.detail', compact('kolektor'));
    }

    public function edit($id)
    {
        $kolektor = kolektor::findOrFail($id);
        return view('admin.pages.kolektor.edit', compact('kolektor'));
    }

    public function update(Request $request, $id)
    {
        $kolektor = Kolektor::findOrFail($id);

        $request->validate([
            'nama'           => 'required|string|max:255',
            'email'          => 'required|email|unique:kolektor,email,' . $id,
            'telepon'        => 'required|string|max:20',
            'alamat'         => 'required|string',
            'nik'            => 'required|digits:16|unique:kolektor,nik,' . $id,
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'pendidikan'     => 'nullable|string|max:100',
            'tanggal_daftar' => 'required|date',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($kolektor->foto) {
                Storage::disk('public')->delete($kolektor->foto);
            }
            $kolektor->foto = $request->file('foto')->store('kolektor/foto', 'public');
        }

        $kolektor->update($request->except('foto') + ['foto' => $kolektor->foto]);

        return redirect()->route('kolektor.index')->with('success', 'Data kolektor berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $kolektor = Kolektor::findOrFail($id);

        // Hapus foto jika ada
        if ($kolektor->foto && Storage::disk('public')->exists($kolektor->foto)) {
            Storage::disk('public')->delete($kolektor->foto);
        }

        $kolektor->delete();

        return redirect()->route('kolektor.index')->with('success', 'Data kolektor berhasil dihapus.');
    }

    public function tambahAnggotaKeKolektor(Request $request)
    {
        $request->validate([
            'kolektor_id' => 'required|exists:kolektor,id',
            'anggota_id' => 'required|exists:anggota,id',
        ]);

        $kolektor = Kolektor::with('anggota')->findOrFail($request->kolektor_id);

        if ($kolektor->anggota->count() >= 5) {
            return back()->with('error', 'Kolektor ini sudah memiliki 5 anggota.');
        }

        // Cegah duplikasi relasi
        if ($kolektor->anggota->contains($request->anggota_id)) {
            return back()->with('error', 'Anggota sudah ditugaskan ke kolektor ini.');
        }

        $kolektor->anggota()->attach($request->anggota_id);

        return back()->with('success', 'Anggota berhasil ditambahkan ke kolektor.');
    }


}
