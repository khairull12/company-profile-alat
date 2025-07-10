@extends('layouts.main')

@section('title', 'Booking Saya')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <h1 class="display-5 fw-bold">Booking Saya</h1>
            <p class="text-muted">Daftar semua booking alat berat yang telah Anda lakukan</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            @if($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Kode Booking</th>
                                <th>Alat</th>
                                <th>Tanggal Sewa</th>
                                <th>Durasi</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <strong>{{ $booking->booking_code }}</strong><br>
                                        <small class="text-muted">{{ $booking->created_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($booking->equipment->first_image)
                                                <img src="{{ asset($booking->equipment->first_image) }}" 
                                                     class="me-3 rounded" style="width: 50px; height: 50px; object-fit: cover;" 
                                                     alt="{{ $booking->equipment->name }}">
                                            @endif
                                            <div>
                                                <strong>{{ $booking->equipment->name }}</strong><br>
                                                <small class="text-muted">{{ $booking->equipment->category->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $booking->start_date->format('d/m/Y') }} <br>
                                        <small class="text-muted">s/d {{ $booking->end_date->format('d/m/Y') }}</small>
                                    </td>
                                    <td>{{ $booking->duration_days }} hari</td>
                                    <td>
                                        <strong>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</strong><br>
                                        <small class="text-muted">Rp {{ number_format($booking->daily_rate, 0, ',', '.') }}/hari</small>
                                    </td>
                                    <td>
                                        @switch($booking->status)
                                            @case('pending')
                                                <span class="status-badge status-pending">Pending</span>
                                                @break
                                            @case('confirmed')
                                                <span class="status-badge status-confirmed">Dikonfirmasi</span>
                                                @break
                                            @case('completed')
                                                <span class="status-badge status-completed">Selesai</span>
                                                @break
                                            @case('cancelled')
                                                <span class="status-badge status-cancelled">Dibatalkan</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                {{ $bookings->links() }}
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h4>Belum Ada Booking</h4>
                    <p class="text-muted">Anda belum melakukan booking alat berat apapun.</p>
                    <a href="{{ route('equipment.index') }}" class="btn btn-primary">
                        <i class="fas fa-tools me-2"></i>Lihat Katalog Alat
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
