
@extends('admin.layouts.app')

@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking #' . $booking->booking_number)

@section('content')
<div class="row">
    <!-- Main Booking Details -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Booking #{{ $booking->booking_number }}</h5>
                        <small class="text-muted">Dibuat: {{ $booking->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Status Overview -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong>Status Booking:</strong> {!! $booking->getStatusBadge() !!}
                    </div>
                    <div class="col-md-6">
                        <strong>Status Pembayaran:</strong> {!! $booking->getPaymentStatusBadge() !!}
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary border-bottom pb-2">
                            <i class="fas fa-user me-2"></i>Informasi Customer
                        </h6>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="fw-semibold" style="width: 120px;">Customer:</td>
                                <td>{{ $booking->user->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Email:</td>
                                <td>{{ $booking->user->email }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Nama Kontak:</td>
                                <td>{{ $booking->contact_name }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="fw-semibold" style="width: 120px;">Telepon:</td>
                                <td>{{ $booking->contact_phone }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Email Kontak:</td>
                                <td>{{ $booking->contact_email ?: '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Equipment Information -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary border-bottom pb-2">
                            <i class="fas fa-tools me-2"></i>Detail Alat Berat
                        </h6>
                    </div>
                    <div class="col-md-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6 class="fw-bold">{{ $booking->equipment->name }}</h6>
                                        <p class="mb-1"><strong>Kategori:</strong> {{ $booking->equipment->category->name ?? '-' }}</p>
                                        <p class="mb-1"><strong>Spesifikasi:</strong></p>
                                        @php
                                            $specs = $booking->equipment->specifications;
                                        @endphp
                                        @if($specs && is_array($specs) && count($specs) > 0)
                                            <ul class="mb-0">
                                                @foreach($specs as $key => $value)
                                                    <li><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted mb-0">Tidak ada spesifikasi</p>
                                        @endif
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <h5 class="text-primary">Rp {{ number_format($booking->equipment->price_per_day, 0, ',', '.') }}</h5>
                                        <small class="text-muted">per hari</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rental Period -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary border-bottom pb-2">
                            <i class="fas fa-calendar me-2"></i>Periode Rental
                        </h6>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="fas fa-play text-success fa-2x mb-2"></i>
                            <h6 class="fw-bold">Tanggal Mulai</h6>
                            <p class="mb-0">{{ $booking->start_date->format('d/m/Y') }}</p>
                            <small class="text-muted">{{ $booking->start_date->format('l') }}</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="fas fa-clock text-primary fa-2x mb-2"></i>
                            <h6 class="fw-bold">Durasi</h6>
                            <p class="mb-0">{{ $booking->getDurationDays() }} Hari</p>
                            <small class="text-muted">{{ $booking->start_date->diffInDays($booking->end_date) + 1 }} hari rental</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="fas fa-stop text-danger fa-2x mb-2"></i>
                            <h6 class="fw-bold">Tanggal Selesai</h6>
                            <p class="mb-0">{{ $booking->end_date->format('d/m/Y') }}</p>
                            <small class="text-muted">{{ $booking->end_date->format('l') }}</small>
                        </div>
                    </div>
                </div>

                <!-- Delivery Address -->
                @if($booking->delivery_address)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary border-bottom pb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>Alamat Pengiriman
                        </h6>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ $booking->delivery_address }}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Notes -->
                @if($booking->notes || $booking->admin_notes)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary border-bottom pb-2">
                            <i class="fas fa-sticky-note me-2"></i>Catatan
                        </h6>
                    </div>
                    @if($booking->notes)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header py-2">
                                <h6 class="mb-0"><i class="fas fa-user me-1"></i>Catatan Customer</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $booking->notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($booking->admin_notes)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header py-2">
                                <h6 class="mb-0"><i class="fas fa-user-shield me-1"></i>Catatan Admin</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $booking->admin_notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Cost Breakdown -->
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-money-bill-wave me-2"></i>Rincian Biaya
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-3">
                    <tr>
                        <td>Biaya Rental:</td>
                        <td class="text-end">Rp {{ number_format($booking->rental_cost, 0, ',', '.') }}</td>
                    </tr>
                    @if($booking->delivery_cost > 0)
                    <tr>
                        <td>Biaya Pengiriman:</td>
                        <td class="text-end">Rp {{ number_format($booking->delivery_cost, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($booking->operator_cost > 0)
                    <tr>
                        <td>Biaya Operator:</td>
                        <td class="text-end">Rp {{ number_format($booking->operator_cost, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($booking->insurance_cost > 0)
                    <tr>
                        <td>Biaya Asuransi:</td>
                        <td class="text-end">Rp {{ number_format($booking->insurance_cost, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr class="table-dark">
                        <td><strong>Total:</strong></td>
                        <td class="text-end"><strong>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
                
                @if($booking->deposit_amount > 0)
                <div class="alert alert-warning py-2">
                    <small><strong>Deposit:</strong> Rp {{ number_format($booking->deposit_amount, 0, ',', '.') }}</small>
                </div>
                @endif
            </div>
        </div>

        <!-- Payment Information -->
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-credit-card me-2"></i>Informasi Pembayaran
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Dibayar:</small>
                        <h6 class="text-success">Rp {{ number_format($booking->paid_amount, 0, ',', '.') }}</h6>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Sisa:</small>
                        <h6 class="text-danger">Rp {{ number_format($booking->total_amount - $booking->paid_amount, 0, ',', '.') }}</h6>
                    </div>
                </div>
                
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar" role="progressbar" 
                         style="width: {{ $booking->total_amount > 0 ? ($booking->paid_amount / $booking->total_amount) * 100 : 0 }}%">
                    </div>
                </div>
                
                <div class="text-center">
                    {!! $booking->getPaymentStatusBadge() !!}
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($booking->status == 'pending')
                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="btn btn-success btn-sm w-100">
                                <i class="fas fa-check me-1"></i>Konfirmasi Booking
                            </button>
                        </form>
                    @endif
                    
                    @if($booking->status == 'confirmed')
                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="active">
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-play me-1"></i>Mulai Rental
                            </button>
                        </form>
                    @endif
                    
                    @if($booking->status == 'active')
                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-info btn-sm w-100">
                                <i class="fas fa-stop me-1"></i>Selesai Rental
                            </button>
                        </form>
                    @endif
                    
                    @if(in_array($booking->status, ['pending', 'confirmed']))
                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" 
                              onsubmit="return confirm('Yakin ingin membatalkan booking ini?')" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-times me-1"></i>Batalkan Booking
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-warning btn-sm w-100">
                        <i class="fas fa-edit me-1"></i>Edit Booking
                    </a>
                    
                    <button class="btn btn-outline-primary btn-sm w-100" onclick="window.print()">
                        <i class="fas fa-print me-1"></i>Cetak Detail
                    </button>
                </div>
            </div>
        </div>
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
}
</style>
@endpush