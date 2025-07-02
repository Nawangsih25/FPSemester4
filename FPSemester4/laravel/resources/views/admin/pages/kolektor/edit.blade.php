@extends('admin.layouts.base')
@section('title', 'Edit Kolektor')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Data Kolektor</h1>

<form action="{{ route('kolektor.update', $kolektor->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        {{-- Kolom Kiri --}}
        <div class="col-md-8">
            {{-- Nama --}}
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control"
                       value="{{ old('nama', $kolektor->nama) }}">
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                       value="{{ old('email', $kolektor->email) }}">
            </div>

            {{-- Telepon --}}
            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" name="telepon" id="telepon" class="form-control"
                       value="{{ old('telepon', $kolektor->telepon) }}">
            </div>

            {{-- Alamat --}}
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat', $kolektor->alamat) }}</textarea>
            </div>

            {{-- NIK --}}
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" name="nik" id="nik" class="form-control"
                       value="{{ $kolektor->nik }}" readonly>
            </div>

            {{-- Tanggal Lahir --}}
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                       value="{{ old('tanggal_lahir', $kolektor->tanggal_lahir) }}">
            </div>

            {{-- Jenis Kelamin --}}
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                    <option value="Laki-laki" {{ old('jenis_kelamin', $kolektor->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $kolektor->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            {{-- Pendidikan --}}
            <div class="mb-3">
                <label for="pendidikan" class="form-label">Pendidikan</label>
                <select name="pendidikan" id="pendidikan" class="form-select">
                    @foreach(['SD','SMP','SMA/SMK','Diploma','Sarjana','Magister','Doktor'] as $level)
                        <option value="{{ $level }}" {{ old('pendidikan', $kolektor->pendidikan) == $level ? 'selected' : '' }}>
                            {{ $level }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal Daftar --}}
            <div class="mb-3">
                <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
                <input type="date" name="tanggal_daftar" id="tanggal_daftar" class="form-control"
                       value="{{ old('tanggal_daftar', $kolektor->tanggal_daftar) }}">
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div class="col-md-4">
            {{-- Foto --}}
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control" accept="image/*">

                @if($kolektor->foto)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $kolektor->foto) }}" class="img-thumbnail" width="150">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <button class="btn btn-primary">Simpan Perubahan</button>
    <a href="{{ route('kolektor.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
