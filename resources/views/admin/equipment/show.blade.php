@extends('admin.layouts.app')

@section('title', 'Detail Alat Berat')
@section('page-title', 'Detail Alat Berat')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Detail Alat: {{ $equipment->name }}</h5>
                <div>
                    <a href="{{ route('admin.equipment.edit', $equipment) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.equipment.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Equipment Images -->
                    <div class="col-md-6">
                        <h6 class="mb-3">Gambar Alat</h6>
                        @php
                            $images = !empty($equipment->images) && is_array($equipment->images) ? $equipment->images : [];
                        @endphp
                        @if(count($images) > 0)
                            <div id="equipmentCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($images as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset($image) }}" 
                                                 class="d-block w-100 rounded" 
                                                 alt="{{ $equipment->name }}"
                                                 style="height: 300px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                                @if(count($images) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#equipmentCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#equipmentCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                @endif
                            </div>
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 300px;">
                                <div class="text-center">
                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                    <p class="text-muted">Tidak ada gambar</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Equipment Details -->
                    <div class="col-md-6">
                        <h6 class="mb-3">Informasi Alat</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold" style="width: 40%;">Nama:</td>
                                <td>{{ $equipment->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kategori:</td>
                                <td>{{ $equipment->category->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Brand:</td>
                                <td>{{ $equipment->brand ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Model:</td>
                                <td>{{ $equipment->model ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tahun Pembuatan:</td>
                                <td>{{ $equipment->manufacture_year ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Harga per Hari:</td>
                                <td class="text-success fw-bold">Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Stok:</td>
                                <td>{{ $equipment->stock }} unit</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status:</td>
                                <td>
                                    @if($equipment->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Description -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="mb-3">Deskripsi</h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                @if($equipment->description)
                                    {!! nl2br(e($equipment->description)) !!}
                                @else
                                    <em class="text-muted">Tidak ada deskripsi</em>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specifications -->
                @if($equipment->specifications)
                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="mb-3">Spesifikasi</h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                @php
                                    $specs = is_array($equipment->specifications) ? 
                                        $equipment->specifications : 
                                        json_decode($equipment->specifications, true);
                                    $specs = is_array($specs) ? $specs : [];
                                @endphp
                                
                                @if(count($specs) > 0)
                                    <div class="row">
                                        @foreach($specs as $key => $value)
                                            <div class="col-md-6 mb-2">
                                                <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong>
                                                {{ is_array($value) ? implode(', ', $value) : $value }}
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <em class="text-muted">Tidak ada spesifikasi detail</em>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Recent Bookings -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="mb-3">Booking Terbaru</h6>
                        @if($equipment->bookings()->latest()->limit(5)->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Pelanggan</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Status</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($equipment->bookings()->with('user')->latest()->limit(5)->get() as $booking)
                                            <tr>
                                                <td>{{ $booking->customer_name ?: $booking->user->name }}</td>
                                                <td>{{ $booking->start_date->format('d/m/Y') }}</td>
                                                <td>{{ $booking->end_date->format('d/m/Y') }}</td>
                                                <td>
                                                    @switch($booking->status)
                                                        @case('pending')
                                                            <span class="badge bg-warning">Menunggu</span>
                                                            @break
                                                        @case('confirmed')
                                                            <span class="badge bg-info">Dikonfirmasi</span>
                                                            @break
                                                        @case('completed')
                                                            <span class="badge bg-success">Selesai</span>
                                                            @break
                                                        @case('cancelled')
                                                            <span class="badge bg-danger">Dibatalkan</span>
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Belum ada booking untuk alat ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush
