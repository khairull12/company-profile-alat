@extends('layouts.main')

@section('title', $equipment->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('equipment.index') }}">Katalog Alat</a></li>
                    <li class="breadcrumb-item active">{{ $equipment->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <!-- Equipment Images -->
        <div class="col-lg-6 mb-4">
            <div class="equipment-gallery">
                @php
                    $images = !empty($equipment->images) && is_array($equipment->images) ? $equipment->images : [];
                @endphp
                @if(count($images) > 0)
                    <div id="equipmentCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($images as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($image) }}" class="d-block w-100 rounded" 
                                         alt="{{ $equipment->name }} - {{ $equipment->category->name }} (Gambar {{ $index + 1 }} dari {{ count($images) }})">
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
                    <img src="https://via.placeholder.com/600x400/2563eb/ffffff?text={{ urlencode($equipment->name) }}" 
                         class="img-fluid rounded" alt="{{ $equipment->name }}">
                @endif
            </div>
        </div>
        
        <!-- Equipment Details -->
        <div class="col-lg-6">
            <div class="equipment-details">
                <h1 class="h2 fw-bold mb-3">{{ $equipment->name }}</h1>
                
                <div class="price-info mb-4">
                    <span class="h3 text-primary fw-bold">Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }}</span>
                    <span class="text-muted"> / hari</span>
                </div>
                
                <div class="equipment-meta mb-4">
                    <div class="row">
                        <div class="col-6">
                            <strong>Kategori:</strong><br>
                            <span class="badge bg-primary">{{ $equipment->category->name }}</span>
                        </div>
                        <div class="col-6">
                            <strong>Stok Tersedia:</strong><br>
                            <span class="badge bg-success">{{ $equipment->stock }} Unit</span>
                        </div>
                    </div>
                </div>
                
                @if($equipment->brand || $equipment->model || $equipment->manufacture_year)
                    <div class="equipment-info mb-4">
                        <div class="row">
                            @if($equipment->brand)
                                <div class="col-4">
                                    <strong>Merek:</strong><br>
                                    {{ $equipment->brand }}
                                </div>
                            @endif
                            @if($equipment->model)
                                <div class="col-4">
                                    <strong>Model:</strong><br>
                                    {{ $equipment->model }}
                                </div>
                            @endif
                            @if($equipment->manufacture_year)
                                <div class="col-4">
                                    <strong>Tahun:</strong><br>
                                    {{ $equipment->manufacture_year }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                
                <div class="description mb-4">
                    <h5>Deskripsi</h5>
                    <p>{{ $equipment->description }}</p>
                </div>
                
                @if($equipment->specifications)
                    <div class="specifications mb-4">
                        <h5>Spesifikasi</h5>
                        <div class="row">
                            @php
                                $specs = is_array($equipment->specifications) ? 
                                    $equipment->specifications : 
                                    json_decode($equipment->specifications, true);
                                $specs = is_array($specs) ? $specs : [];
                            @endphp
                            @if(count($specs) > 0)
                                @foreach($specs as $key => $value)
                                    <div class="col-6 mb-2">
                                        <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong><br>
                                        {{ is_array($value) ? implode(', ', $value) : $value }}
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <p class="text-muted">Tidak ada spesifikasi tersedia</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                
                <div class="contact-actions">
                    <a href="tel:{{ config('company.phone', '+62123456789') }}" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-phone me-2"></i>Hubungi untuk Sewa
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-envelope me-2"></i>Kirim Pesan
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Equipment -->
    @if($relatedEquipment->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="fw-bold mb-4">Alat Berat Sejenis</h3>
            </div>
        </div>
        <div class="row">
            @foreach($relatedEquipment as $item)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card equipment-card h-100">
                        @php
                            $itemImages = !empty($item->images) && is_array($item->images) ? $item->images : [];
                            $firstImage = !empty($itemImages) ? $itemImages[0] : null;
                        @endphp
                        @if($firstImage)
                            <img src="{{ asset($firstImage) }}" class="card-img-top" 
                                alt="{{ $item->name }} - {{ $item->category->name }} (Rp {{ number_format($item->price_per_day, 0, ',', '.') }}/hari)">
                        @else
                            <img src="https://via.placeholder.com/250x150/2563eb/ffffff?text={{ urlencode($item->name) }}" 
                                 class="card-img-top" 
                                 alt="{{ $item->name }} - {{ $item->category->name }} (Rp {{ number_format($item->price_per_day, 0, ',', '.') }}/hari)">
                        @endif
                        <div class="price-badge">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}/hari</div>
                        <div class="card-body">
                            <h6 class="card-title">{{ $item->name }}</h6>
                            <p class="card-text small">{{ Str::limit($item->description, 80) }}</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('equipment.show', $item) }}" class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-eye me-1"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.equipment-gallery .carousel-item img {
    height: 400px;
    object-fit: cover;
}

.equipment-meta, .equipment-info {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
}
</style>
@endsection
