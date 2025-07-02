@extends('admin.layouts.base')
@section('title', 'Kelola Naungan Kolektor')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Kelola Naungan untuk Kolektor: <strong>{{ $kolektor->nama }}</strong></h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- Form Tambah Anggota --}}
<div class="card mb-4">
    <div class="card-header">Tambah Anggota untuk Kolektor Ini</div>
    <div class="card-body">
        <form action="{{ route('relasi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kolektor_id" value="{{ $kolektor->id }}">
            <div class="row">
                <div class="col-md-8">
                    <select name="anggota_id" class="form-select" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($semuaAnggota as $anggota)
                            <option value="{{ $anggota->id }}">{{ $anggota->nama }} ({{ $anggota->nik }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary w-100">Tambahkan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Daftar Anggota yang Dinaungi --}}
<div class="card">
    <div class="card-header">Anggota yang Dinaungi</div>
    <div class="card-body">
        @if($anggotaNaungan->isEmpty())
            <p>Belum ada anggota yang dinaungi.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-dark align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Status Pinjaman</th>
                            <th>Tagihan Hari Ini</th>
                            <th>Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggotaNaungan as $i => $a)
                        @php
                            $pinjamanAktif = $a->pinjaman()
                                ->whereNotIn('status', ['lunas', 'ditolak'])
                                ->latest('tanggal_pinjam')
                                ->first();
                        @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                @if($a->foto)
                                    <img src="{{ asset('storage/' . $a->foto) }}" alt="Foto" width="50" height="50" class="rounded-circle">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $a->nama }}</td>
                            <td>{{ $a->telepon }}</td>
                            <td>{{ $a->alamat }}</td>
                            <td>{{ $pinjamanAktif->status ?? '-' }}</td>
                            <td>Rp {{ number_format($pinjamanAktif->tagihan_hari_ini ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @if($pinjamanAktif)
                                <form action="{{ route('pembayaran.simpan') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="pinjaman_id" value="{{ $pinjamanAktif->id }}">
                                    <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
                                    <input type="hidden" name="jumlah" value="{{ $pinjamanAktif->tagihan_hari_ini }}">
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Bayar tagihan hari ini untuk {{ $a->nama }}?')">Bayar</button>
                                </form>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('relasi.destroy', $a->pivot->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus relasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
