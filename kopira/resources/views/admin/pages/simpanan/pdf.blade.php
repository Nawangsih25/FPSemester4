<!DOCTYPE html>
<html>
<head>
    <title>Laporan Simpanan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
    </style>
</head>
<body>
    <h2 style="text-align:center">Laporan Simpanan {{ ucfirst($filter) ?: 'Semua Jenis' }}</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Jenis</th>
                <th>Tanggal</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($simpanan as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->anggota->nama ?? '-' }}</td>
                    <td>{{ ucfirst($s->jenis) }}</td>
                    <td>{{ \Carbon\Carbon::parse($s->tanggal)->format('d-m-Y') }}</td>
                    <td>
                        Rp {{ number_format($s->jenis == 'wajib' ? $s->total_simpanan_wajib : $s->total_simpanan_sukarela, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
