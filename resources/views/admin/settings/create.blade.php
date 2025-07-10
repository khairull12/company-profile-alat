@extends('admin.layouts.app')

@section('title', 'Tambah Pengaturan')
@section('page-title', 'Tambah Pengaturan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Tambah Pengaturan Baru</h5>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="group" class="form-label">Grup Pengaturan</label>
                        <input type="text" class="form-control @error('group') is-invalid @enderror" 
                               id="group" name="group" value="{{ old('group') }}" 
                               placeholder="Contoh: company, contact, social">
                        @error('group')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="key" class="form-label">Kunci Pengaturan</label>
                        <input type="text" class="form-control @error('key') is-invalid @enderror" 
                               id="key" name="key" value="{{ old('key') }}" 
                               placeholder="Contoh: company_name, phone_number">
                        @error('key')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipe Input</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                            <option value="">Pilih Tipe Input</option>
                            <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="textarea" {{ old('type') == 'textarea' ? 'selected' : '' }}>Textarea</option>
                            <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image</option>
                            <option value="number" {{ old('type') == 'number' ? 'selected' : '' }}>Number</option>
                            <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="url" {{ old('type') == 'url' ? 'selected' : '' }}>URL</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="value" class="form-label">Nilai Default (Opsional)</label>
                        <input type="text" class="form-control @error('value') is-invalid @enderror" 
                               id="value" name="value" value="{{ old('value') }}" 
                               placeholder="Nilai default untuk pengaturan ini">
                        @error('value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
