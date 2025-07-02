<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    public function indexPage()
    {
        $anggota = \App\Models\Anggota::latest()->get();
        return view('admin.pages.Anggota.index', compact('anggota'));
    }

    public function tambahData()
    {
        return view('admin.pages.anggota.tambahanggota');
    }

    public function simpanData(Request $request)
    {
        $request->validate([
            'no_rekening'     => 'required|unique:anggota,no_rekening',
            'nama'            => 'required|string|max:255',
            'nik'             => 'required|digits:16|unique:anggota,nik',
            'tanggal_lahir'   => 'required|date',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'telepon'         => 'required|string|max:20',
            'alamat'          => 'required|string',
            'pekerjaan'       => 'nullable|string|max:100',
            'pendidikan'      => 'nullable|string',
            'bergabung'       => 'required|date',
            'status'          => 'required|in:aktif,tidak aktif',
            'deposito_awal'   => 'required|numeric|min:0',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) 
        {
            $fotoPath = $request->file('foto')->store('anggota/foto', 'public');
        }
        try {

            Anggota::create([
                'no_rekening'     => $request->no_rekening,
                'nama'            => $request->nama,
                'nik'             => $request->nik,
                'tanggal_lahir'   => $request->tanggal_lahir,
                'jenis_kelamin'   => $request->jenis_kelamin,
                'telepon'         => $request->telepon,
                'alamat'          => $request->alamat,
                'pekerjaan'       => $request->pekerjaan,
                'pendidikan'      => $request->pendidikan,
                'tanggal_daftar'  => $request->bergabung,
                'status'          => $request->status,
                'deposito_awal'   => $request->deposito_awal,
                'foto'            => $fotoPath,
            ]);
            return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil disimpan.');
        } catch (\Exception $e) {
            dd('Gagal insert: ', $e->getMessage());
        }
    }

    public function detail($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('admin.pages.anggota.detail', compact('anggota'));
    }

    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('admin.pages.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'no_rekening'   => 'required|unique:anggota,no_rekening,' . $anggota->id,
            'nama'          => 'required|string|max:255',
            'nik'           => 'required|digits:16|unique:anggota,nik,' . $anggota->id,
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'telepon'       => 'required|string|max:20',
            'alamat'        => 'required|string',
            'pekerjaan'     => 'nullable|string|max:100',
            'pendidikan'    => 'nullable|string',
            'tanggal_daftar'=> 'required|date',
            'status'        => 'required|in:aktif,tidak aktif',
            'deposito_awal' => 'required|numeric|min:0',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($anggota->foto) {
                Storage::disk('public')->delete($anggota->foto);
            }
            $anggota->foto = $request->file('foto')->store('anggota/foto', 'public');
        }

        $anggota->update([
            'no_rekening'     => $request->no_rekening,
            'nama'            => $request->nama,
            'nik'             => $request->nik,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'telepon'         => $request->telepon,
            'alamat'          => $request->alamat,
            'pekerjaan'       => $request->pekerjaan,
            'pendidikan'      => $request->pendidikan,
            'tanggal_daftar'  => $request->tanggal_daftar,
            'status'          => $request->status,
            'deposito_awal'   => $request->deposito_awal,
            'foto'            => $anggota->foto,
        ]);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);

        // Hapus file foto jika ada
        if ($anggota->foto && Storage::disk('public')->exists($anggota->foto)) {
            Storage::disk('public')->delete($anggota->foto);
        }

        // Hapus data dari database
        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil dihapus.');
    }




}
