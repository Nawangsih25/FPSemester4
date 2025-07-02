@extends('admin.layouts.base')
@section('title', 'Data Pinjaman')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Data Pinjaman</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif


<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('pinjaman.permintaan') }}" class="btn btn-outline-success">Permintaan Pinjaman</a>

    <div class="d-flex">
        <div class="dropdown me-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Filter Status
            </button>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="{{ route('pinjaman.index') }}">Semua Status</a></li>
                <li><a class="dropdown-item" href="{{ route('pinjaman.index', ['filter' => 'lunas']) }}">Lunas</a></li>
                <li><a class="dropdown-item" href="{{ route('pinjaman.index', ['filter' => 'belum bayar']) }}">Belum Bayar</a></li>
                <li><a class="dropdown-item" href="{{ route('pinjaman.index', ['filter' => 'sudah bayar']) }}">Sudah Bayar</a></li>
                <li><a class="dropdown-item" href="{{ route('pinjaman.index', ['filter' => 'pending']) }}">Pending</a></li>
                <li><a class="dropdown-item" href="{{ route('pinjaman.index', ['filter' => 'ditolak']) }}">Ditolak</a></li>
            </ul>
        </div>

        <a href="{{ route('pinjaman.cetak.pdf', ['filter' => request('filter')]) }}" class="btn btn-outline-primary">Cetak PDF</a>
    </div>
</div>


<table class="table table-bordered table-hover bg-white border-success table-striped">
    <thead>
        <tr class="fw-bold text-center bg-success text-light">
            <th>No</th>
            <th>Anggota</th>
            <th>Pinjaman</th>
            <th>Lama</th>
            <th>Sisa Tagihan</th>
            <th>Denda</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Konfirmasi</th>
            <th>Tagihan Hari Ini</th>
            <th>Keterangan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pinjaman as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $p->anggota->nama ?? '-' }}</td>
            <td>Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
            <td>{{ $p->lama_angsuran ?? '-' }} bln</td>
            <td>Rp {{ number_format($p->sisa_tagihan ?? 0, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($p->denda ?? 0, 0, ',', '.') }}</td>
            <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
            <td>{{ $p->tanggal_respon ? \Carbon\Carbon::parse($p->tanggal_respon)->format('d M Y') : '-' }}</td>
            <td>Rp {{ number_format($p->tagihan_hari_ini ?? 0, 0, ',', '.') }}</td>
            <td>
                @if($p->status === 'ditolak')
                    {{ $p->alasan_penolakan ?? '-' }}
                @else
                    -
                @endif
            </td>

            <td class="text-center">
                <span class="badge 
                    @if($p->status == 'lunas') bg-success
                    @elseif($p->status == 'belum bayar') bg-danger
                    @elseif($p->status == 'sudah bayar') bg-warning
                    @elseif($p->status == 'pending') bg-info
                    @elseif($p->status == 'ditolak') bg-secondary
                    @else bg-dark
                    @endif">
                    {{ strtoupper($p->status) }}
                </span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="11" class="text-center">Tidak ada data pinjaman.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
