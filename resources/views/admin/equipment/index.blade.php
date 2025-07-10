@extends('admin.layouts.app')

@section('title', 'Kelola Alat Berat')
@section('page-title', 'Kelola Alat Berat')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar Alat Berat</h5>
        <a href="{{ route('admin.equipment.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> Tambah Alat
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Harga/Hari</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($equipment as $item)
                        <tr>
                            <td>
                                @if($item->images && count($item->images) > 0)
                                    <img src="{{ asset('storage/' . $item->images[0]) }}" 
                                         alt="{{ $item->name }}" 
                                         class="img-thumbnail" 
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $item->name }}</strong><br>
                                <small class="text-muted">{{ $item->brand }} {{ $item->model }}</small>
                            </td>
                            <td>{{ $item->category->name }}</td>
                            <td>Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.equipment.show', $item) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.equipment.edit', $item) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.equipment.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus alat ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada alat berat</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $equipment->links() }}
    </div>
</div>
@endsection
