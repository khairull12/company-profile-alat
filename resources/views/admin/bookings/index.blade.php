@extends('admin.layouts.app')

@section('title', 'Kelola Booking')
@section('page-title', 'Manajemen Booking & Pembukuan')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="text-primary mb-2">
                    <i class="fas fa-calendar-alt fa-2x"></i>
                </div>
                <h4 class="fw-bold text-primary">{{ $stats['total_bookings'] ?? 0 }}</h4>
                <small class="text-muted">Total Booking</small>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="text-warning mb-2">
                    <i class="fas fa-clock fa-2x"></i>
                </div>
                <h4 class="fw-bold text-warning">{{ $stats['pending_bookings'] ?? 0 }}</h4>
                <small class="text-muted">Pending</small>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="text-info mb-2">
                    <i class="fas fa-tools fa-2x"></i>
                </div>
                <h4 class="fw-bold text-info">{{ $stats['ongoing_bookings'] ?? 0 }}</h4>
                <small class="text-muted">Sedang Berjalan</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="text-success mb-2">
                    <i class="fas fa-money-bill-wave fa-2x"></i>
                </div>
                <h4 class="fw-bold text-success">Rp {{ number_format($stats['this_month_revenue'] ?? 0, 0, ',', '.') }}</h4>
                <small class="text-muted">Pendapatan Bulan Ini</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="text-danger mb-2">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
                <h4 class="fw-bold text-danger">{{ $stats['overdue_bookings'] ?? 0 }}</h4>
                <small class="text-muted">Booking Terlambat</small>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Search -->
<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-filter me-2"></i>Filter & Pencarian
            </h5>
            <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Buat Booking Baru
            </a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.bookings.index') }}">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="payment_status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Sebagian</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Alat</label>
                    <select name="equipment_id" class="form-select">
                        <option value="">Semua Alat</option>
                        @if(isset($equipment))
                            @foreach($equipment as $item)
                                <option value="{{ $item->id }}" {{ request('equipment_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Pencarian</label>
                    <input type="text" name="search" class="form-control" placeholder="Nomor booking, nama, telepon..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh me-1"></i>Reset
                        </a>
                        <a href="{{ route('admin.bookings.report') }}" class="btn btn-success">
                            <i class="fas fa-file-excel me-1"></i>Laporan
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
        
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>
                                <strong>{{ $booking->booking_code }}</strong><br>
                                <small class="text-muted">{{ $booking->created_at->format('d M Y H:i') }}</small>
                            </td>
                            <td>
                                <strong>{{ $booking->user->name }}</strong><br>
                                <small class="text-muted">{{ $booking->user->email }}</small>
                            </td>
                            <td>
                                <strong>{{ $booking->equipment->name }}</strong><br>
                                <small class="text-muted">{{ $booking->equipment->category->name }}</small>
                            </td>
                            <td>
                                {{ $booking->start_date->format('d M Y') }} - 
                                {{ $booking->end_date->format('d M Y') }}
                            </td>
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
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($booking->status == 'pending')
                                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-sm btn-success" 
                                                    onclick="return confirm('Konfirmasi booking ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Batalkan booking ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($booking->status == 'confirmed')
                                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-sm btn-primary" 
                                                    onclick="return confirm('Tandai booking ini selesai?')">
                                                <i class="fas fa-flag-checkered"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada booking</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $bookings->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
function filterBookings() {
    const status = document.getElementById('status-filter').value;
    const date = document.getElementById('date-filter').value;
    const search = document.getElementById('search-filter').value;
    
    let url = new URL(window.location.href);
    
    if (status) url.searchParams.set('status', status);
    else url.searchParams.delete('status');
    
    if (date) url.searchParams.set('date', date);
    else url.searchParams.delete('date');
    
    if (search) url.searchParams.set('search', search);
    else url.searchParams.delete('search');
    
    window.location.href = url.toString();
}
</script>
@endpush
