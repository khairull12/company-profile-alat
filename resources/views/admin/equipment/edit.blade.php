@extends('admin.layouts.app')

@section('title', 'Edit Alat Berat')
@section('page-title', 'Edit Alat Berat')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Form Edit Alat Berat</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.equipment.update', $equipment) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Alat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $equipment->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-control @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $equipment->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                               id="brand" name="brand" value="{{ old('brand', $equipment->brand) }}">
                        @error('brand')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control @error('model') is-invalid @enderror" 
                               id="model" name="model" value="{{ old('model', $equipment->model) }}">
                        @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="manufacture_year" class="form-label">Tahun Produksi</label>
                        <input type="number" class="form-control @error('manufacture_year') is-invalid @enderror" 
                               id="manufacture_year" name="manufacture_year" value="{{ old('manufacture_year', $equipment->manufacture_year) }}" 
                               min="1900" max="{{ date('Y') }}">
                        @error('manufacture_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="price_per_day" class="form-label">Harga per Hari (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('price_per_day') is-invalid @enderror" 
                               id="price_per_day" name="price_per_day" value="{{ old('price_per_day', $equipment->price_per_day) }}" 
                               min="0" step="0.01" required>
                        @error('price_per_day')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                               id="stock" name="stock" value="{{ old('stock', $equipment->stock) }}" min="0" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4" required>{{ old('description', $equipment->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            @if($equipment->images)
                <div class="mb-3">
                    <label class="form-label">Gambar Saat Ini</label>
                    <div class="row">
                        @foreach($equipment->images as $image)
                            <div class="col-md-3 mb-2">
                                <img src="{{ asset($image) }}" class="img-thumbnail" style="height: 100px; object-fit: cover; width: 100%;">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <div class="mb-3">
                <label for="images" class="form-label">Gambar Alat Baru (Opsional)</label>
                <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                       id="images" name="images[]" accept="image/*" multiple>
                <div class="form-text">Pilih gambar baru untuk mengganti yang lama (maks 2MB per gambar)</div>
                @error('images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="specifications" class="form-label">Spesifikasi</label>
                <textarea class="form-control @error('specifications') is-invalid @enderror" 
                          id="specifications" name="specifications" rows="5" 
                          placeholder="Masukkan spesifikasi, satu per baris. Contoh:&#10;Engine Power: 200 HP&#10;Operating Weight: 20 Ton&#10;Bucket Capacity: 1.5 m³&#10;Max Digging Depth: 6.5 m">{{ old('specifications', is_array($equipment->specifications) ? implode("\n", array_map(fn($k, $v) => "$k: $v", array_keys($equipment->specifications), $equipment->specifications)) : $equipment->specifications) }}</textarea>
                <div class="form-text">Masukkan spesifikasi satu per baris dengan format: <strong>Nama: Nilai</strong></div>
                @error('specifications')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', $equipment->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Aktif
                    </label>
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.equipment.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update Alat</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Image preview functionality
document.getElementById('images').addEventListener('change', function(e) {
    const files = e.target.files;
    let preview = document.getElementById('image-preview');
    
    if (!preview) {
        preview = document.createElement('div');
        preview.id = 'image-preview';
        preview.className = 'row mt-2';
        e.target.parentNode.appendChild(preview);
    }
    
    preview.innerHTML = '';
    
    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'col-md-3 mb-2';
                div.innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail" style="height: 100px; object-fit: cover; width: 100%;">
                    <small class="d-block text-muted text-truncate">${file.name}</small>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        }
    });
});

// Price formatting
document.getElementById('price_per_day').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^\d]/g, '');
    if (value) {
        // Format as currency
        e.target.setAttribute('data-raw-value', value);
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const requiredFields = ['name', 'category_id', 'price_per_day', 'stock', 'description'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Mohon lengkapi semua field yang wajib diisi (*)');
    }
});
</script>
@endpush
