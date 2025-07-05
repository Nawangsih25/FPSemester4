@extends('admin.layouts.base')
@section('title', 'Detail Kolektor')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Detail Data Kolektor</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Nama</th>
                <td>{{ $kolektor->nama }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $kolektor->email }}</td>
            </tr>
            <tr>
                <th>Telepon</th>
                <td>{{ $kolektor->telepon }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $kolektor->alamat }}</td>
            </tr>
            <tr>
                <th>NIK</th>
                <td>{{ $kolektor->nik }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ \Carbon\Carbon::parse($kolektor->tanggal_lahir)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $kolektor->jenis_kelamin }}</td>
            </tr>
            <tr>
                <th>Pendidikan</th>
                <td>{{ $kolektor->pendidikan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Daftar</th>
                <td>{{ \Carbon\Carbon::parse($kolektor->tanggal_daftar)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Foto</th>
                <td>
                    @if($kolektor->foto)
                        <img src="{{ asset('storage/' . $kolektor->foto) }}" alt="Foto Kolektor" class="img-thumbnail" width="150">
                    @else
                        <span class="text-muted">Tidak ada foto</span>
                    @endif
                </td>
            </tr>
        </table>
        <a href="{{ route('kolektor.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection
