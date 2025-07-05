@extends('admin.layouts.base')
@section('title', 'Anggota')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Anggota</h1>


<a href="{{ route('anggota.tambah') }}" class="btn btn-success mb-3">+ Tambah Anggota</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-hover bg-white border-success table-striped">
    <thead>
        <tr class="fw-bold text-center bg-success text-light">
            <th>No</th>
            <th>Bergabung</th>
            <th>No. Rekening</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($anggota as $key => $item)
            <tr class="text-center align-middle">
                <td>{{ $key + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d M Y') }}</td>
                <td>{{ $item->no_rekening }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->nik }}</td>
                <td>
                    <span class="badge bg-{{ $item->status == 'aktif' ? 'success' : 'secondary' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('anggota.detail', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('anggota.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('anggota.hapus', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada data anggota</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
