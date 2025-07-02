@extends('admin.layouts.base')
@section('title', 'Review Permintaan Pinjaman')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Review Permintaan Pinjaman</h1>

<form action="{{ route('pinjaman.review', $pinjaman->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">ID Anggota</label>
        <input type="text" class="form-control" value="{{ $pinjaman->anggota_id }}" readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Nominal</label>
        <input type="text" class="form-control" value="Rp {{ number_format($pinjaman->nominal, 0, ',', '.') }}" readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal Pinjam</label>
        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($pinjaman->tanggal_pinjam)->format('d M Y') }}" readonly>
    </div>

    {{-- Pilihan tindakan --}}
    <div class="mb-3">
        <label class="form-label">Tindakan</label>
        <select name="tindakan" id="tindakan" class="form-select" required onchange="toggleForm()">
            <option value="">-- Pilih --</option>
            <option value="setujui">Setujui</option>
            <option value="tolak">Tolak</option>
        </select>
    </div>

    {{-- Jika disetujui --}}
    <div id="form-setujui" style="display: none">
        <div class="mb-3">
            <label class="form-label">Lama Angsuran (bulan)</label>
            <input type="number" name="lama_angsuran" class="form-control">
        </div>
    </div>

    {{-- Jika ditolak --}}
    <div id="form-tolak" style="display: none">
        <div class="mb-3">
            <label class="form-label">Alasan Penolakan</label>
            <textarea name="alasan_penolakan" class="form-control"></textarea>
        </div>
    </div>

    <button class="btn btn-primary">Kirim</button>
    <a href="{{ route('pinjaman.permintaan') }}" class="btn btn-secondary">Batal</a>
</form>

<script>
    function toggleForm() {
        const tindakan = document.getElementById('tindakan').value;
        document.getElementById('form-setujui').style.display = tindakan === 'setujui' ? 'block' : 'none';
        document.getElementById('form-tolak').style.display = tindakan === 'tolak' ? 'block' : 'none';
    }
</script>
@endsection
