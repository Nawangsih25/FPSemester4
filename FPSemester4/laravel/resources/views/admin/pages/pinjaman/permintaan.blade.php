@extends('admin.layouts.base')
@section('title', 'Permintaan Pinjaman')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Permintaan Pinjaman</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered table-dark">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Nominal</th>
                <th>Tanggal Pinjam</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->anggota->nama ?? '-' }}</td>
                <td>Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('pinjaman.review.form', $p->id) }}" class="btn btn-primary btn-sm">
                        Review
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada permintaan pinjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
