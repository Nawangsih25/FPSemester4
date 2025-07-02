@extends('admin.layouts.base')
@section('title', 'Tambah Pinjaman')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Tambah Pinjaman</h1>

<form action="{{ route('pinjaman.simpan') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="anggota_id" class="form-label">Nama Anggota</label>
        <select name="anggota_id" class="form-select">
            <option value="">-- Pilih Anggota --</option>
            @foreach($anggota as $a)
                <option value="{{ $a->id }}">{{ $a->nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="nominal" class="form-label">Nominal Pinjaman</label>
        <input type="number" name="nominal" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="lama_angsuran" class="form-label">Lama Angsuran (bulan)</label>
        <input type="number" name="lama_angsuran" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="aktif">Aktif</option>
            <option value="lunas">Lunas</option>
        </select>
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('pinjaman.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
