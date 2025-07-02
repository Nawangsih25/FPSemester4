@extends('admin.layouts.base')
@section('title', 'Kolektor')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Data Kolektor</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('kolektor.tambah') }}" class="btn btn-info mb-3">+ Tambah Kolektor</a>

<table class="table table-bordered table-hover bg-white border-success table-striped">
    <thead>
        <tr class="fw-bold text-center bg-success text-light">
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>NIK</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $i => $kolektor)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $kolektor->nama }}</td>
            <td>{{ $kolektor->email }}</td>
            <td>{{ $kolektor->nik }}</td>
            <td class="text-center">
                <span class="badge bg-success">Aktif</span> {{-- atau logika status jika ada --}}
            </td>
            <td class="text-center">
                <a href="{{ route('kolektor.detail', $kolektor->id) }}" class="btn btn-sm btn-primary">Detail</a>
                <a href="{{ route('kolektor.edit', $kolektor->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <a href="{{ route('kolektor.naungi', $kolektor->id) }}" class="btn btn-sm btn-info">Naungi</a>
                <form action="{{ route('kolektor.hapus', $kolektor->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                </form>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Belum ada data kolektor.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection