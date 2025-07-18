<div class="card equipment-card h-100">
    <div class="position-relative overflow-hidden">
        @if($item->first_image)
            <img src="{{ asset($item->first_image) }}" 
                 class="card-img-top equipment-image" 
                 alt="{{ $item->name }}"
                 style="height: 220px; object-fit: cover; transition: transform 0.4s ease;">
        @else
            <div class="card-img-top equipment-image placeholder-image d-flex align-items-center justify-content-center"
                 style="height: 220px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
                <i class="fas fa-tools fa-3x" style="color: #64748b;"></i>
            </div>
        @endif
        
        <!-- Overlay gradient for better text readability -->
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0) 50%, rgba(0,0,0,0.2) 100%);"></div>
        
        <!-- Price Badge -->
        <div class="position-absolute top-0 end-0 m-3">
            <span class="badge px-3 py-2 rounded-3 shadow-sm" 
                  style="background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%); color: white; font-weight: 600; font-size: 0.85rem;">
                Rp {{ number_format($item->price_per_day, 0, ',', '.') }}/hari
            </span>
        </div>
        
        <!-- Status Badge -->
        <div class="position-absolute top-0 start-0 m-3">
            @if($item->stock > 0)
                <span class="badge px-3 py-2 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; font-weight: 600;">
                    <i class="fas fa-check-circle me-1"></i>Tersedia
                </span>
            @else
                <span class="badge px-3 py-2 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; font-weight: 600;">
                    <i class="fas fa-times-circle me-1"></i>Tidak Tersedia
                </span>
            @endif
        </div>
    </div>
    
    <div class="card-body d-flex flex-column p-4">
        <!-- Category Badge -->
        <div class="mb-3">
            <span class="badge rounded-pill px-3 py-2" 
                  style="background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%); color: white; font-weight: 500; font-size: 0.8rem;">
                <i class="fas fa-tag me-1"></i>{{ $item->category->name }}
            </span>
        </div>
        
        <!-- Equipment Name -->
        <h5 class="card-title fw-bold mb-3" style="color: var(--text-light); line-height: 1.3;">{{ $item->name }}</h5>
        
        <!-- Description -->
        <p class="card-text flex-grow-1 mb-3" style="color: var(--text-light); opacity: 0.9; line-height: 1.5;">
            {{ Str::limit($item->description, 100) }}
        </p>
        
        <!-- Specifications Card -->
        @if($item->specifications && is_array($item->specifications))
            <div class="mb-3 p-3 rounded-3" style="background: rgba(148, 163, 184, 0.1); border-left: 4px solid var(--primary-color);">
                <h6 class="mb-2" style="color: var(--text-light); font-size: 0.9rem; font-weight: 600;">
                    <i class="fas fa-cogs me-1" style="color: var(--primary-color);"></i>Spesifikasi
                </h6>
                <div class="row g-2">
                    @foreach(array_slice($item->specifications, 0, 2) as $key => $value)
                        <div class="col-6">
                            <div class="p-2 rounded-2" style="background: rgba(255, 255, 255, 0.05);">
                                <small class="d-block" style="color: var(--primary-color); font-weight: 600; font-size: 0.7rem; text-transform: uppercase;">
                                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                                </small>
                                <small class="d-block" style="color: var(--text-light); font-weight: 500;">
                                    {{ $value }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Equipment Details Grid -->
        <div class="row mb-3 g-2">
            <div class="col-4">
                <div class="text-center p-2 rounded-2" style="background: rgba(255, 255, 255, 0.05);">
                    <small class="d-block" style="color: var(--primary-color); font-weight: 600; font-size: 0.7rem; text-transform: uppercase;">Brand</small>
                    <small class="fw-semibold d-block" style="color: var(--text-light); font-size: 0.8rem;">{{ $item->brand ?? 'N/A' }}</small>
                </div>
            </div>
            <div class="col-4">
                <div class="text-center p-2 rounded-2" style="background: rgba(255, 255, 255, 0.05);">
                    <small class="d-block" style="color: var(--primary-color); font-weight: 600; font-size: 0.7rem; text-transform: uppercase;">Model</small>
                    <small class="fw-semibold d-block" style="color: var(--text-light); font-size: 0.8rem;">{{ $item->model ?? 'N/A' }}</small>
                </div>
            </div>
            <div class="col-4">
                <div class="text-center p-2 rounded-2" style="background: rgba(255, 255, 255, 0.05);">
                    <small class="d-block" style="color: var(--primary-color); font-weight: 600; font-size: 0.7rem; text-transform: uppercase;">Tahun</small>
                    <small class="fw-semibold d-block" style="color: var(--text-light); font-size: 0.8rem;">{{ $item->manufacture_year ?? 'N/A' }}</small>
                </div>
            </div>
        </div>
        
        <!-- Stock Info Card -->
        <div class="mb-3 p-3 rounded-3 d-flex justify-content-between align-items-center" 
             style="background: rgba(148, 163, 184, 0.1); border: 1px solid rgba(148, 163, 184, 0.2);">
            <div class="d-flex align-items-center">
                <i class="fas fa-cubes me-2" style="color: var(--primary-color);"></i>
                <span style="color: var(--text-light); font-weight: 500;">Stok Tersedia</span>
            </div>
            <span class="badge px-3 py-2 rounded-pill {{ $item->stock > 5 ? 'bg-success' : ($item->stock > 0 ? 'bg-warning' : 'bg-danger') }}" 
                  style="font-weight: 600;">
                {{ $item->stock }} Unit
            </span>
        </div>
        
        <!-- Action Buttons -->
        <div class="mt-auto">
            <div class="d-grid gap-2">
                <a href="{{ route('equipment.show', $item) }}" 
                   class="btn btn-outline-light btn-sm fw-semibold py-2 rounded-3 transition-all" 
                   style="border: 2px solid var(--primary-color); color: var(--primary-color); transition: all 0.3s ease;">
                    <i class="fas fa-eye me-2"></i>Lihat Detail
                </a>
                @if($item->stock > 0)
                    <a href="tel:{{ config('company.phone', '+62123456789') }}" 
                       class="btn btn-sm fw-semibold py-2 rounded-3 shadow-sm"
                       style="background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%); color: white; border: none; transition: all 0.3s ease;">
                        <i class="fas fa-phone me-2"></i>Hubungi Sekarang
                    </a>
                @else
                    <button class="btn btn-secondary btn-sm fw-semibold py-2 rounded-3" disabled>
                        <i class="fas fa-times me-2"></i>Stok Habis
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.equipment-card {
    background: var(--dark-card);
    border: 1px solid rgba(148, 163, 184, 0.15);
    border-radius: 1rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    min-height: 580px;
    display: flex;
    flex-direction: column;
}

.equipment-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border-color: var(--primary-color);
}

.equipment-card .card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
    min-height: 360px;
}

.equipment-card .card-text {
    flex-grow: 1;
    margin-bottom: 1rem;
}

.equipment-card:hover .equipment-image {
    transform: scale(1.1);
}

.equipment-card .btn-outline-light:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.equipment-card .btn:not(.btn-outline-light):not(:disabled):hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

.transition-all {
    transition: all 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .equipment-card {
        min-height: 520px;
    }
    
    .equipment-card .card-body {
        min-height: 320px;
        padding: 1.25rem;
    }
}

@media (max-width: 576px) {
    .equipment-card {
        min-height: 480px;
    }
    
    .equipment-card .card-body {
        min-height: 280px;
        padding: 1rem;
    }
}
</style>
