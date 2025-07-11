
@extends('admin.layouts.app')

@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Informasi Booking</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Kode Booking</th>
                        <td>{{ $booking->code }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @switch($booking->status)
                                @case('pending')
                                    <span class="badge bg-warning">Pending</span>
                                    @break
                                @case('confirmed') 
                                    <span class="badge bg-success">Dikonfirmasi</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                    @break
                                @case('completed')
                                    <span class="badge bg-info">Selesai</span>
                                    @break
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>{{ $booking->start_date->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>{{ $booking->end_date->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Total Hari</th>
                        <td>{{ $booking->total_days }} hari</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Alat</th>
                        <td>{{ $booking->equipment->name }}</td>
                    </tr>
                    <tr>
                        <th>Customer</th>
                        <td>{{ $booking->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $booking->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Total Harga</th>
                        <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $booking->notes ?: '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            
            @if($booking->status === 'pending')
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal">
                    <i class="fas fa-check me-2"></i>Konfirmasi
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                    <i class="fas fa-times me-2"></i>Batalkan
                </button>
            @endif
        </div>
    </div>
</div>

@if($booking->status === 'pending')
    <!-- Confirm Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin mengkonfirmasi booking ini?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Konfirmasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Batalkan Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin membatalkan booking ini?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection