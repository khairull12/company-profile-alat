@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-2">Selamat Datang di Admin Dashboard!</h4>
                        <p class="mb-0 opacity-75">Kelola sistem rental alat berat dengan mudah dan efisien</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="text-white-50">
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted">Total Alat</h6>
                        <h3 class="mb-0 text-primary">{{ $totalEquipment }}</h3>
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> 
                            {{ $recentEquipment->count() }} terbaru
                        </small>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-tools fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted">Total Kategori</h6>
                        <h3 class="mb-0 text-success">{{ $totalCategories }}</h3>
                        <small class="text-info">
                            <i class="fas fa-layer-group"></i>
                            Kategori aktif
                        </small>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-tags fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted">Alat Tersedia</h6>
                        <h3 class="mb-0 text-warning">{{ $availableEquipment }}</h3>
                        <small class="text-muted">
                            <i class="fas fa-warehouse"></i>
                            Siap disewa
                        </small>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-check-circle fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title text-muted">Total User</h6>
                        <h3 class="mb-0 text-info">{{ $totalUsers }}</h3>
                        <small class="text-primary">
                            <i class="fas fa-user-friends"></i>
                            Pengguna terdaftar
                        </small>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts & Analytics -->
<div class="row mb-4">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>Trend Penambahan Alat (12 Bulan Terakhir)
                </h5>
            </div>
            <div class="card-body">
                <canvas id="equipmentChart" height="100"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>Distribusi Kategori
                </h5>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Equipment Lists -->
<div class="row mb-4">
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="fas fa-star me-2"></i>Alat Populer
                </h5>
            </div>
            <div class="card-body">
                @forelse($popularEquipment as $equipment)
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-2 rounded">
                                <i class="fas fa-tools text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ $equipment->name }}</h6>
                            <p class="text-muted mb-0">{{ $equipment->category->name }}</p>
                            <small class="text-success">Stok: {{ $equipment->stock }} unit</small>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="badge bg-{{ $equipment->is_active ? 'success' : 'secondary' }}">
                                {{ $equipment->is_active ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada alat berat</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>Alat Terbaru
                </h5>
            </div>
            <div class="card-body">
                @forelse($recentEquipment as $equipment)
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-2 rounded">
                                <i class="fas fa-plus text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ $equipment->name }}</h6>
                            <p class="text-muted mb-0">{{ $equipment->category->name }}</p>
                            <small class="text-info">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $equipment->created_at->format('d M Y') }}
                            </small>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="badge bg-info">Baru</span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada alat berat</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Category Stats -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="fas fa-layer-group me-2"></i>Statistik Kategori
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($categories as $category)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <div class="mb-2">
                                        <i class="fas fa-tools fa-2x text-primary"></i>
                                    </div>
                                    <h6 class="card-title">{{ $category->name }}</h6>
                                    <h4 class="text-primary mb-0">{{ $category->equipment_count }}</h4>
                                    <small class="text-muted">Alat tersedia</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="fas fa-rocket me-2"></i>Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-2 col-md-4 mb-3">
                        <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Alat Baru
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-3">
                        <a href="{{ route('admin.equipment.index') }}" class="btn btn-success w-100">
                            <i class="fas fa-list me-2"></i>
                            Kelola Alat
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-3">
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-calendar-check me-2"></i>
                            Kelola Booking
                        </a>
                    </div>
                    <!-- Laporan Bulanan button removed -->
                    <div class="col-lg-2 col-md-4 mb-3">
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-dark w-100">
                            <i class="fas fa-cog me-2"></i>
                            Pengaturan Website
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Equipment trend chart
    const equipmentCtx = document.getElementById('equipmentChart').getContext('2d');
    const equipmentChart = new Chart(equipmentCtx, {
        type: 'line',
        data: {
            labels: @json($monthlyEquipmentData->pluck('month')),
            datasets: [{
                label: 'Jumlah Alat Ditambahkan',
                data: @json($monthlyEquipmentData->pluck('count')),
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Category distribution chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: @json($categories->pluck('name')),
            datasets: [{
                data: @json($categories->pluck('equipment_count')),
                backgroundColor: [
                    '#667eea',
                    '#764ba2',
                    '#f093fb',
                    '#f5576c',
                    '#4facfe',
                    '#00f2fe',
                    '#43e97b',
                    '#38f9d7'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
@endsection
