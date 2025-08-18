@extends('admin.layouts.app')

@section('title', 'Laporan Bulanan Booking')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-chart-line me-2"></i>Laporan Bulanan Booking
                    </h1>
                    <p class="text-muted mb-0">{{ $monthOptions[$month] }} {{ $year }}</p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-list me-1"></i>Daftar Booking
                    </a>
                    <a href="{{ route('admin.bookings.report') }}" class="btn btn-outline-primary">
                        <i class="fas fa-chart-bar me-1"></i>Laporan Umum
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.bookings.monthly-report') }}" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Bulan</label>
                            <select name="month" class="form-select">
                                @foreach($monthOptions as $value => $label)
                                    <option value="{{ $value }}" {{ $month == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tahun</label>
                            <select name="year" class="form-select">
                                @foreach($yearOptions as $yearOption)
                                    <option value="{{ $yearOption }}" {{ $year == $yearOption ? 'selected' : '' }}>
                                        {{ $yearOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                            <button type="button" class="btn btn-success ms-2" onclick="exportToExcel()">
                                <i class="fas fa-file-excel me-1"></i>Export Excel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Booking
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($monthlyStats['total_bookings']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pendapatan Terealisasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($monthlyStats['total_revenue'], 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Booking Selesai
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($monthlyStats['completed_bookings']) }}
                            </div>
                            <div class="text-xs text-muted">
                                dari {{ number_format($monthlyStats['total_bookings']) }} total
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Rata-rata Nilai Booking
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($monthlyStats['avg_booking_value'], 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-area fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Daily Revenue Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tren Harian Booking & Pendapatan</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="dailyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Distribution -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Status</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Selesai
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Aktif
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Dibatalkan
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment Performance -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tools me-2"></i>Performa Alat/Unit
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Alat/Unit</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Jumlah Booking</th>
                                    <th class="text-center">Total Hari Sewa</th>
                                    <th class="text-end">Pendapatan</th>
                                    <th class="text-end">Tingkat Okupansi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($equipmentStats as $stat)
                                    @php
                                        $daysInMonth = $endDate->diffInDays($startDate) + 1;
                                        $occupancyRate = ($stat['total_days'] / $daysInMonth) * 100;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($stat['equipment']->image)
                                                    <img src="{{ Storage::url($stat['equipment']->image) }}" 
                                                         alt="{{ $stat['equipment']->name }}" 
                                                         class="rounded me-3" 
                                                         width="40" height="40"
                                                         style="object-fit: cover;">
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $stat['equipment']->name }}</div>
                                                    <small class="text-muted">{{ $stat['equipment']->model }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $stat['equipment']->category->name }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $stat['bookings_count'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            {{ $stat['total_days'] }} hari
                                        </td>
                                        <td class="text-end fw-semibold">
                                            Rp {{ number_format($stat['total_revenue'], 0, ',', '.') }}
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex align-items-center justify-content-end">
                                                <div class="progress me-2" style="width: 60px; height: 8px;">
                                                    <div class="progress-bar bg-{{ $occupancyRate >= 70 ? 'success' : ($occupancyRate >= 40 ? 'warning' : 'danger') }}" 
                                                         style="width: {{ min($occupancyRate, 100) }}%"></div>
                                                </div>
                                                <small class="text-muted">{{ number_format($occupancyRate, 1) }}%</small>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                            Tidak ada data booking untuk bulan ini
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Bookings -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-2"></i>Detail Booking Bulan Ini
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Booking</th>
                                    <th>Pelanggan</th>
                                    <th>Alat/Unit</th>
                                    <th>Tanggal Sewa</th>
                                    <th>Durasi</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.bookings.show', $booking) }}" 
                                               class="text-decoration-none fw-semibold">
                                                {{ $booking->booking_code }}
                                            </a>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-semibold">{{ $booking->user->name }}</div>
                                                <small class="text-muted">{{ $booking->user->email }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-semibold">{{ $booking->equipment->name }}</div>
                                                <small class="text-muted">{{ $booking->equipment->category->name }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                                <small class="text-muted d-block">
                                                    s/d {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>{{ $booking->duration_days }} hari</td>
                                        <td class="text-center">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'warning',
                                                    'confirmed' => 'info', 
                                                    'active' => 'primary',
                                                    'completed' => 'success',
                                                    'cancelled' => 'danger'
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'Menunggu',
                                                    'confirmed' => 'Dikonfirmasi', 
                                                    'active' => 'Aktif',
                                                    'completed' => 'Selesai',
                                                    'cancelled' => 'Dibatalkan'
                                                ];
                                            @endphp
                                            <span class="badge bg-{{ $statusColors[$booking->status] }}">
                                                {{ $statusLabels[$booking->status] }}
                                            </span>
                                        </td>
                                        <td class="text-end fw-semibold">
                                            Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                            Tidak ada booking untuk bulan ini
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Daily Chart
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    const dailyData = @json($monthlyStats['daily_breakdown']);
    
    new Chart(dailyCtx, {
        type: 'line',
        data: {
            labels: dailyData.map(d => new Date(d.date).getDate()),
            datasets: [{
                label: 'Jumlah Booking',
                data: dailyData.map(d => d.bookings_count),
                borderColor: 'rgb(78, 115, 223)',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                yAxisID: 'y'
            }, {
                label: 'Pendapatan (ribu)',
                data: dailyData.map(d => d.revenue / 1000),
                borderColor: 'rgb(28, 200, 138)',
                backgroundColor: 'rgba(28, 200, 138, 0.1)',
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: { display: true, text: 'Jumlah Booking' }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: { display: true, text: 'Pendapatan (ribu)' },
                    grid: { drawOnChartArea: false }
                }
            }
        }
    });

    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Selesai', 'Aktif', 'Dibatalkan'],
            datasets: [{
                data: [
                    {{ $monthlyStats['completed_bookings'] }},
                    {{ $monthlyStats['active_bookings'] }},
                    {{ $monthlyStats['cancelled_bookings'] }}
                ],
                backgroundColor: ['#1cc88a', '#36b9cc', '#f6c23e'],
                hoverBackgroundColor: ['#17a673', '#2c9faf', '#dda20a'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
});

function exportToExcel() {
    // Simple CSV export
    let csv = 'Kode Booking,Pelanggan,Email,Alat/Unit,Tanggal Mulai,Tanggal Selesai,Durasi,Status,Total\n';
    
    @foreach($bookings as $booking)
        csv += '"{{ $booking->booking_code }}","{{ $booking->user->name }}","{{ $booking->user->email }}","{{ $booking->equipment->name }}","{{ $booking->start_date }}","{{ $booking->end_date }}","{{ $booking->duration_days }} hari","{{ $booking->status }}","{{ $booking->total_amount }}"\n';
    @endforeach
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.setAttribute('hidden', '');
    a.setAttribute('href', url);
    a.setAttribute('download', 'laporan-booking-{{ $monthOptions[$month] }}-{{ $year }}.csv');
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}
</script>
@endpush
