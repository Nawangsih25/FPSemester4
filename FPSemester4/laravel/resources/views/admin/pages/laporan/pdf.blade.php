<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Keuangan Transaksi {{ \Carbon\Carbon::now()->format('d M Y') }}</h2>
    <p>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis Transaksi</th>
                <th>Nama Anggota</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $t)
            <tr>
                <td>{{ \Carbon\Carbon::parse($t['tanggal'])->format('d-m-Y') }}</td>
                <td>{{ $t['jenis'] }}</td>
                <td>{{ $t['nama'] }}</td>
                <td>{{ $t['keterangan'] }}</td>
                <td>Rp {{ number_format($t['jumlah'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
