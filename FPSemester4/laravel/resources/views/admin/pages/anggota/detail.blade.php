@extends('admin.layouts.base')
@section('title', 'Detail Anggota')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Detail Data Anggota</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Nomor Rekening</th>
                <td>{{ $anggota->no_rekening }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $anggota->nama }}</td>
            </tr>
            <tr>
                <th>NIK</th>
                <td>{{ $anggota->nik }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $anggota->jenis_kelamin }}</td>
            </tr>
            <tr>
                <th>Telepon</th>
                <td>{{ $anggota->telepon }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $anggota->alamat }}</td>
            </tr>
            <tr>
                <th>Pekerjaan</th>
                <td>{{ $anggota->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Pendidikan</th>
                <td>{{ $anggota->pendidikan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Daftar</th>
                <td>{{ \Carbon\Carbon::parse($anggota->tanggal_daftar)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Deposito Awal</th>
                <td>Rp {{ number_format($anggota->deposito_awal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($anggota->status) }}</td>
            </tr>
            <tr>
                <th>Foto</th>
                <td>
                    @if($anggota->foto)
                        <img src="{{ asset('storage/' . $anggota->foto) }}" alt="Foto Anggota" class="img-thumbnail" width="150">
                    @else
                        <span class="text-muted">Tidak ada foto</span>
                    @endif
                </td>
            </tr>
        </table>
        <a href="{{ route('anggota.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection
