@extends('admin.layouts.base')
@section('title', 'Pembayaran')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Daftar Pinjaman Belum Lunas</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-dark table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Anggota</th>
            <th>Nominal</th>
            <th>Sisa Tagihan</th>
            <th>Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pinjaman as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $p->anggota->nama ?? '-' }}</td>
            <td>Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($p->sisa_tagihan, 0, ',', '.') }}</td>
            <td>
                <form action="{{ route('pembayaran.simpan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pinjaman_id" value="{{ $p->id }}">
                    <input type="date" name="tanggal" class="form-control mb-1" required>
                    <input type="number" name="jumlah" class="form-control mb-1" placeholder="Jumlah bayar" required>
                    <select name="metode" class="form-select mb-1">
                        <option value="tunai">Tunai</option>
                        <option value="transfer">Transfer</option>
                    </select>
                    <button class="btn btn-success btn-sm">Bayar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">Semua pinjaman sudah lunas.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
