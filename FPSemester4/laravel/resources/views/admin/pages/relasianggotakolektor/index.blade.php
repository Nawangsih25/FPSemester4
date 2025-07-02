@extends('admin.layouts.base')
@section('title', 'Relasi Kolektor & Anggota')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Relasi Kolektor & Anggota</h1>

{{-- Pesan --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- Form Tambah Relasi --}}
<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        Tambah Relasi Kolektor ke Anggota
    </div>
    <div class="card-body">
        <form action="{{ route('relasi.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="kolektor_id" class="form-label">Pilih Kolektor</label>
                    <select name="kolektor_id" id="kolektor_id" class="form-select" required>
                        <option value="">-- Pilih Kolektor --</option>
                        @foreach($kolektor as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="anggota_id" class="form-label">Pilih Anggota</label>
                    <select name="anggota_id" id="anggota_id" class="form-select" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($anggota as $a)
                            <option value="{{ $a->id }}">{{ $a->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Tambahkan Relasi</button>
        </form>
    </div>
</div>

{{-- Tabel Relasi --}}
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        Daftar Relasi Kolektor - Anggota
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Kolektor</th>
                    <th>Nama Anggota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($relasi as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->kolektor->nama ?? '-' }}</td>
                    <td>{{ $r->anggota->nama ?? '-' }}</td>
                    <td>
                        <form action="{{ route('relasi.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Yakin hapus relasi ini?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada relasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
