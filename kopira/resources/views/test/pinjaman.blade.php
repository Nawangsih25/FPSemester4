<!DOCTYPE html>
<html>
<head>
    <title>Test Tambah Pinjaman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h3>Form Tambah Pinjaman Manual (Test)</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="/test/pinjaman" method="POST">
        @csrf

        <div class="mb-3">
            <label for="anggota_id" class="form-label">Anggota ID</label>
            <input type="number" class="form-control" name="anggota_id" required>
        </div>

        <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <input type="number" class="form-control" name="nominal" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" class="form-control" name="tanggal_pinjam" value="{{ date('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</body>
</html>
