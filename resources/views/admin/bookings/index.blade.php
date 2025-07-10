@extends('admin.layouts.app')

@section('title', 'Kelola Booking')
@section('page-title', 'Kelola Booking')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Booking</h5>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <div class="row mb-3">
            <div class="col-md-3">
                <select class="form-control" id="status-filter">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" id="date-filter" placeholder="Filter berdasarkan tanggal">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id="search-filter" placeholder="Cari berdasarkan nama user atau alat">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" onclick="filterBookings()">Filter</button>
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
                                        <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" 
                                                    onclick="return confirm('Konfirmasi booking ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Batalkan booking ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($booking->status == 'confirmed')
                                        <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST" class="d-inline">
                                            @csrf
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
