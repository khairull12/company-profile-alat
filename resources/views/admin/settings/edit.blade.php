@extends('admin.layouts.app')

@section('title', 'Edit Pengaturan')
@section('page-title', 'Edit Pengaturan - ' . ucfirst(str_replace('_', ' ', $group)))

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Edit Pengaturan {{ ucfirst(str_replace('_', ' ', $group)) }}</h5>
            <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <h6>Terjadi kesalahan:</h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.settings.update', $group) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            @foreach($settings as $setting)
                <div class="mb-4">
                    <label for="{{ $setting->key }}" class="form-label fw-bold">
                        {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                        @if($setting->type == 'image')
                            <span class="text-muted">(Gambar)</span>
                        @endif
                    </label>
                    
                    @if($setting->type == 'text')
                        <input type="text" 
                               class="form-control @error('settings.' . $setting->key) is-invalid @enderror" 
                               id="{{ $setting->key }}" 
                               name="settings[{{ $setting->key }}]" 
                               value="{{ old('settings.' . $setting->key, $setting->value) }}"
                               placeholder="Masukkan {{ str_replace('_', ' ', $setting->key) }}">
                    
                    @elseif($setting->type == 'textarea')
                        <textarea class="form-control @error('settings.' . $setting->key) is-invalid @enderror" 
                                  id="{{ $setting->key }}" 
                                  name="settings[{{ $setting->key }}]" 
                                  rows="4"
                                  placeholder="Masukkan {{ str_replace('_', ' ', $setting->key) }}">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                    
                    @elseif($setting->type == 'editor')
                        <textarea class="form-control @error('settings.' . $setting->key) is-invalid @enderror" 
                                  id="{{ $setting->key }}" 
                                  name="settings[{{ $setting->key }}]" 
                                  rows="6"
                                  placeholder="Masukkan {{ str_replace('_', ' ', $setting->key) }}">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                    
                    @elseif($setting->type == 'image')
                        <input type="file" 
                               class="form-control @error('settings.' . $setting->key) is-invalid @enderror" 
                               id="{{ $setting->key }}" 
                               name="settings[{{ $setting->key }}]" 
                               accept="image/*">
                        @if($setting->value)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $setting->value) }}" 
                                     alt="{{ $setting->key }}" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px;">
                                <br>
                                <small class="text-muted">Gambar saat ini - Upload gambar baru untuk menggantinya</small>
                            </div>
                        @else
                            <small class="text-muted">Belum ada gambar yang diupload</small>
                        @endif
                    
                    @elseif($setting->type == 'email')
                        <input type="email" 
                               class="form-control @error('settings.' . $setting->key) is-invalid @enderror" 
                               id="{{ $setting->key }}" 
                               name="settings[{{ $setting->key }}]" 
                               value="{{ old('settings.' . $setting->key, $setting->value) }}"
                               placeholder="Masukkan email">
                    
                    @elseif($setting->type == 'url')
                        <input type="url" 
                               class="form-control @error('settings.' . $setting->key) is-invalid @enderror" 
                               id="{{ $setting->key }}" 
                               name="settings[{{ $setting->key }}]" 
                               value="{{ old('settings.' . $setting->key, $setting->value) }}"
                               placeholder="Masukkan URL">
                    
                    @else
                        <input type="text" 
                               class="form-control @error('settings.' . $setting->key) is-invalid @enderror" 
                               id="{{ $setting->key }}" 
                               name="settings[{{ $setting->key }}]" 
                               value="{{ old('settings.' . $setting->key, $setting->value) }}">
                    @endif
                    
                    @error('settings.' . $setting->key)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
