@extends('layouts.main')

@section('title', 'Visi & Misi')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold">Visi & Misi</h1>
                <div class="hr-divider"></div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title text-primary">{{ $settings['vision_title'] ?? 'Visi Kami' }}</h3>
                            <div class="content">
                                {!! $settings['vision_content'] ?? 'Visi perusahaan akan ditampilkan di sini.' !!}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title text-primary">{{ $settings['mission_title'] ?? 'Misi Kami' }}</h3>
                            <div class="content">
                                {!! $settings['mission_content'] ?? 'Misi perusahaan akan ditampilkan di sini.' !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
