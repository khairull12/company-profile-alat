@extends('layouts.main')

@section('title', 'Kontak')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold">Hubungi Kami</h1>
                <p class="lead">Siap membantu kebutuhan alat berat Anda</p>
                <div class="hr-divider"></div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title text-primary mb-4">Informasi Kontak</h3>
                            
                            <div class="contact-info">
                                <div class="d-flex mb-3">
                                    <div class="icon-box me-3">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                    </div>
                                    <div>
                                        <h6>Alamat</h6>
                                        <p class="text-muted">{{ $settings['company_address'] ?? 'Alamat Perusahaan' }}</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-3">
                                    <div class="icon-box me-3">
                                        <i class="fas fa-phone text-primary"></i>
                                    </div>
                                    <div>
                                        <h6>Telepon</h6>
                                        <p class="text-muted">{{ $settings['company_phone'] ?? 'Nomor Telepon' }}</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-3">
                                    <div class="icon-box me-3">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </div>
                                    <div>
                                        <h6>Email</h6>
                                        <p class="text-muted">{{ $settings['company_email'] ?? 'Email Perusahaan' }}</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-3">
                                    <div class="icon-box me-3">
                                        <i class="fas fa-globe text-primary"></i>
                                    </div>
                                    <div>
                                        <h6>Website</h6>
                                        <p class="text-muted">{{ $settings['company_website'] ?? 'Website Perusahaan' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title text-primary mb-4">Kirim Pesan</h3>
                            
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control" id="phone">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subjek</label>
                                    <input type="text" class="form-control" id="subject" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="message" class="form-label">Pesan</label>
                                    <textarea class="form-control" id="message" rows="5" required></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-box {
    width: 40px;
    height: 40px;
    background: rgba(37, 99, 235, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.hr-divider {
    width: 60px;
    height: 3px;
    background: var(--primary-color);
    margin: 0 auto;
}
</style>
@endsection
