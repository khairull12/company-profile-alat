@extends('layouts.main')

@section('title', 'PT. Dhiva Sarana Transport Konstruksi')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-8">
                <div class="hero-content">
                    <div class="company-logo mb-4">
                        <div class="logo-circle">
                            <span class="logo-text">D</span>
                        </div>
                        <div class="company-info">
                            <h2 class="company-name">PT. Dhiva Sarana</h2>
                            <h3 class="company-tagline">Transport Konstruksi</h3>
                        </div>
                    </div>
                    
                    <p class="hero-description mb-4">
                        Menyediakan solusi lengkap penyewaan alat berat, 
                        maintenance profesional, dan layanan terbaik untuk 
                        mendukung kesuksesan proyek konstruksi Anda
                    </p>
                    
                    <div class="hero-actions d-flex gap-3 mb-5">
                        <a href="{{ route('equipment.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-tools me-2"></i>Lihat Katalog
                        </a>
                        <a href="{{ route('equipment.index') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-eye me-2"></i>Lihat Katalog
                        </a>
                    </div>
                    
                    <!-- Hero Statistics -->
                    <div class="hero-stats row">
                        <div class="col-md-4">
                            <div class="stat-item">
                                <h3 class="stat-number">{{ $statistics['total_equipment'] ?? '200+' }}</h3>
                                <p class="stat-label">Unit Alat Berat</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-item">
                                <h3 class="stat-number">{{ $statistics['completed_projects'] ?? '750+' }}</h3>
                                <p class="stat-label">Proyek Selesai</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-item">
                                <h3 class="stat-number">{{ $statistics['years_experience'] ?? '15+' }}</h3>
                                <p class="stat-label">Tahun Pengalaman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="hero-form-container">
                    <div class="hero-form">
                        <div class="form-header">
                            <div class="form-icon">
                                <i class="fas fa-wrench"></i>
                            </div>
                            <h4>Cari Alat Berat</h4>
                            <p>Dapatkan alat berat yang Anda butuhkan dengan mudah</p>
                        </div>
                        <form action="{{ route('equipment.index') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="category" class="form-select">
                                    <option value="">Pilih Kategori</option>
                                    @forelse($categories as $category)
                                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                    @empty
                                        <option value="">Belum ada kategori tersedia</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lokasi</label>
                                <select name="location" class="form-select">
                                    <option value="">Pilih Lokasi</option>
                                    <option value="jakarta">Jakarta</option>
                                    <option value="bekasi">Bekasi</option>
                                    <option value="tangerang">Tangerang</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll indicator -->
    <div class="scroll-indicator">
        <a href="#stats-section" class="scroll-btn">
            <span class="scroll-text">Halaman berikut</span>
            <i class="fas fa-chevron-down"></i>
        </a>
    </div>
</section>

<!-- Statistics & Achievement Section -->
<section class="stats-section" id="stats-section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <div class="section-badge">
                <i class="fas fa-chart-line"></i>
                <span>Pencapaian Kami</span>
            </div>
            <h2 class="section-title">Statistik & Prestasi</h2>
            <p class="section-subtitle">
                Kepercayaan klien adalah prioritas utama kami dalam memberikan 
                layanan terbaik
            </p>
        </div>
        
        <div class="row justify-content-center equal-height">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="{{ $statistics['total_equipment_icon'] ?? 'fas fa-tools' }}"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $statistics['total_equipment'] ?? '200+' }}</h3>
                        <p class="stat-title text-white-important">{{ $statistics['total_equipment_label'] ?? 'Total Alat Berat' }}</p>
                        <p class="stat-desc text-white-important">{{ $statistics['total_equipment_description'] ?? 'Unit tersedia siap beroperasi' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="{{ $statistics['completed_projects_icon'] ?? 'fas fa-project-diagram' }}"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $statistics['completed_projects'] ?? '750+' }}</h3>
                        <p class="stat-title text-white-important">{{ $statistics['completed_projects_label'] ?? 'Proyek Selesai' }}</p>
                        <p class="stat-desc text-white-important">{{ $statistics['completed_projects_description'] ?? 'Proyek berhasil diselesaikan' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="{{ $statistics['client_satisfaction_icon'] ?? 'fas fa-star' }}"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $statistics['client_satisfaction'] ?? '99%' }}</h3>
                        <p class="stat-title text-white-important">{{ $statistics['client_satisfaction_label'] ?? 'Kepuasan Klien' }}</p>
                        <p class="stat-desc text-white-important">{{ $statistics['client_satisfaction_description'] ?? 'Tingkat kepuasan pelanggan' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="{{ $statistics['years_experience_icon'] ?? 'fas fa-calendar-alt' }}"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $statistics['years_experience'] ?? '15+' }}</h3>
                        <p class="stat-title text-white-important">{{ $statistics['years_experience_label'] ?? 'Pengalaman' }}</p>
                        <p class="stat-desc text-white-important">{{ $statistics['years_experience_description'] ?? 'Tahun melayani industri' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Company Section -->
<section class="about-section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <div class="section-badge">
                <i class="fas fa-building"></i>
                <span>Tentang Kami</span>
            </div>
            <h2 class="section-title">Mengenal PT. Dhiva Sarana</h2>
            <p class="section-subtitle">
                Komitmen kami untuk menjadi mitra terpercaya dalam industri 
                transportasi konstruksi di Indonesia
            </p>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-6 mb-4">
                <div class="about-content">
                    <h3 class="about-title">Sejarah & Perjalanan</h3>
                    <p class="about-text">
                        Didirikan pada tahun 2008, PT. Dhiva Sarana Transport Konstruksi telah 
                        berkembang menjadi salah satu perusahaan penyewaan alat berat 
                        terpercaya di Indonesia. Dengan pengalaman lebih dari 15 tahun, kami telah 
                        melayani berbagai proyek konstruksi skala nasional.
                    </p>
                    
                    <p class="about-text">
                        Komitmen kami adalah memberikan solusi terbaik untuk setiap kebutuhan 
                        konstruksi dengan menyediakan peralatan berkualitas, pelayanan 
                        maintenance, dan kepuasan pelanggan.
                    </p>

                    <div class="timeline-info">
                        <div class="timeline-item">
                            <div class="timeline-year">2008</div>
                            <div class="timeline-content">
                                <h5>Tahun Berdiri</h5>
                                <p>Memulai perjalanan dengan visi besar</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">50+</div>
                            <div class="timeline-content">
                                <h5>Karyawan Ahli</h5>
                                <p>Tim professional berpengalaman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="company-building">
                    <div class="building-card">
                        <div class="building-header">
                            <h4>Company Building</h4>
                        </div>
                        <div class="building-content">
                            <div class="building-info">
                                <h5>Kantor Pusat Jakarta</h5>
                                <p>Mengelola seluruh Indonesia dengan standar internasional</p>
                            </div>
                            <div class="building-image">
                                <img src="https://via.placeholder.com/400x250/1e3a8a/ffffff?text=Kantor+Pusat" alt="Kantor Pusat" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company Values Section -->
<section class="values-section">
    <div class="container">
        <div class="row equal-height">
            <div class="col-lg-4 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <div class="value-content">
                        <h4 class="text-white-important">Fokus Kualitas</h4>
                        <p class="text-white-important">
                            Setiap unit alat berat melalui inspeksi ketat dan 
                            perawatan berkala untuk memastikan performa optimal 
                            serta keamanan operasional.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="value-content">
                        <h4 class="text-white-important">Kepercayaan Klien</h4>
                        <p class="text-white-important">
                            Membangun hubungan jangka panjang dengan klien melalui 
                            kepercayaan yang kokoh menjadi prioritas utama dalam 
                            setiap layanan.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="value-content">
                        <h4 class="text-white-important">Inovasi Berkelanjutan</h4>
                        <p class="text-white-important">
                            Terus mengupgrade teknologi dan menyediakan solusi inovatif untuk 
                            meningkatkan efisiensi dan keamanan operasional.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="vision-mission-section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <div class="section-badge">
                <i class="fas fa-eye"></i>
                <span>Visi & Misi</span>
            </div>
            <h2 class="section-title">Visi & Misi Perusahaan</h2>
            <p class="section-subtitle">
                Komitmen kami untuk menjadi perusahaan dalam industri 
                penyewaan alat berat
            </p>
        </div>

        <div class="vision-mission-content">
            <div class="vm-card">
                <div class="vm-header">
                    <div class="vm-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Visi</h3>
                </div>
                <div class="vm-body">
                    <p>
                        Menjadi perusahaan penyewaan alat berat terdepan di Indonesia yang 
                        memberikan solusi konstruksi terbaik dengan teknologi modern dan 
                        pelayanan profesional yang dapat diandalkan oleh seluruh mitra bisnis.
                    </p>
                </div>
            </div>

            <div class="vm-card">
                <div class="vm-header">
                    <div class="vm-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Misi</h3>
                </div>
                <div class="vm-body">
                    <ul>
                        <li>Menyediakan alat berat berkualitas tinggi dengan teknologi terkini</li>
                        <li>Memberikan pelayanan maintenance dan support terbaik</li>
                        <li>Membangun kemitraan jangka panjang dengan kepercayaan tinggi</li>
                        <li>Mengembangkan SDM profesional dan berpengalaman</li>
                        <li>Berkontribusi pada pembangunan infrastruktur Indonesia</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content text-center">
            <div class="cta-icon mb-4">
                <i class="fas fa-handshake"></i>
            </div>
            <h2 class="cta-title">Siap Memulai Proyek Anda?</h2>
            <p class="cta-subtitle">
                Hubungi kami sekarang dan dapatkan penawaran terbaik untuk 
                kebutuhan alat berat konstruksi Anda
            </p>
            <div class="cta-actions">
                <a href="{{ route('contact') }}" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-phone me-2"></i>Hubungi Sekarang
                </a>
                <a href="{{ route('contact') }}" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-catalog me-2"></i>Lihat Katalog
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
