@extends('admin.layouts.app')

@section('title', 'Pengaturan Statistik & Prestasi')
@section('page-title', 'Pengaturan Statistik & Prestasi')

@section('content')
<div class="row">
    <!-- Navigation Breadcrumb -->
    <div class="col-12 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.settings.index') }}" class="text-decoration-none">
                        <i class="fas fa-cog me-1"></i>Pengaturan
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    <i class="fas fa-chart-line me-1"></i>Statistik & Prestasi
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); color: white;">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="card-title mb-2 fw-bold">
                            <i class="fas fa-chart-line me-2"></i>Pengaturan Statistik & Prestasi
                        </h4>
                        <p class="card-text mb-0 opacity-75">
                            Kelola data statistik dan prestasi perusahaan yang ditampilkan di halaman utama website
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('home') }}" target="_blank" class="btn btn-light me-2">
                            <i class="fas fa-eye me-1"></i>Preview Website
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="col-12 mb-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Statistics Form -->
    <form action="{{ route('admin.settings.statistics.update') }}" method="POST" id="statisticsForm">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Total Alat Berat -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-tools me-2"></i>Total Alat Berat
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="total_equipment" class="form-label fw-bold">Nilai Statistik</label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('total_equipment') is-invalid @enderror" 
                                   id="total_equipment" 
                                   name="total_equipment" 
                                   value="{{ old('total_equipment', $statistics->where('key', 'total_equipment')->first()->value ?? '200+') }}"
                                   placeholder="contoh: 200+"
                                   onkeyup="updatePreview('total_equipment', 'preview-total-equipment')">
                            @error('total_equipment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted">
                                <strong><i class="fas fa-info-circle me-1"></i>Deskripsi:</strong> 
                                Unit tersedia siap beroperasi
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Proyek Selesai -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-project-diagram me-2"></i>Proyek Selesai
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="completed_projects" class="form-label fw-bold">Nilai Statistik</label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('completed_projects') is-invalid @enderror" 
                                   id="completed_projects" 
                                   name="completed_projects" 
                                   value="{{ old('completed_projects', $statistics->where('key', 'completed_projects')->first()->value ?? '750+') }}"
                                   placeholder="contoh: 750+"
                                   onkeyup="updatePreview('completed_projects', 'preview-completed-projects')">
                            @error('completed_projects')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted">
                                <strong><i class="fas fa-info-circle me-1"></i>Deskripsi:</strong> 
                                Proyek berhasil diselesaikan
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kepuasan Klien -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-star me-2"></i>Kepuasan Klien
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="client_satisfaction" class="form-label fw-bold">Nilai Statistik</label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('client_satisfaction') is-invalid @enderror" 
                                   id="client_satisfaction" 
                                   name="client_satisfaction" 
                                   value="{{ old('client_satisfaction', $statistics->where('key', 'client_satisfaction')->first()->value ?? '99%') }}"
                                   placeholder="contoh: 99%"
                                   onkeyup="updatePreview('client_satisfaction', 'preview-client-satisfaction')">
                            @error('client_satisfaction')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted">
                                <strong><i class="fas fa-info-circle me-1"></i>Deskripsi:</strong> 
                                Tingkat kepuasan pelanggan
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tahun Pengalaman -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-info text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-calendar-alt me-2"></i>Pengalaman
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="years_experience" class="form-label fw-bold">Nilai Statistik</label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('years_experience') is-invalid @enderror" 
                                   id="years_experience" 
                                   name="years_experience" 
                                   value="{{ old('years_experience', $statistics->where('key', 'years_experience')->first()->value ?? '15+') }}"
                                   placeholder="contoh: 15+"
                                   onkeyup="updatePreview('years_experience', 'preview-years-experience')">
                            @error('years_experience')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="bg-light p-3 rounded">
                            <small class="text-muted">
                                <strong><i class="fas fa-info-circle me-1"></i>Deskripsi:</strong> 
                                Tahun melayani industri
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-eye me-2 text-primary"></i>Preview Statistik Real-time
                        </h6>
                        <small class="text-muted">Lihat bagaimana statistik akan tampil di website</small>
                    </div>
                    <div class="card-body" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white;">
                        <div class="row text-center">
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="p-4 rounded" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="fas fa-tools fa-3x text-primary mb-3"></i>
                                    <h4 class="fw-bold text-primary mb-2" id="preview-total-equipment">{{ $statistics->where('key', 'total_equipment')->first()->value ?? '200+' }}</h4>
                                    <p class="mb-1 fw-bold">Total Alat Berat</p>
                                    <small class="text-muted">Unit tersedia siap beroperasi</small>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="p-4 rounded" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="fas fa-project-diagram fa-3x text-success mb-3"></i>
                                    <h4 class="fw-bold text-success mb-2" id="preview-completed-projects">{{ $statistics->where('key', 'completed_projects')->first()->value ?? '750+' }}</h4>
                                    <p class="mb-1 fw-bold">Proyek Selesai</p>
                                    <small class="text-muted">Proyek berhasil diselesaikan</small>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="p-4 rounded" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="fas fa-star fa-3x text-warning mb-3"></i>
                                    <h4 class="fw-bold text-warning mb-2" id="preview-client-satisfaction">{{ $statistics->where('key', 'client_satisfaction')->first()->value ?? '99%' }}</h4>
                                    <p class="mb-1 fw-bold">Kepuasan Klien</p>
                                    <small class="text-muted">Tingkat kepuasan pelanggan</small>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="p-4 rounded" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="fas fa-calendar-alt fa-3x text-info mb-3"></i>
                                    <h4 class="fw-bold text-info mb-2" id="preview-years-experience">{{ $statistics->where('key', 'years_experience')->first()->value ?? '15+' }}</h4>
                                    <p class="mb-1 fw-bold">Pengalaman</p>
                                    <small class="text-muted">Tahun melayani industri</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Perubahan akan langsung terlihat di website setelah disimpan
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function updatePreview(inputId, previewId) {
    const inputValue = document.getElementById(inputId).value;
    const previewElement = document.getElementById(previewId);
    
    if (previewElement) {
        previewElement.textContent = inputValue || '0';
    }
}

// Auto-save functionality (optional)
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('statisticsForm');
    const inputs = form.querySelectorAll('input[type="text"]');
    
    // Add loading state for save button
    form.addEventListener('submit', function() {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        submitBtn.disabled = true;
        
        // Re-enable after 3 seconds (in case of error)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });
});
</script>

<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}
</style>
@endsection
