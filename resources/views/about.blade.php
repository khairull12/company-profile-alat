@extends('layouts.main')

@section('title', 'Tentang Kami')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold">{{ $settings['about_us_title'] ?? 'Tentang Kami' }}</h1>
                <div class="hr-divider"></div>
            </div>
            
            <div class="content">
                {!! $settings['about_us_content'] ?? 'Konten tentang kami akan ditampilkan di sini.' !!}
            </div>
        </div>
    </div>
</div>
@endsection
