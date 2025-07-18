@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Stats Cards -->
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title">Total Alat</h6>
                        <h3 class="mb-0">{{ $totalEquipment }}</h3>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-tools fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title">Total Kategori</h6>
                        <h3 class="mb-0">{{ $totalCategories }}</h3>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-tags fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title">Alat Tersedia</h6>
                        <h3 class="mb-0">{{ $availableEquipment }}</h3>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title">Total User</h6>
                        <h3 class="mb-0">{{ $totalUsers }}</h3>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Alat Populer</h5>
            </div>
            <div class="card-body">
                @forelse($popularEquipment as $equipment)
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $equipment->name }}</h6>
                            <p class="text-muted mb-0">{{ $equipment->category->name }}</p>
                            <small class="text-muted">Stok: {{ $equipment->stock }} unit</small>
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
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistik Kategori</h5>
            </div>
            <div class="card-body">
                @foreach($categories as $category)
                    <div class="mb-3">
                        <h6 class="mb-1">{{ $category->name }}</h6>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ ($category->equipment_count / $totalEquipment) * 100 }}%">
                                {{ $category->equipment_count }} Alat
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Alat Berat
                        </a>
                    </div>

                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-info w-100">
                            <i class="fas fa-cog mr-2"></i>
                            Pengaturan Website
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-warning w-100">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
