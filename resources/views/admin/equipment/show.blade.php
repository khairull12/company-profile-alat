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
                @php
                    $specs = $equipment->specifications;
                @endphp
                @if($specs && is_array($specs) && count($specs) > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="mb-3">Spesifikasi</h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($specs as $key => $value)
                                        <div class="col-md-6 mb-2">
                                            <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong>
                                            {{ is_array($value) ? implode(', ', $value) : $value }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Equipment Statistics -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="mb-3">Statistik Alat</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ $equipment->stock }}</h4>
                                        <p class="mb-0">Stok Tersedia</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ $equipment->manufacture_year ?? 'N/A' }}</h4>
                                        <p class="mb-0">Tahun Produksi</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ $equipment->is_active ? 'Aktif' : 'Tidak Aktif' }}</h4>
                                        <p class="mb-0">Status</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ $equipment->created_at->format('M Y') }}</h4>
                                        <p class="mb-0">Ditambahkan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
