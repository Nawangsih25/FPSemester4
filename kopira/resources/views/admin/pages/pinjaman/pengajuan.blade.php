@extends('layouts.app')
@section('title', 'Ajukan Pinjaman')

@section('content')
<h3>Ajukan Pinjaman</h3>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<form method="POST" action="{{ route('pinjaman.ajukan') }}">
    @csrf
    <div class="mb-3">
        <label>Nominal Pinjaman</label>
        <input type="number" name="nominal" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Ajukan</button>
</form>
@endsection
