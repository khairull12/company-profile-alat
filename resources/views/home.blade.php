@extends('layouts.main')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">{{ $settings['hero_title'] ?? 'Solusi Penyewaan Alat Berat Terpercaya' }}</h1>
                <p class="lead mb-4">{{ $settings['hero_subtitle'] ?? 'Kami menyediakan berbagai macam alat berat berkualitas untuk kebutuhan konstruksi Anda' }}</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('equipment.index') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-tools me-2"></i>Lihat Katalog
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-phone me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                @if(isset($settings['hero_image']) && $settings['hero_image'])
                    <img src="{{ asset($settings['hero_image']) }}" alt="Hero Image" class="img-fluid rounded">
                @else
                    <img src="https://via.placeholder.com/600x400/2563eb/ffffff?text=Alat+Berat" alt="Hero Image" class="img-fluid rounded">
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-5 fw-bold">Kategori Alat Berat</h2>
                <p class="text-muted">Berbagai macam alat berat untuk kebutuhan konstruksi Anda</p>
            </div>
        </div>
        
        <div class="row">
            @foreach($categories as $category)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        @if($category->image)
                            <img src="{{ asset($category->image) }}" class="card-img-top" alt="{{ $category->name }}">
                        @else
                            <img src="https://via.placeholder.com/350x200/2563eb/ffffff?text={{ urlencode($category->name) }}" class="card-img-top" alt="{{ $category->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text">{{ $category->description }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary">{{ $category->equipment->count() }} Alat</span>
                                <a href="{{ route('equipment.index', ['category' => $category->slug]) }}" class="btn btn-outline-primary">
                                    Lihat Alat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Equipment Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-5 fw-bold">Alat Berat Unggulan</h2>
                <p class="text-muted">Alat berat terbaik dan paling populer dari koleksi kami</p>
            </div>
        </div>
        
        <div class="row">
            @foreach($featuredEquipment as $equipment)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card equipment-card h-100">
                        @if($equipment->first_image)
                            <img src="{{ asset($equipment->first_image) }}" class="card-img-top" alt="{{ $equipment->name }}">
                        @else
                            <img src="https://via.placeholder.com/350x200/2563eb/ffffff?text={{ urlencode($equipment->name) }}" class="card-img-top" alt="{{ $equipment->name }}">
                        @endif
                        <div class="price-badge">Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }}/hari</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $equipment->name }}</h5>
                            <p class="card-text">{{ Str::limit($equipment->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary">{{ $equipment->category->name }}</span>
                                <span class="text-muted">
                                    <i class="fas fa-cubes me-1"></i>
                                    Stok: {{ $equipment->stock }}
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex gap-2">
                                <a href="{{ route('equipment.show', $equipment) }}" class="btn btn-outline-primary flex-fill">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                                @auth
                                    <a href="{{ route('bookings.create', $equipment) }}" class="btn btn-primary flex-fill">
                                        <i class="fas fa-calendar me-1"></i>Booking
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary flex-fill">
                                        <i class="fas fa-sign-in-alt me-1"></i>Login
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="row">
            <div class="col-12 text-center mt-4">
                <a href="{{ route('equipment.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-tools me-2"></i>Lihat Semua Alat
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-5 fw-bold">Mengapa Memilih Kami?</h2>
                <p class="text-muted">Keunggulan layanan penyewaan alat berat kami</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-tools fa-3x text-primary"></i>
                    </div>
                    <h5>Alat Berkualitas</h5>
                    <p class="text-muted">Semua alat berat kami dalam kondisi prima dan terawat dengan baik</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-clock fa-3x text-primary"></i>
                    </div>
                    <h5>Pelayanan 24/7</h5>
                    <p class="text-muted">Tim support kami siap membantu Anda kapan saja</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-shield-alt fa-3x text-primary"></i>
                    </div>
                    <h5>Terpercaya</h5>
                    <p class="text-muted">Pengalaman lebih dari 10 tahun melayani proyek konstruksi</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-dollar-sign fa-3x text-primary"></i>
                    </div>
                    <h5>Harga Kompetitif</h5>
                    <p class="text-muted">Dapatkan harga terbaik untuk setiap kebutuhan alat berat Anda</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold mb-3">Siap Memulai Proyek Anda?</h2>
                <p class="lead mb-0">Hubungi kami sekarang dan dapatkan penawaran terbaik untuk kebutuhan alat berat Anda</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-phone me-2"></i>Hubungi Sekarang
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
