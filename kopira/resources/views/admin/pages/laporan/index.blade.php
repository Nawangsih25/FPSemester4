@extends('admin.layouts.base')
@section('title', 'Laporan Keuangan Transaksi')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Laporan Keuangan Transaksi</h1>

<div class="card shadow mb-4">
    <div class="card-body">

        {{-- Ringkasan Statistik --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="alert alert-primary">
                    <strong>Total Simpanan:</strong><br> Rp {{ number_format($totalSimpanan, 0, ',', '.') }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-success">
                    <strong>Total Pinjaman:</strong><br> Rp {{ number_format($totalPinjaman, 0, ',', '.') }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-info">
                    <strong>Total Pembayaran:</strong><br> Rp {{ number_format($totalPembayaran, 0, ',', '.') }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="alert alert-warning">
                    <strong>Total Denda:</strong><br> Rp {{ number_format($totalDenda, 0, ',', '.') }}
                </div>
            </div>
        </div>

        {{-- Saldo Kas --}}
        <div class="mb-4">
            <div class="alert alert-dark">
                <strong>Saldo Kas Koperasi:</strong> Rp {{ number_format($saldoKas, 0, ',', '.') }}
            </div>
        </div>

        {{-- Filter Tanggal --}}
        <form class="row g-3 align-items-end mb-3" method="GET" action="{{ route('laporan.index') }}">
            <div class="col-md-4">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" value="{{ $tanggalMulai }}">
            </div>
            <div class="col-md-4">
                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control" value="{{ $tanggalAkhir }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Tampilkan Laporan</button>
            </div>
        </form>

        {{-- Tabel Transaksi --}}
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis Transaksi</th>
                        <th>Nama Anggota</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $t)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($t['tanggal'])->format('d M Y') }}</td>
                        <td>{{ $t['jenis'] }}</td>
                        <td>{{ $t['nama'] }}</td>
                        <td>{{ $t['keterangan'] }}</td>
                        <td>Rp {{ number_format($t['jumlah'], 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada transaksi pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tombol Export --}}
        <div class="mt-3 d-flex justify-content-end gap-2">
            <a href="{{ route('laporan.export.pdf', ['tanggal_mulai' => $tanggalMulai, 'tanggal_akhir' => $tanggalAkhir]) }}" class="btn btn-danger">Export PDF</a>
            <a href="{{ route('laporan.export.excel', ['tanggal_mulai' => $tanggalMulai, 'tanggal_akhir' => $tanggalAkhir]) }}" class="btn btn-success">Export Excel</a>
        </div>


    </div>
</div>
@endsection
