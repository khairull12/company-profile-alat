@extends('admin.layouts.app')

@section('title', 'Laporan & Rekapitulasi')
@section('page-title', 'Laporan & Rekapitulasi')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Filter Laporan</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" 
                               value="{{ $startDate }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="end_date" 
                               value="{{ $endDate }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Alat</label>
                        <select class="form-control" name="equipment_id">
                            <option value="">Semua Alat</option>
                            @foreach($equipment as $item)
                                <option value="{{ $item->id }}" 
                                        {{ $equipmentId == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">User</label>
                        <select class="form-control" name="user_id">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                        {{ $userId == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <div>
                    <a href="{{ route('admin.reports.export', request()->query() + ['format' => 'excel']) }}" 
                       class="btn btn-success">
                        <i class="fas fa-file-excel mr-1"></i> Export Excel
                    </a>
                    <a href="{{ route('admin.reports.export', request()->query() + ['format' => 'pdf']) }}" 
                       class="btn btn-danger">
                        <i class="fas fa-file-pdf mr-1"></i> Export PDF
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Booking</h5>
                <h3 class="mb-0">{{ $totalBookings }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Confirmed</h5>
                <h3 class="mb-0">{{ $confirmedBookings }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Completed</h5>
                <h3 class="mb-0">{{ $completedBookings }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">Total Pendapatan</h5>
                <h3 class="mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Alat Paling Banyak Disewa</h5>
            </div>
            <div class="card-body">
                @forelse($equipmentUsage as $usage)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <strong>{{ $usage['equipment']->name }}</strong><br>
                            <small class="text-muted">{{ $usage['equipment']->category->name }}</small>
                        </div>
                        <div class="text-right">
                            <span class="badge bg-primary">{{ $usage['total_bookings'] }} booking</span><br>
                            <small class="text-muted">Rp {{ number_format($usage['total_revenue'], 0, ',', '.') }}</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">User Paling Aktif</h5>
            </div>
            <div class="card-body">
                @forelse($userActivity as $activity)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <strong>{{ $activity['user']->name }}</strong><br>
                            <small class="text-muted">{{ $activity['user']->email }}</small>
                        </div>
                        <div class="text-right">
                            <span class="badge bg-success">{{ $activity['total_bookings'] }} booking</span><br>
                            <small class="text-muted">Rp {{ number_format($activity['total_spent'], 0, ',', '.') }}</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Detail Booking</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>User</th>
                        <th>Alat</th>
                        <th>Tanggal Sewa</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->booking_code }}</td>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->equipment->name }}</td>
                            <td>{{ $booking->start_date->format('d M Y') }} - {{ $booking->end_date->format('d M Y') }}</td>
                            <td>{{ $booking->duration_days }} hari</td>
                            <td>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</td>
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($booking->status == 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @else
                                    <span class="badge bg-primary">Completed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data booking</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
