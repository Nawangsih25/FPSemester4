@extends('admin.layouts.base')
@section('title', 'Uji Coba Simpanan')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Uji Coba Input Simpanan</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('test.simpanan') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Anggota</label>
        <select name="anggota_id" class="form-select" required>
            <option value="">-- Pilih Anggota --</option>
            @foreach($anggota as $a)
                <option value="{{ $a->id }}">{{ $a->nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Jenis Simpanan</label>
        <select name="jenis" class="form-select" required>
            <option value="">-- Pilih Jenis --</option>
            <option value="wajib">Wajib</option>
            <option value="sukarela">Sukarela</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal Simpanan</label>
        <input type="date" name="tanggal" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Nominal Simpanan</label>
        <input type="number" name="nominal" class="form-control" min="1000" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection
