@extends('admin.layouts.base')
@section('title', 'Edit Anggota')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Data Anggota</h1>

<form action="{{ route('anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-8">
            {{-- Nomor Rekening --}}
            <div class="mb-3">
                <label for="no_rekening" class="form-label">Nomor Rekening</label>
                <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="{{ old('no_rekening', $anggota->no_rekening) }}">
            </div>

            {{-- Nama --}}
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $anggota->nama) }}">
            </div>

            {{-- NIK - readonly --}}
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $anggota->nik) }}" readonly>
            </div>

            {{-- Tanggal Lahir --}}
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $anggota->tanggal_lahir) }}">
            </div>

            {{-- Jenis Kelamin --}}
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                    <option value="Laki-laki" {{ $anggota->jenis_kelamin === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $anggota->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            {{-- Telepon --}}
            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon', $anggota->telepon) }}">
            </div>

            {{-- Alamat --}}
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $anggota->alamat) }}</textarea>
            </div>

            {{-- Pekerjaan --}}
            <div class="mb-3">
                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $anggota->pekerjaan) }}">
            </div>

            {{-- Pendidikan --}}
            <div class="mb-3">
                <label for="pendidikan" class="form-label">Pendidikan</label>
                <select name="pendidikan" id="pendidikan" class="form-select">
                    @foreach (['SD','SMP','SMA/SMK','Diploma','Sarjana','Magister','Doktor'] as $edu)
                        <option value="{{ $edu }}" {{ $anggota->pendidikan === $edu ? 'selected' : '' }}>{{ $edu }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal Daftar --}}
            <div class="mb-3">
                <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
                <input type="date" class="form-control" id="tanggal_daftar" name="tanggal_daftar" value="{{ old('tanggal_daftar', $anggota->tanggal_daftar) }}">
            </div>

            {{-- Deposito Awal --}}
            <div class="mb-3">
                <label for="deposito_awal" class="form-label">Deposito Awal (Rp)</label>
                <input type="number" class="form-control" id="deposito_awal" name="deposito_awal" value="{{ old('deposito_awal', $anggota->deposito_awal) }}">
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="aktif" {{ $anggota->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak aktif" {{ $anggota->status === 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
        </div>

        {{-- Kolom Kanan: Foto --}}
        <div class="col-md-4">
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" name="foto" accept="image/*">
                @if($anggota->foto)
                    <img src="{{ asset('storage/' . $anggota->foto) }}" class="img-fluid mt-2" width="150" alt="Foto">
                @endif
            </div>
        </div>
    </div>

    <button class="btn btn-primary">Simpan Perubahan</button>
    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
