<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pinjaman - {{ ucfirst($filter ?? 'Semua') }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2 align="center">Laporan Pinjaman ({{ ucfirst($filter ?? 'Semua Status') }})</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Pinjaman</th>
                <th>Lama</th>
                <th>Sisa Tagihan</th>
                <th>Denda</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pinjaman as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->anggota->nama ?? '-' }}</td>
                <td>Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                <td>{{ $p->lama_angsuran ?? '-' }} bln</td>
                <td>Rp {{ number_format($p->sisa_tagihan ?? 0, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($p->denda ?? 0, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                <td>{{ strtoupper($p->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
