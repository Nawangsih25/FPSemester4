@extends('admin.layouts.base')
@section('title', 'Verifikasi Simpanan')

@section('content')
<h4>Daftar Pembayaran Simpanan</h4>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Anggota</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Metode</th>
            <th>Bukti</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
        <tr>
            <td>{{ $item->anggota->nama }}</td>
            <td>{{ ucfirst($item->jenis) }}</td>
            <td>Rp{{ number_format($item->jumlah) }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>{{ $item->metode }}</td>
            <td>
                <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank">Lihat</a>
            </td>
            <td>
                <span class="badge bg-{{ $item->status == 'diterima' ? 'success' : ($item->status == 'ditolak' ? 'danger' : 'warning') }}">
                    {{ ucfirst($item->status) }}
                </span>
            </td>
            <td>
                @if ($item->status == 'pending')
                    <form action="{{ route('admin.pembayaran_simpanan.konfirmasi', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm">Konfirmasi</button>
                    </form>
                    <form action="{{ route('admin.pembayaran_simpanan.tolak', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger btn-sm">Tolak</button>
                    </form>
                @else
                    <button class="btn btn-secondary btn-sm" disabled>{{ ucfirst($item->status) }}</button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
