@extends('admin.layouts.base')
@section('title', 'Tambah Kolektor')

@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif
<h1 class="h3 mb-4 text-gray-800">Tambah Data Kolektor</h1>

<form action="{{ route('kolektor.simpan') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        {{-- Kolom Kiri --}}
        <div class="col-md-8">

            {{-- Nama --}}
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Kolektor</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama kolektor">
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email Kolektor</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com">
            </div>

            {{-- Nomor Telepon --}}
            <div class="mb-3">
                <label for="telepon" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" placeholder="08xxxxxxxxxx">
            </div>

            {{-- Alamat --}}
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
            </div>

            {{-- NIK --}}
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK (16 digit)">
            </div>

            {{-- Tanggal Daftar --}}
            <div class="mb-3">
                <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
                <input type="date" class="form-control" id="tanggal_daftar" name="tanggal_daftar"
                       value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
            </div>

            {{-- Jenis Kelamin --}}
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            {{-- Tanggal Lahir --}}
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
            </div>

            {{-- Pendidikan Terakhir --}}
            <div class="mb-3">
                <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                <select class="form-select" id="pendidikan" name="pendidikan">
                    <option value="">-- Pilih Pendidikan --</option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA/SMK">SMA/SMK</option>
                    <option value="Diploma">Diploma</option>
                    <option value="Sarjana">Sarjana</option>
                    <option value="Magister">Magister</option>
                    <option value="Doktor">Doktor</option>
                </select>
            </div>

        </div>

        {{-- Kolom Kanan: Upload Foto --}}
        <div class="col-md-4">
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*" onchange="previewFoto(event)">
                <small class="text-muted">Maksimal: 2048KB</small>
            </div>

            <div class="mb-3 text-center">
                <img id="preview-gambar" src="{{ asset('images/default.png') }}" class="img-fluid" alt="Preview Foto" style="max-height: 250px;">
            </div>
        </div>
    </div>

    {{-- Tombol --}}
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="#" class="btn btn-secondary">Batal</a>
</form>

{{-- Script Preview Foto --}}
<script>
    function previewFoto(event) {
        const reader = new FileReader();
        reader.onload = function () {
            document.getElementById('preview-gambar').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
