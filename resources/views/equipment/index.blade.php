@extends('layouts.main')

@section('title', 'Katalog Equipment')

@section('content')
<div class="catalog-page">
    <style>
        /* Override hero section untuk catalog page */
        .catalog-page .hero-section {
            background: linear-gradient(135deg, var(--dark-bg) 0%, #1e293b 50%, var(--primary-color) 100%) !important;
            color: white;
            padding: 1.5rem 0 !important;
            margin-bottom: 2rem;
            min-height: auto !important;
            overflow: visible !important;
            position: static !important;
        }
        
        .catalog-page .hero-section::before {
            display: none !important;
        }
        
        .catalog-page .hero-section h1 {
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
        }
        
        .catalog-page .hero-section p {
            color: rgba(255,255,255,0.9);
            font-size: 1rem;
            margin-bottom: 0;
        }
        
        /* Responsive hero section */
        @media (max-width: 768px) {
            .catalog-page .hero-section {
                padding: 1rem 0 !important;
            }
            
            .catalog-page .hero-section h1 {
                font-size: 2rem;
            }
            
            .catalog-page .hero-section p {
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 576px) {
            .catalog-page .hero-section {
                padding: 0.75rem 0 !important;
            }
            
            .catalog-page .hero-section h1 {
                font-size: 1.75rem;
            }
        }

        /* Dark theme for equipment catalog */
        .catalog-page {
            background-color: var(--dark-bg) !important;
            min-height: 100vh;
        }
        
        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .stats-title {
            color: var(--text-light);
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .stats-number {
            color: var(--text-light);
            font-weight: 600;
            font-size: 1.75rem;
        }
        
        .bg-warning {
            background-color: #f1c40f !important;
        }

/* Container and Layout */
.container {
    width: 100%;
    max-width: 1440px !important; /* Increased max-width */
    padding: 0 1rem;
}

@media (min-width: 1600px) {
    .container {
        max-width: 1600px !important;
    }
}

/* Enhanced Grid Layout */
.equipment-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
    padding: 0 1rem;
}

@media (max-width: 768px) {
    .equipment-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        padding: 0 0.5rem;
    }
}

@media (min-width: 1200px) {
    .equipment-grid {
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2.5rem;
    }
}

@media (min-width: 1400px) {
    .equipment-grid {
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 3rem;
    }
}

/* Card Styles */
.equipment-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 16px !important;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    background: var(--dark-card);
    color: var(--text-light);
    height: 100%;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(148, 163, 184, 0.1);
    width: 100%;
    max-width: 100%;
    margin: 0;
    position: relative;
}

.equipment-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    border-color: var(--primary-color);
    z-index: 10;
}

/* Additional card styling overrides */
.equipment-grid .equipment-card {
    width: 100%;
    max-width: 100%;
    margin: 0;
    position: relative;
}

.equipment-grid .equipment-card:hover {
    z-index: 10;
}

/* Ensure consistent card heights in grid */
.equipment-grid .card-body {
    min-height: 350px;
    display: flex;
    flex-direction: column;
}

/* Better spacing for card elements */
.equipment-grid .card-title {
    font-size: 1.1rem;
    line-height: 1.3;
    margin-bottom: 1rem;
}

.equipment-grid .card-text {
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

/* Image Container */
.equipment-image-container {
    position: relative;
    height: 200px;
    width: 100%;
    overflow: hidden;
    background: #f3f4f6;
    flex-shrink: 0;
}

.equipment-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.5s ease;
}

.equipment-card:hover .equipment-image {
    transform: scale(1.05);
}

.image-gradient-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0) 40%);
    pointer-events: none;
}

/* Card Content */
.card-body {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: 1.5rem !important;
    overflow: hidden;
    background: var(--dark-card);
}

.card-header-content {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1rem;
    flex-shrink: 0;
}

.equipment-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-light);
    line-height: 1.35;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    max-height: 3em;
}

.category-tag {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
    color: white;
    padding: 0.35rem 0.85rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    width: fit-content;
    flex-shrink: 0; /* Prevent shrinking */
}

/* Equipment Details */
.equipment-details {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.5rem;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 0.75rem;
    margin-bottom: 0.75rem;
    min-height: 60px;
    max-height: 80px;
    flex-shrink: 0;
    overflow: hidden;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8125rem;
    color: #4a5568;
    padding: 0.375rem 0.5rem;
    background: #f8fafc;
    border-radius: 6px;
    white-space: nowrap;
    overflow: hidden;
    transition: all 0.2s ease;
}

.detail-item:hover {
    background: #edf2f7;
    color: #2d3748;
}

.detail-item i {
    color: #4299e1;
    width: 16px;
    text-align: center;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.detail-item span {
    overflow: hidden;
    text-overflow: ellipsis;
    font-weight: 500;
}

/* Description */
.equipment-description {
    font-size: 0.875rem;
    line-height: 1.6;
    color: #4a5568;
    background: #f7fafc;
    padding: 0.75rem;
    border-radius: 8px;
    border-left: 3px solid #4299e1;
    margin-bottom: 0.75rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex-shrink: 0;
    min-height: 50px;
    max-height: 60px;
}

/* Specifications */
.equipment-specs {
    background: #f8fafc;
    border-radius: 8px;
    padding: 0.625rem;
    flex-shrink: 0;
    min-height: 70px;
    max-height: 85px;
    overflow: hidden;
}

.spec-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.375rem 0.5rem;
    background: white;
    border-radius: 6px;
    margin-bottom: 0.375rem;
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
}

.spec-row:hover {
    border-color: #4299e1;
    background: #f7fafc;
}

.spec-row:last-child {
    margin-bottom: 0;
}

.spec-key {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    color: #64748b;
    letter-spacing: 0.5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 45%;
}

.spec-value {
    font-size: 0.875rem;
    font-weight: 500;
    color: #0f172a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 55%;
    text-align: right;
    padding-left: 0.5rem;
}

/* Badges */
.equipment-badge {
    position: absolute;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 0.875rem;
    border-radius: 50px;
    font-size: 0.8125rem;
    font-weight: 500;
    z-index: 10;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
}

.status-badge-container {
    top: 16px;
    left: 16px;
}

.price-badge-container {
    top: 16px;
    right: 16px;
}

.badge-success {
    background: rgba(22, 163, 74, 0.95);
    color: white;
}

.badge-danger {
    background: rgba(220, 38, 38, 0.95);
    color: white;
}

.badge-primary {
    background: rgba(37, 99, 235, 0.95);
    color: white;
}

.equipment-badge i {
    font-size: 0.875rem;
    opacity: 0.9;
}

.equipment-badge i {
    font-size: 0.875rem;
}

/* Card Footer */
.card-footer {
    flex-shrink: 0;
    height: 65px; /* Fixed height */
    padding: 1rem !important;
    margin-top: auto;
}

.card-footer .btn {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    flex: 1;
}

/* Filter Section Styles */
.filter-card {
    background: var(--dark-card);
    border: 1px solid rgba(148, 163, 184, 0.1);
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    margin-bottom: 2rem;
}

.filter-card .card-body {
    padding: 1.5rem;
}

.filter-card .form-label {
    font-weight: 500;
    color: var(--text-light);
    margin-bottom: 0.5rem;
}

.filter-card .form-control,
.filter-card .form-select {
    border: 1px solid rgba(148, 163, 184, 0.2);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.9375rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    background: var(--dark-bg);
    color: var(--text-light);
}

.filter-card .form-control:focus,
.filter-card .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
    background: var(--dark-bg);
    color: var(--text-light);
}

.filter-card .input-group-text {
    background: var(--dark-bg);
    border: 1px solid rgba(148, 163, 184, 0.2);
    border-right: none;
    color: var(--text-light);
}

.filter-card .btn-primary {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    border-radius: 8px;
    background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
    border: none;
}

/* Stats Cards */
.stats-card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.2s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.12);
}

.stats-card .card-body {
    padding: 1.5rem !important;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    height: 100%;
}

.stats-card h3 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    letter-spacing: -0.025em;
    line-height: 1.2;
}

.stats-card p {
    font-size: 0.9375rem;
    opacity: 0.9;
    margin: 0;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.bg-primary {
    background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
}

.bg-success {
    background: linear-gradient(135deg, #059669, #10b981) !important;
}

.bg-info {
    background: linear-gradient(135deg, #0891b2, #06b6d4) !important;
}

.bg-warning {
    background: linear-gradient(135deg, #d97706, #f59e0b) !important;
}

/* Responsive Adjustments */
@media (min-width: 1400px) {
    .container {
        max-width: 1320px;
    }
}

@media (max-width: 1200px) {
    .equipment-image-container {
        height: 180px;
    }
    
    .card-body {
        padding: 1rem !important;
    }
    
    .equipment-title {
        font-size: 1.05rem;
    }
    
    .equipment-badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
}

@media (max-width: 992px) {
    .row {
        --bs-gutter-x: 1.5rem;
    }
    
    .equipment-image-container {
        height: 160px;
    }
    
    .stats-card h3 {
        font-size: 1.5rem;
    }
    
    .stats-card p {
        font-size: 0.875rem;
    }
    
    .card-body {
        padding: 0.875rem !important;
    }
}

@media (max-width: 768px) {
    .equipment-card {
        height: auto;
        min-height: 380px;
        max-height: 450px;
    }
    
    .equipment-image-container {
        height: 180px;
    }
    
    .equipment-details {
        gap: 0.375rem;
        min-height: 50px;
        max-height: 70px;
        grid-template-columns: 1fr;
    }
    
    .detail-item {
        font-size: 0.75rem;
        padding: 0.25rem 0.375rem;
    }
    
    .equipment-description {
        padding: 0.625rem;
        margin-bottom: 0.625rem;
        min-height: 45px;
        max-height: 55px;
    }
    
    .stats-card {
        margin-bottom: 0.5rem;
    }
    
    .stats-card .card-body {
        padding: 1.25rem !important;
    }
    
    .row-cols-sm-2 > * {
        width: 100%;
    }
    
    /* Improve filter form on mobile */
    .filter-card .col-md-4,
    .filter-card .col-md-3,
    .filter-card .col-md-2 {
        margin-bottom: 1rem;
    }
}

@media (max-width: 576px) {
    .equipment-grid-item {
        padding: 0.5rem;
    }
    
    .equipment-card {
        height: 400px;
    }
    
    .card-body {
        padding: 0.875rem !important;
    }
    
    .equipment-badge {
        font-size: 0.6875rem;
        padding: 0.25rem 0.5rem;
    }
    
    .spec-row {
        padding: 0.25rem 0.375rem;
    }
    
    .spec-key {
        font-size: 0.6875rem;
    }
    
    .spec-value {
        font-size: 0.8125rem;
    }
}

/* Filter Form Improvements */
.filter-card {
    margin-bottom: 2rem;
    border: 1px solid rgba(0,0,0,0.05);
}

.filter-card .card-body {
    padding: 1.5rem !important;
}

.filter-card .form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.625rem;
    font-size: 0.9375rem;
}

.filter-card .input-group {
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    border-radius: 8px;
    transition: all 0.2s ease;
}

.filter-card .input-group:focus-within {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}

.filter-card .input-group-text {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-right: none;
    padding: 0.625rem 0.875rem;
    color: #6b7280;
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
}

.filter-card .form-control,
.filter-card .form-select {
    border: 1px solid #e5e7eb;
    padding: 0.625rem 1rem;
    font-size: 0.9375rem;
    color: #111827;
    background-color: #ffffff;
    transition: all 0.2s ease;
}

.filter-card .form-control:focus,
.filter-card .form-select:focus {
    border-color: #3b82f6;
    box-shadow: none;
}

.filter-card .form-control::placeholder {
    color: #9ca3af;
}

.filter-card .btn-primary {
    padding: 0.625rem 1.25rem;
    font-weight: 500;
    border-radius: 8px;
    height: 42px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    border: none;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

.filter-card .btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.12);
    background: linear-gradient(135deg, #1d4ed8, #2563eb);
}

@media (max-width: 768px) {
    .filter-card .form-label {
        margin-bottom: 0.5rem;
    }
    
    .filter-card .row {
        margin: 0 -0.5rem;
    }
    
    .filter-card [class*="col-"] {
        padding: 0 0.5rem;
    }
    
    .filter-card .btn-primary {
        width: 100%;
        margin-top: 0.5rem;
    }
}

/* Override card heights for better layout */
.equipment-grid .equipment-card {
    min-height: 580px !important;
}

.equipment-grid .equipment-card .card-body {
    min-height: 360px !important;
    flex: 1 !important;
}

.equipment-grid .equipment-card .card-text {
    flex-grow: 1 !important;
}
</style>
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h1 class="fw-bold">Katalog Alat Berat</h1>
                <p>Pilihan lengkap alat berat berkualitas untuk kebutuhan konstruksi Anda</p>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="container py-4">
    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card filter-card">
                <div class="card-body">
                    <form method="GET" action="{{ route('equipment.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Cari Equipment</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" placeholder="Cari berdasarkan nama atau deskripsi...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="price_range" class="form-label">Rentang Harga</label>
                            <select class="form-select" id="price_range" name="price_range">
                                <option value="">Semua Harga</option>
                                <option value="0-500000" {{ request('price_range') == '0-500000' ? 'selected' : '' }}>
                                    < Rp 500.000
                                </option>
                                <option value="500000-1000000" {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>
                                    Rp 500.000 - 1.000.000
                                </option>
                                <option value="1000000-2000000" {{ request('price_range') == '1000000-2000000' ? 'selected' : '' }}>
                                    Rp 1.000.000 - 2.000.000
                                </option>
                                <option value="2000000+" {{ request('price_range') == '2000000+' ? 'selected' : '' }}>
                                    > Rp 2.000.000
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-1"></i>Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment Grid -->
    <div class="equipment-grid">
        @forelse($equipment as $item)
            @include('equipment._card', ['item' => $item])
        @empty
            <!-- Stats Section in Empty State -->
            <div class="col-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card stats-card bg-primary text-white">
                            <div class="card-body text-center">
                                <h3>{{ number_format($stats['total']) }}</h3>
                                <p>Total Equipment</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card bg-success text-white">
                            <div class="card-body text-center">
                            <div class="card-body text-center">
                                <h3>{{ number_format($stats['available']) }}</h3>
                                <p>Tersedia</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card bg-info text-white">
                            <div class="card-body text-center">
                                <h3>{{ number_format($stats['categories']) }}</h3>
                                <p>Kategori</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card bg-warning text-white">
                            <div class="card-body text-center">
                                <h3>{{ number_format($stats['avgPrice'], 0, ',', '.') }}</h3>
                                <p>Rata-rata Harga</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Empty State Message -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-tools fa-4x" style="color: var(--text-muted);"></i>
                    </div>
                    <h3 class="mb-3" style="color: var(--text-light);">Belum Ada Equipment</h3>
                    <p class="mb-4" style="color: var(--text-light);">Katalog equipment sedang dalam proses penambahan atau tidak ada equipment yang sesuai dengan filter Anda.</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('equipment.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-refresh me-1"></i>Reset Filter
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-primary" 
                           style="background: linear-gradient(45deg, var(--primary-color), var(--accent-color)); border: none;">
                            <i class="fas fa-home me-1"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Enhanced Pagination Section -->
    @if($equipment->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <div class="pagination-container">
                    <!-- Pagination info -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="pagination-info">
                            <span class="fw-semibold">{{ $equipment->firstItem() }}</span>
                            -
                            <span class="fw-semibold">{{ $equipment->lastItem() }}</span>
                            dari
                            <span class="fw-semibold">{{ $equipment->total() }}</span>
                            equipment
                        </div>
                        <div class="pagination-stats">
                            <small class="text-muted">
                                Halaman {{ $equipment->currentPage() }} dari {{ $equipment->lastPage() }}
                            </small>
                        </div>
                    </div>
                    
                    <!-- Enhanced pagination links -->
                    <div class="d-flex justify-content-center">
                        <nav aria-label="Equipment pagination">
                            {{ $equipment->appends(request()->query())->links('pagination::bootstrap-4', [
                                'previous' => '← Sebelumnya',
                                'next' => 'Selanjutnya →'
                            ]) }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
</div>

@endsection

@push('styles')
<style>
.equipment-card {
    transition: all 0.3s ease;
    border-radius: 16px;
    overflow: hidden;
    background: #ffffff;
}

.hover-shadow {
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.shadow-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

.equipment-image-wrapper {
    position: relative;
    overflow: hidden;
    height: 200px;
}

.equipment-image {
    height: 100%;
    width: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.equipment-card:hover .equipment-image {
    transform: scale(1.05);
}

/* Additional card styling overrides */
.equipment-grid .equipment-card {
    width: 100%;
    max-width: 100%;
    margin: 0;
    position: relative;
}

.equipment-grid .equipment-card:hover {
    z-index: 10;
}

/* Ensure consistent card heights in grid */
.equipment-grid .card-body {
    min-height: 350px;
    display: flex;
    flex-direction: column;
}

/* Better spacing for card elements */
.equipment-grid .card-title {
    font-size: 1.1rem;
    line-height: 1.3;
    margin-bottom: 1rem;
}

.equipment-grid .card-text {
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .equipment-image-wrapper {
        height: 180px;
    }
    
    .equipment-card .card-body {
        padding: 1rem;
    }
}

@media (min-width: 992px) {
    .equipment-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .equipment-card .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
}

.price-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(45deg, var(--accent-color), #f97316);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    z-index: 2;
}

.price-badge-compact {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 0.7rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    white-space: nowrap;
}

.status-badge {
    font-size: 0.7rem;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.category-badge {
    font-size: 0.75rem;
    padding: 4px 10px;
    border-radius: 15px;
    font-weight: 500;
}

.equipment-meta {
    font-size: 0.85rem;
    line-height: 1.4;
}

.equipment-specs {
    background-color: #f8f9fa;
    padding: 8px 12px;
    border-radius: 8px;
    border-left: 3px solid var(--primary-color);
}

.card-title {
    color: var(--text-dark);
    font-size: 1rem;
    line-height: 1.3;
}

.card-text {
    font-size: 0.85rem;
    line-height: 1.4;
}

.btn-sm {
    font-size: 0.8rem;
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: 500;
}

.card-footer {
    padding: 0.75rem;
}

/* Stats cards styling */
.card.bg-primary,
.card.bg-success,
.card.bg-info,
.card.bg-warning {
    border-radius: 12px;
    border: none;
}

.card.bg-warning {
    background: linear-gradient(45deg, #f59e0b, #f97316) !important;
}

.card.bg-info {
    background: linear-gradient(45deg, #06b6d4, #0891b2) !important;
}

.card.bg-success {
    background: linear-gradient(45deg, #10b981, #059669) !important;
}

.card.bg-primary {
    background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)) !important;
}

/* Filter card styling */
.card {
    border-radius: 12px;
}

/* Badge positioning improvements */
.position-absolute.top-0.start-0 {
    z-index: 3;
}

/* Enhanced Pagination Styling */
.pagination {
    --bs-pagination-padding-x: 0.75rem;
    --bs-pagination-padding-y: 0.5rem;
    --bs-pagination-font-size: 0.875rem;
    --bs-pagination-color: #374151;
    --bs-pagination-bg: #ffffff;
    --bs-pagination-border-width: 1px;
    --bs-pagination-border-color: #e5e7eb;
    --bs-pagination-border-radius: 0.75rem;
    --bs-pagination-hover-color: #ffffff;
    --bs-pagination-hover-bg: #667eea;
    --bs-pagination-hover-border-color: #667eea;
    --bs-pagination-focus-color: #ffffff;
    --bs-pagination-focus-bg: #667eea;
    --bs-pagination-focus-border-color: #667eea;
    --bs-pagination-disabled-color: #9ca3af;
    --bs-pagination-disabled-bg: #f9fafb;
    --bs-pagination-disabled-border-color: #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.pagination .page-item {
    margin: 0 2px;
}

.pagination .page-item .page-link {
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    color: #374151;
    font-weight: 500;
    padding: 10px 16px;
    transition: all 0.3s ease;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 44px;
    height: 44px;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    transform: translateY(-1px);
}

.pagination .page-item:hover .page-link {
    background: #667eea;
    border-color: #667eea;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
}

.pagination .page-item.disabled .page-link {
    background: #f9fafb;
    border-color: #e5e7eb;
    color: #9ca3af;
    cursor: not-allowed;
}

/* Enhanced Previous and Next buttons */
.pagination .page-item:first-child .page-link {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    color: #374151;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    position: relative;
    overflow: hidden;
}

.pagination .page-item:first-child .page-link:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transition: left 0.3s ease;
    z-index: -1;
}

.pagination .page-item:first-child:hover .page-link {
    color: white;
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.pagination .page-item:first-child:hover .page-link:before {
    left: 0;
}

.pagination .page-item:last-child .page-link {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    color: #374151;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    position: relative;
    overflow: hidden;
}

.pagination .page-item:last-child .page-link:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transition: left 0.3s ease;
    z-index: -1;
}

.pagination .page-item:last-child:hover .page-link {
    color: white;
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.pagination .page-item:last-child:hover .page-link:before {
    left: 0;
}

/* Custom pagination container */
.pagination-container {
    background: white;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
}

.pagination-info {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
}

/* Loading state untuk pagination */
.pagination-loading {
    opacity: 0.6;
    pointer-events: none;
}

.pagination-loading .page-link {
    position: relative;
}

.pagination-loading .page-link:after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 16px;
    height: 16px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
    transform: translate(-50%, -50%);
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}
</style>
@endpush
