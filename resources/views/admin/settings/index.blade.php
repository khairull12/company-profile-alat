@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')
@section('page-title', 'Pengaturan Website')

@section('content')
<div class="row">
    <!-- Quick Access Panel -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); color: white;">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>Akses Cepat Pengaturan
                </h5>
                <small class="opacity-75">Kelola pengaturan website dengan mudah</small>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.settings.statistics') }}" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm quick-access-card" style="transition: all 0.3s ease;">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-chart-line fa-3x text-primary"></i>
                                    </div>
                                    <h6 class="card-title fw-bold">Pengaturan Statistik</h6>
                                    <p class="card-text text-muted small">Kelola data statistik & prestasi perusahaan</p>
                                    <span class="badge bg-primary">Statistik</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.settings.edit', 'company') }}" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm quick-access-card">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-building fa-3x text-success"></i>
                                    </div>
                                    <h6 class="card-title fw-bold">Info Perusahaan</h6>
                                    <p class="card-text text-muted small">Data perusahaan, kontak & informasi umum</p>
                                    <span class="badge bg-success">Perusahaan</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.settings.edit', 'hero') }}" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm quick-access-card">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-home fa-3x text-info"></i>
                                    </div>
                                    <h6 class="card-title fw-bold">Hero Section</h6>
                                    <p class="card-text text-muted small">Banner utama & konten halaman depan</p>
                                    <span class="badge bg-info">Halaman Utama</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.settings.edit', 'vision') }}" class="text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm quick-access-card">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-eye fa-3x text-warning"></i>
                                    </div>
                                    <h6 class="card-title fw-bold">Visi & Misi</h6>
                                    <p class="card-text text-muted small">Visi, misi & nilai-nilai perusahaan</p>
                                    <span class="badge bg-warning">Visi Misi</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Layout Management -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="fas fa-palette me-2 text-primary"></i>Manajemen Layout & Tampilan
                </h5>
                <small class="text-muted">Preview dan kelola tampilan website</small>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-home fa-2x text-primary mb-3"></i>
                                <h6 class="card-title">Halaman Utama</h6>
                                <p class="card-text small text-muted">Hero, statistik, tentang kami</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Preview
                                    </a>
                                    <a href="{{ route('admin.settings.edit', 'hero') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-eye fa-2x text-warning mb-3"></i>
                                <h6 class="card-title">Visi & Misi</h6>
                                <p class="card-text small text-muted">Visi, misi, nilai perusahaan</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('vision-mission') }}" target="_blank" class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-eye me-1"></i>Preview
                                    </a>
                                    <a href="{{ route('admin.settings.edit', 'vision') }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-tools fa-2x text-secondary mb-3"></i>
                                <h6 class="card-title">Katalog Alat</h6>
                                <p class="card-text small text-muted">Daftar alat berat tersedia</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('equipment.index') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Preview
                                    </a>
                                    <a href="{{ route('admin.equipment.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-cogs me-1"></i>Kelola
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Groups -->
    <div class="row">
        @foreach($settings as $group => $groupSettings)
            @if($group !== 'statistics') {{-- Statistics has its own dedicated page --}}
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0 fw-bold">
                                <i class="fas fa-{{ $group === 'company' ? 'building' : ($group === 'hero' ? 'home' : ($group === 'vision' ? 'eye' : 'cog')) }} me-2 text-primary"></i>
                                {{ ucfirst(str_replace('_', ' ', $group)) }}
                            </h6>
                            <a href="{{ route('admin.settings.edit', $group) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($groupSettings) > 0)
                            @foreach($groupSettings->take(3) as $setting)
                                <div class="mb-3 pb-3 border-bottom border-light">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <strong class="text-dark d-block">{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</strong>
                                            @if($setting->type == 'image')
                                                @if($setting->value)
                                                    <img src="{{ asset('storage/' . $setting->value) }}" 
                                                         alt="{{ $setting->key }}" 
                                                         class="img-thumbnail mt-2" 
                                                         style="max-width: 120px; max-height: 80px; object-fit: cover;">
                                                @else
                                                    <span class="text-muted small">Belum ada gambar</span>
                                                @endif
                                            @else
                                                <span class="text-muted small">{{ Str::limit($setting->value ?: 'Belum diisi', 80) }}</span>
                                            @endif
                                        </div>
                                        <span class="badge bg-light text-dark ms-2">{{ ucfirst($setting->type) }}</span>
                                    </div>
                                </div>
                            @endforeach
                            @if(count($groupSettings) > 3)
                                <div class="text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-ellipsis-h me-1"></i>
                                        Dan {{ count($groupSettings) - 3 }} pengaturan lainnya
                                    </small>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada pengaturan dalam grup ini</p>
                                <a href="{{ route('admin.settings.create') }}" class="btn btn-outline-primary btn-sm mt-2">
                                    <i class="fas fa-plus me-1"></i>Tambah Pengaturan
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>

<!-- Add New Setting -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus-circle me-2 text-success"></i>Tambah Pengaturan Baru
                </h5>
                <small class="text-muted">Buat pengaturan kustom untuk kebutuhan spesifik</small>
            </div>
            <a href="{{ route('admin.settings.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Tambah Pengaturan
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <p class="text-muted mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Buat pengaturan baru untuk mengelola konten website Anda dengan lebih fleksibel. 
                    Anda dapat menambahkan teks, gambar, atau pengaturan lainnya sesuai kebutuhan.
                </p>
            </div>
            <div class="col-md-4 text-end">
                <div class="d-flex justify-content-end gap-2">
                    <span class="badge bg-light text-dark">Text</span>
                    <span class="badge bg-light text-dark">Image</span>
                    <span class="badge bg-light text-dark">Editor</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.quick-access-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.quick-access-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.card-header.bg-gradient {
    border: none;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endsection
