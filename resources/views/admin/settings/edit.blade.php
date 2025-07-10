@extends('admin.layouts.app')

@section('title', 'Edit Pengaturan')
@section('page-title', 'Edit Pengaturan - ' . ucfirst(str_replace('_', ' ', $group)))

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Edit Pengaturan {{ ucfirst(str_replace('_', ' ', $group)) }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.update', $group) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            @foreach($settings as $setting)
                <div class="mb-3">
                    <label for="{{ $setting->key }}" class="form-label">
                        {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                    </label>
                    
                    @if($setting->type == 'text')
                        <input type="text" 
                               class="form-control @error('settings.' . $setting->key) is-invalid @enderror" 
                               id="{{ $setting->key }}" 
                               name="settings[{{ $setting->key }}]" 
                               value="{{ old('settings.' . $setting->key, $setting->value) }}">
                    
                    @elseif($setting->type == 'textarea')
                        <textarea class="form-control @error('settings.' . $setting->key) is-invalid @enderror" 
                                  id="{{ $setting->key }}" 
                                  name="settings[{{ $setting->key }}]" 
                                  rows="4">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                    
                    @elseif($setting->type == 'editor')
                        <textarea class="form-control @error('settings.' . $setting->key) is-invalid @enderror" 
                                  id="{{ $setting->key }}" 
                                  name="settings[{{ $setting->key }}]" 
                                  rows="6">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                    
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
                                <small class="text-muted">Gambar saat ini</small>
                            </div>
                        @endif
                    @endif
                    
                    @error($setting->key)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
