@extends('admin.layouts.base')
@section('title', 'Tambah Anggota')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h1 class="h3 mb-4 text-gray-800">Tambah Data Anggota</h1>

<form action="{{ route('anggota.simpan') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        {{-- Kolom Kiri --}}
        <div class="col-md-8">
            {{-- Nomor Rekening --}}
            <div class="mb-3">
                <label for="no_rekening" class="form-label">Nomor Rekening</label>
                <input type="text" class="form-control" id="no_rekening" name="no_rekening" placeholder="Masukkan nomor rekening">
            </div>

            {{-- Nama --}}
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Anggota</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama anggota">
            </div>

            {{-- NIK --}}
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK">
            </div>

            {{-- Tanggal Daftar --}}
            <div class="mb-3">
                <label for="bergabung" class="form-label">Tanggal Daftar</label>
                <input type="date" class="form-control" id="bergabung" name="bergabung"
                       value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
            </div>

            {{-- Deposito Awal --}}
            <div class="mb-3">
                <label for="deposito_awal" class="form-label">Deposito Awal (Rp)</label>
                <input type="number" class="form-control" id="deposito_awal" name="deposito_awal" placeholder="Contoh: 1000000">
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

            {{-- Pekerjaan --}}
            <div class="mb-3">
                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Masukkan pekerjaan">
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

            {{-- Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" value="aktif" readonly>
                <small class="text-muted">Akun akan otomatis menjadi "Tidak Aktif" jika tidak digunakan selama 3 bulan.</small>
            </div>
        </div>

        {{-- Kolom Kanan: Foto --}}
        <div class="col-md-4">
            {{-- Upload Foto --}}
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*" onchange="previewFoto(event)">
                <small class="text-muted">Maksimal: 2048KB</small>
            </div>

            {{-- Preview Foto --}}
            <div class="mb-3 text-center">
                <img id="preview-gambar" src="{{ asset('images/default.png') }}" class="img-fluid" alt="Preview Foto" style="max-height: 250px;">
            </div>
        </div>
    </div>

    {{-- Tombol --}}
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="#" class="btn btn-secondary">Batal</a>
</form>

{{-- Script Preview --}}
<script>
    function previewFoto(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('preview-gambar');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
