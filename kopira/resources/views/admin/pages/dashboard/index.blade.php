@extends('admin.layouts.base')
@section('title', 'Dashboard')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

<div class="row">
    <!-- Ringkasan Data -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Kolektor</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKolektor }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people-fill fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Anggota</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAnggota }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-fill fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pinjaman</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp{{ number_format($totalPinjaman, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-credit-card-fill fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Simpanan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp{{ number_format($totalSimpanan, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-cash-stack fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Pie Chart Status Pinjaman -->
    <div class="col-xl-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Status Pinjaman</h6>
            </div>
            <div class="card-body" style="height: 300px;">
                <canvas id="statusPinjamanChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bar Chart Simpanan -->
    <div class="col-xl-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Jenis Simpanan</h6>
            </div>
            <div class="card-body" style="height: 300px;">
                <canvas id="jenisSimpananChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const statusCtx = document.getElementById('statusPinjamanChart');
new Chart(statusCtx, {
    type: 'pie',
    data: {
        labels: ['Belum Bayar', 'Sudah Bayar', 'Lunas', 'Pending', 'Ditolak'],
        datasets: [{
            label: 'Status Pinjaman',
            data: {!! json_encode($statusPinjaman->values()->all()) !!},
            backgroundColor: ['#dc3545', '#ffc107', '#28a745', '#17a2b8', '#6c757d']
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true
    }
});


const simpananCtx = document.getElementById('jenisSimpananChart');
new Chart(simpananCtx, {
    type: 'bar',
    data: {
        labels: ['Wajib', 'Sukarela'],
        datasets: [{
            label: 'Jumlah Simpanan',
            data: {!! json_encode($jenisSimpanan->values()->all()) !!},
            backgroundColor: ['#007bff', '#fd7e14']
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true
    }
});

</script>
@endsection
