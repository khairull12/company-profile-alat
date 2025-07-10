@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')
@section('page-title', 'Pengaturan Website')

@section('content')
<div class="row">
    @foreach($settings as $group => $groupSettings)
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ ucfirst(str_replace('_', ' ', $group)) }}</h5>
                    <a href="{{ route('admin.settings.edit', $group) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                </div>
                <div class="card-body">
                    @foreach($groupSettings as $setting)
                        <div class="mb-3">
                            <strong>{{ ucfirst(str_replace('_', ' ', $setting->key)) }}:</strong>
                            <br>
                            @if($setting->type == 'image')
                                @if($setting->value)
                                    <img src="{{ asset('storage/' . $setting->value) }}" 
                                         alt="{{ $setting->key }}" 
                                         class="img-thumbnail mt-2" 
                                         style="max-width: 200px;">
                                @else
                                    <span class="text-muted">Belum ada gambar</span>
                                @endif
                            @else
                                <span class="text-muted">{{ $setting->value ?: 'Belum diisi' }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Tambah Pengaturan Baru</h5>
        <a href="{{ route('admin.settings.create') }}" class="btn btn-success">
            <i class="fas fa-plus mr-1"></i> Tambah Pengaturan
        </a>
    </div>
</div>
@endsection
