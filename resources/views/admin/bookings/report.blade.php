@extends('admin.layouts.app')

@section('title', 'Laporan Booking')
@section('page-title', 'Laporan Booking')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Filter Laporan</h5>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.bookings.report') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(isset($summary))
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Ringkasan Laporan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <h4 class="text-primary">{{ $summary['total_bookings'] }}</h4>
                            <p class="mb-0">Total Booking</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <h4 class="text-success">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</h4>
                            <p class="mb-0">Total Revenue</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <h4 class="text-info">{{ $summary['avg_duration'] }}</h4>
                            <p class="mb-0">Rata-rata Durasi (hari)</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <h4 class="text-warning">{{ $summary['total_equipment_used'] }}</h4>
                            <p class="mb-0">Alat Digunakan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Data Booking</h5>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-info btn-sm">
                    <i class="fas fa-print me-1"></i>Cetak
                </button>
                <button onclick="exportToExcel()" class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel me-1"></i>Export Excel
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if(isset($bookings) && $bookings->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Kode Booking</th>
                        <th>Customer</th>
                        <th>Equipment</th>
                        <th>Tanggal</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $index => $booking)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $booking->booking_code }}</strong>
                        </td>
                        <td>
                            {{ $booking->user->name ?? '-' }}<br>
                            <small class="text-muted">{{ $booking->user->email ?? '' }}</small>
                        </td>
                        <td>
                            {{ $booking->equipment->name ?? '-' }}<br>
                            <small class="text-muted">{{ $booking->equipment->category->name ?? '' }}</small>
                        </td>
                        <td>
                            <strong>{{ $booking->start_date->format('d/m/Y') }}</strong><br>
                            <small class="text-muted">s/d {{ $booking->end_date->format('d/m/Y') }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $booking->duration_days }} hari</span>
                        </td>
                        <td>
                            <strong>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</strong><br>
                            <small class="text-muted">{{ number_format($booking->daily_rate, 0, ',', '.') }}/hari</small>
                        </td>
                        <td>
                            {!! $booking->getStatusBadge() !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="6" class="text-end">Total:</th>
                        <th>Rp {{ number_format($bookings->sum('total_amount'), 0, ',', '.') }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Tidak ada data booking</h5>
            <p class="text-muted">Gunakan filter di atas untuk mencari data booking</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    .btn, .card-header .d-flex > div:last-child {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    body {
        background: white !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
function exportToExcel() {
    // Simple table to CSV export
    let table = document.querySelector('.table');
    let csv = [];
    let rows = table.querySelectorAll('tr');
    
    for (let i = 0; i < rows.length; i++) {
        let row = [], cols = rows[i].querySelectorAll('td, th');
        
        for (let j = 0; j < cols.length; j++) {
            let cellText = cols[j].innerText.replace(/"/g, '""');
            row.push('"' + cellText + '"');
        }
        
        csv.push(row.join(','));
    }
    
    // Download CSV file
    let csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
    let downloadLink = document.createElement('a');
    downloadLink.download = 'laporan-booking-' + new Date().toISOString().slice(0, 10) + '.csv';
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = 'none';
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>
@endpush
