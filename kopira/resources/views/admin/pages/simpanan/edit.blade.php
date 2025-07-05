@extends('admin.layouts.base')
@section('title', 'Edit Simpanan')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Simpanan</h1>

<form action="{{ route('simpanan.update', $simpanan->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nama Anggota</label>
        <input type="text" class="form-control" value="{{ $simpanan->anggota->nama }}" readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Jenis Simpanan</label>
        <select name="jenis" class="form-select" required>
            <option value="wajib" {{ $simpanan->jenis == 'wajib' ? 'selected' : '' }}>Wajib</option>
            <option value="sukarela" {{ $simpanan->jenis == 'sukarela' ? 'selected' : '' }}>Sukarela</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="{{ \Carbon\Carbon::parse($simpanan->tanggal)->format('Y-m-d') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Nominal</label>
        <input type="number" name="nominal" class="form-control"
               value="{{ $simpanan->jenis == 'wajib' ? $simpanan->total_simpanan_wajib : $simpanan->total_simpanan_sukarela }}">
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="{{ route('simpanan.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
