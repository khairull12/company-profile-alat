@extends('admin.layouts.app')

@section('title', 'Laporan & Analitik')
@section('page-title', 'Laporan & Analitik')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-chart-line me-2"></i>Filter Laporan
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" 
                               value="{{ $startDate }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="end_date" 
                               value="{{ $endDate }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Alat</label>
                        <select class="form-control" name="equipment_id">
                            <option value="">Semua Alat</option>
                            @foreach($equipment as $item)
                                <option value="{{ $item->id }}" 
                                        {{ $equipmentId == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">User</label>
                        <select class="form-control" name="user_id">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                        {{ $userId == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.reports.export') }}?{{ request()->getQueryString() }}" 
                       class="btn btn-success">
                        <i class="fas fa-download me-2"></i>Export CSV
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Alat</h5>
                <h3 class="mb-0">{{ $totalEquipment }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Alat Tersedia</h5>
                <h3 class="mb-0">{{ $availableEquipment }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">Alat Aktif</h5>
                <h3 class="mb-0">{{ $activeEquipment }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Total Kategori</h5>
                <h3 class="mb-0">{{ $categories->count() }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Performance Chart -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-chart-bar me-2"></i>Performance Bulanan
        </h5>
    </div>
    <div class="card-body">
        <canvas id="monthlyChart" height="100"></canvas>
    </div>
</div>

<!-- Analytics Cards -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tools me-2"></i>Alat Paling Populer
                </h5>
            </div>
            <div class="card-body">
                @forelse($equipmentUsage as $usage)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <strong>{{ $usage['equipment']->name }}</strong><br>
                            <small class="text-muted">{{ $usage['equipment']->category->name }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary">{{ $usage['total_views'] }} views</span><br>
                            <small class="text-muted">Availability: {{ $usage['availability_rate'] }}%</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>User Paling Aktif
                </h5>
            </div>
            <div class="card-body">
                @forelse($userActivity as $activity)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <strong>{{ $activity['user']->name }}</strong><br>
                            <small class="text-muted">{{ $activity['user']->email }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success">{{ $activity['total_visits'] }} visits</span><br>
                            <small class="text-muted">Score: {{ $activity['engagement_score'] }}%</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Categories Analytics -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-tags me-2"></i>Analisis Kategori
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-3 mb-3">
                    <div class="card border-left-primary">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        {{ $category->name }}
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $category->equipment_count }} Alat
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tools fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Equipment Details Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-table me-2"></i>Detail Equipment
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Brand</th>
                        <th>Stok</th>
                        <th>Harga Sewa</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($equipment as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category->name ?? '-' }}</td>
                            <td>{{ $item->brand ?? '-' }}</td>
                            <td>{{ $item->stock }} unit</td>
                            <td>Rp {{ number_format($item->rental_price, 0, ',', '.') }}</td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data equipment</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: @json($monthlyStats->pluck('month')),
            datasets: [{
                label: 'Equipment Ditambahkan',
                data: @json($monthlyStats->pluck('equipment_added')),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }, {
                label: 'User Terdaftar',
                data: @json($monthlyStats->pluck('users_registered')),
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.1
            }, {
                label: 'Total Inquiries',
                data: @json($monthlyStats->pluck('total_inquiries')),
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Performance Bulanan'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
@endsection
