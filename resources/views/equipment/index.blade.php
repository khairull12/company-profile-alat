@extends('layouts.main')

@section('title', 'Katalog Equipment')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-4">Katalog Alat Berat</h1>
                <p class="lead mb-4">Pilihan lengkap alat berat berkualitas untuk kebutuhan konstruksi Anda</p>
            </div>
        </div>
    </div>
</section>

<!-- Filter and Content Section -->
<section class="py-5">
<div class="container>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
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

    <!-- Stats Section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $equipment->total() }}</h3>
                    <p class="mb-0">Total Equipment</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $equipment->where('stock', '>', 0)->count() }}</h3>
                    <p class="mb-0">Tersedia</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $categories->count() }}</h3>
                    <p class="mb-0">Kategori</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">Rp {{ number_format($equipment->where('stock', '>', 0)->avg('price_per_day'), 0, ',', '.') }}</h3>
                    <p class="mb-0">Rata-rata Harga</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment Grid -->
    <div class="row">
        @forelse($equipment as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card equipment-card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        @if($item->images && count($item->images) > 0)
                            <img src="{{ asset($item->images[0]) }}" class="card-img-top equipment-image" alt="{{ $item->name }}">
                        @else
                            <img src="https://via.placeholder.com/350x200/2563eb/ffffff?text={{ urlencode($item->name) }}" 
                                 class="card-img-top equipment-image" alt="{{ $item->name }}">
                        @endif
                        
                        <!-- Status Badge - Kiri Atas -->
                        <div class="position-absolute" style="top: 8px; left: 8px; z-index: 5;">
                            @if($item->stock > 0)
                                <span class="badge bg-success status-badge-improved">
                                    <i class="fas fa-check"></i>
                                    <span class="ms-1">{{ $item->stock }}</span>
                                </span>
                            @else
                                <span class="badge bg-danger status-badge-improved">
                                    <i class="fas fa-times"></i>
                                    <span class="ms-1">0</span>
                                </span>
                            @endif
                        </div>
                        
                        <!-- Price Badge - Kanan Atas -->
                        <div class="position-absolute" style="top: 8px; right: 8px; z-index: 5;">
                            <div class="price-badge-compact">
                                Rp {{ number_format($item->price_per_day / 1000, 0) }}K/hari
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <!-- Title -->
                        <h5 class="card-title fw-bold mb-2">{{ $item->name }}</h5>
                        
                        <!-- Brand & Model Info -->
                        <div class="equipment-meta mb-2">
                            <span class="text-muted">
                                <i class="fas fa-industry me-1"></i>{{ $item->brand }}
                            </span>
                            @if($item->model)
                                <span class="text-muted ms-2">{{ $item->model }}</span>
                            @endif
                            @if($item->manufacture_year)
                                <span class="badge bg-light text-dark ms-2">({{ $item->manufacture_year }})</span>
                            @endif
                        </div>
                        
                        <!-- Description -->
                        <p class="card-text text-muted small mb-3 flex-grow-1">
                            {{ Str::limit($item->description, 80) }}
                        </p>
                        
                        <!-- Category & Stock Info -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary category-badge">{{ $item->category->name }}</span>
                            <small class="text-muted">
                                <i class="fas fa-cubes me-1"></i>Stok: {{ $item->stock }}
                            </small>
                        </div>
                        
                        <!-- Specifications (if exists) -->
                        @if($item->specifications && is_array($item->specifications))
                            <div class="equipment-specs mb-3">
                                @foreach(array_slice($item->specifications, 0, 2) as $key => $value)
                                    <small class="d-block text-muted">
                                        <strong>{{ ucfirst($key) }}:</strong> {{ $value }}
                                    </small>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="card-footer bg-white border-0 pt-0">
                        <div class="d-grid gap-2">
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="{{ route('equipment.show', $item) }}" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                </div>
                                <div class="col-6">
                                    @if($item->stock > 0)
                                        @auth
                                            <a href="{{ route('bookings.create', $item) }}" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-calendar me-1"></i>Booking
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-sign-in-alt me-1"></i>Login
                                            </a>
                                        @endauth
                                    @else
                                        <button class="btn btn-secondary btn-sm w-100" disabled>
                                            <i class="fas fa-ban me-1"></i>Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-tools fa-4x text-muted"></i>
                    </div>
                    <h3 class="text-muted mb-3">Belum Ada Equipment</h3>
                    <p class="text-muted mb-4">Katalog equipment sedang dalam proses penambahan atau tidak ada equipment yang sesuai dengan filter Anda.</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('equipment.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-refresh me-1"></i>Reset Filter
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-primary">
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
</section>

@endsection

@push('styles')
<style>
.equipment-card {
    transition: all 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
    max-width: 100%;
}

.equipment-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

/* Responsive adjustments for smaller cards */
@media (max-width: 576px) {
    .equipment-card .card-body {
        padding: 0.75rem;
    }
    
    .equipment-image {
        height: 160px;
    }
}

@media (min-width: 992px) {
    .equipment-card {
        min-height: 420px;
    }
}

.equipment-image {
    height: 180px;
    object-fit: cover;
    width: 100%;
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

/* Responsive pagination */
@media (max-width: 768px) {
    .pagination .page-item .page-link {
        padding: 8px 12px;
        min-width: 36px;
        height: 36px;
        font-size: 0.8rem;
    }
    
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        padding: 8px 16px;
    }
    
    .pagination-container {
        padding: 15px;
    }
}

@media (max-width: 576px) {
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .pagination .page-item {
        margin: 2px;
    }
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
