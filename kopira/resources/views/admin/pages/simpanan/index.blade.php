@extends('admin.layouts.base')
@section('title', 'Simpanan')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Simpanan</h1>

<div class="d-flex justify-content-end mb-3">
    <div class="d-flex">
        {{-- Filter Status --}}
        <div class="dropdown me-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Filter Status
            </button>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="{{ route('simpanan.index') }}">Semua Jenis</a></li>
                <li><a class="dropdown-item" href="{{ route('simpanan.index', ['filter' => 'wajib']) }}">Wajib</a></li>
                <li><a class="dropdown-item" href="{{ route('simpanan.index', ['filter' => 'sukarela']) }}">Sukarela</a></li>
            </ul>
        </div>

        {{-- Tombol Cetak PDF --}}
        <a href="{{ route('simpanan.cetak', ['filter' => request('filter')]) }}" class="btn btn-outline-primary">
            Cetak PDF
        </a>
    </div>
</div>


<table class="table table-bordered table-hover bg-white border-success table-striped">
    <thead>
        <tr class="fw-bold text-center bg-success text-light">
            <th>No</th>
            <th>Tgl Daftar</th>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Anggota</th>
            <th>Nominal</th>
            <th>Total Saldo Wajib</th>
            <th>Total Saldo Sukarela</th>
            <th>Status Wajib</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($simpanan as $i => $s)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($s->anggota->tanggal_daftar)->format('d M Y') ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}</td>
            <td>{{ ucfirst($s->jenis) }}</td>
            <td>{{ $s->anggota->nama ?? '-' }}</td>

            {{-- Nominal --}}
            <td>
                Rp 
                @if($s->jenis === 'wajib')
                    {{ number_format($s->total_simpanan_wajib, 0, ',', '.') }}
                @elseif($s->jenis === 'sukarela')
                    {{ number_format($s->total_simpanan_sukarela, 0, ',', '.') }}
                @else
                    0
                @endif
            </td>

            {{-- Total Saldo Wajib --}}
            <td>
                Rp {{ number_format($s->anggota->simpanan->where('jenis', 'wajib')->sum('total_simpanan_wajib'), 0, ',', '.') }}
            </td>

            {{-- Total Saldo Sukarela --}}
            <td>
                Rp {{ number_format($s->anggota->simpanan->where('jenis', 'sukarela')->sum('total_simpanan_sukarela'), 0, ',', '.') }}
            </td>

            {{-- Status Wajib --}}
            <td>
                @php
                    $status = $statusPembayaran[$s->anggota->id ?? 0] ?? '-';
                    $badgeClass = match($status) {
                        'sudah membayar simpanan wajib' => 'success',
                        'belum membayar simpanan wajib bulan ini' => 'warning',
                        'telat membayar simpanan wajib' => 'danger',
                        'belum wajib membayar simpanan' => 'secondary',
                        default => 'dark',
                    };
                @endphp
                <span class="badge bg-{{ $badgeClass }}">{{ $status }}</span>
            </td>



            {{-- Aksi --}}
            <td>
                <a href="{{ route('simpanan.edit', $s->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('simpanan.hapus', $s->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Yakin ingin menghapus simpanan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center">Belum ada data simpanan</td>
        </tr>
        @endforelse
    </tbody>
</table>
    

@endsection
