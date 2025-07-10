@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Stats Cards -->
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title">Total Alat</h6>
                        <h3 class="mb-0">{{ $totalEquipment }}</h3>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-tools fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title">Total Booking</h6>
                        <h3 class="mb-0">{{ $totalBookings }}</h3>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title">Pending Booking</h6>
                        <h3 class="mb-0">{{ $pendingBookings }}</h3>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title">Total User</h6>
                        <h3 class="mb-0">{{ $totalUsers }}</h3>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Total Pendapatan</h5>
            </div>
            <div class="card-body">
                <h2 class="text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                <p class="text-muted mb-0">Dari booking yang telah selesai</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Booking Terbaru</h5>
            </div>
            <div class="card-body">
                @forelse($recentBookings as $booking)
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $booking->equipment->name }}</h6>
                            <p class="text-muted mb-0">{{ $booking->user->name }}</p>
                            <small class="text-muted">{{ $booking->created_at->format('d M Y H:i') }}</small>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'confirmed' ? 'success' : 'secondary') }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada booking</p>
                @endforelse
                
                <div class="text-center mt-3">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua Booking
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Alat Berat
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-success w-100">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Kelola Booking
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-info w-100">
                            <i class="fas fa-cog mr-2"></i>
                            Pengaturan Website
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-warning w-100">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
