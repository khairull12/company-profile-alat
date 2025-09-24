@extends('layouts.main')

@section('title', 'Visi & Misi')

@section('content')
<!-- Hero Section for Vision Mission -->
<section class="hero-section" style="min-height: 60vh; background: linear-gradient(135deg, var(--dark-bg) 0%, #1e293b 50%, #0ea5e9 100%);">
    <div class="container">
        <div class="row align-items-center" style="min-height: 60vh;">
            <div class="col-12 text-center">
                <div class="hero-content">
                    <div class="section-badge mb-4">
                        <i class="fas fa-eye"></i>
                        <span>Visi & Misi</span>
                    </div>
                    <h1 class="display-3 fw-bold mb-4">Visi & Misi Perusahaan</h1>
                    <p class="hero-description mb-0" style="max-width: 600px; margin: 0 auto;">
                        Komitmen kami untuk menjadi perusahaan terdepan dalam industri 
                        penyewaan alat berat dengan standar pelayanan internasional
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll indicator -->
    <div class="scroll-indicator">
        <a href="#vision-mission-content" class="scroll-btn">
            <span class="scroll-text">Pelajari Lebih Lanjut</span>
            <i class="fas fa-chevron-down"></i>
        </a>
    </div>
</section>

<!-- Vision & Mission Content Section -->
<section class="vision-mission-section py-5" id="vision-mission-content" style="background: transparent;">
    <div class="container">
        <div class="row">
            <!-- Vision Card -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-0 shadow-lg" style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); color: white;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-wrapper me-3" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-eye fa-2x"></i>
                            </div>
                            <h3 class="card-title mb-0 fw-bold">{{ $settings['vision_title'] ?? 'Visi Kami' }}</h3>
                        </div>
                        <div class="content" style="line-height: 1.8; font-size: 1.1rem;">
                            {!! $settings['vision_content'] ?? '<p>Menjadi perusahaan penyewaan alat berat terdepan di Indonesia yang memberikan solusi konstruksi terbaik dengan teknologi modern dan pelayanan profesional yang dapat diandalkan oleh seluruh mitra bisnis.</p>' !!}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mission Card -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-0 shadow-lg" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-wrapper me-3" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-bullseye fa-2x"></i>
                            </div>
                            <h3 class="card-title mb-0 fw-bold">{{ $settings['mission_title'] ?? 'Misi Kami' }}</h3>
                        </div>
                        <div class="content" style="line-height: 1.8; font-size: 1.1rem;">
                            {!! $settings['mission_content'] ?? '<ul class="list-unstyled"><li class="mb-2"><i class="fas fa-check-circle me-2 text-white"></i>Menyediakan alat berat berkualitas tinggi dengan teknologi terkini</li><li class="mb-2"><i class="fas fa-check-circle me-2 text-white"></i>Memberikan pelayanan maintenance dan support terbaik</li><li class="mb-2"><i class="fas fa-check-circle me-2 text-white"></i>Membangun kemitraan jangka panjang dengan kepercayaan tinggi</li><li class="mb-2"><i class="fas fa-check-circle me-2 text-white"></i>Mengembangkan SDM profesional dan berpengalaman</li><li class="mb-2"><i class="fas fa-check-circle me-2 text-white"></i>Berkontribusi pada pembangunan infrastruktur Indonesia</li></ul>' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company Values Section -->
<section class="values-section py-5" style="background: var(--dark-card);">
    <div class="container">
        <div class="section-header text-center mb-5">
            <div class="section-badge">
                <i class="fas fa-gem"></i>
                <span>Nilai-Nilai Perusahaan</span>
            </div>
            <h2 class="section-title">Prinsip yang Kami Junjung</h2>
            <p class="section-subtitle">
                Nilai-nilai fundamental yang menjadi landasan dalam setiap aktivitas bisnis kami
            </p>
        </div>

        <div class="row equal-height">
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow" style="background: var(--dark-bg); color: var(--text-light);">
                    <div class="card-body text-center p-4">
                        <div class="value-icon mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(45deg, var(--primary-color), var(--accent-color)); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-bullseye fa-2x text-white"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-white-important">Fokus Kualitas</h4>
                        <p class="text-white-important">
                            Setiap unit alat berat melalui inspeksi ketat dan 
                            perawatan berkala untuk memastikan performa optimal 
                            serta keamanan operasional dalam setiap proyek.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow" style="background: var(--dark-bg); color: var(--text-light);">
                    <div class="card-body text-center p-4">
                        <div class="value-icon mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(45deg, #10b981, #059669); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-shield-alt fa-2x text-white"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-white-important">Kepercayaan Klien</h4>
                        <p class="text-white-important">
                            Membangun hubungan jangka panjang dengan klien melalui 
                            kepercayaan yang kokoh menjadi prioritas utama dalam 
                            setiap layanan yang kami berikan.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow" style="background: var(--dark-bg); color: var(--text-light);">
                    <div class="card-body text-center p-4">
                        <div class="value-icon mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(45deg, #f59e0b, #d97706); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-rocket fa-2x text-white"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-white-important">Inovasi Berkelanjutan</h4>
                        <p class="text-white-important">
                            Terus mengupgrade teknologi dan menyediakan solusi inovatif untuk 
                            meningkatkan efisiensi dan keamanan operasional proyek konstruksi.
                        </p>
                    </div>
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
            <h2 class="cta-title">Wujudkan Visi Proyek Anda Bersama Kami</h2>
            <p class="cta-subtitle">
                Dengan visi dan misi yang jelas, kami siap menjadi mitra terpercaya 
                untuk mewujudkan kesuksesan proyek konstruksi Anda
            </p>
            <div class="cta-actions">
                <a href="{{ route('contact') }}" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-phone me-2"></i>Hubungi Sekarang
                </a>
                <a href="{{ route('contact') }}" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-tools me-2"></i>Lihat Katalog
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
