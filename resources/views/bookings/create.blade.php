@extends('layouts.app')

@section('title', 'Booking - ' . $equipment->name)

@section('content')
<!-- Hero Section -->
<div class="booking-hero bg-gradient-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('equipment.index') }}" class="text-white-50">Katalog</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('equipment.show', $equipment->id) }}" class="text-white-50">{{ $equipment->name }}</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Booking</li>
                    </ol>
                </nav>
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-calendar-plus me-3"></i>Booking Alat Berat
                </h1>
                <p class="lead mb-0">Pesan {{ $equipment->name }} dengan mudah dan cepat</p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="booking-icon">
                    <i class="fas fa-tools fa-5x opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Equipment Summary Card -->
        <div class="col-lg-4">
            <div class="card shadow-lg border-0 sticky-top equipment-card">                    <div class="position-relative">
                        @if($equipment->images && count($equipment->images) > 0)
                            <img src="{{ asset('storage/' . $equipment->images[0]) }}" 
                                 class="card-img-top equipment-image" alt="{{ $equipment->name }}">
                        @elseif($equipment->image)
                            <img src="{{ asset('storage/' . $equipment->image) }}" 
                                 class="card-img-top equipment-image" alt="{{ $equipment->name }}">
                        @else
                            <img src="https://via.placeholder.com/400x250/007bff/ffffff?text={{ urlencode($equipment->name) }}" 
                                 class="card-img-top equipment-image" alt="{{ $equipment->name }}">
                        @endif
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-success fs-6">{{ $equipment->stock > 0 ? 'Tersedia' : 'Habis' }}</span>
                        </div>
                    </div>
                
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="category-icon me-3">
                            <i class="fas fa-cog fa-2x text-primary"></i>
                        </div>                            <div>
                                <h5 class="card-title fw-bold mb-1">{{ $equipment->name }}</h5>
                                <span class="badge bg-light text-dark">{{ $equipment->category->name ?? 'Kategori' }}</span>
                            </div>
                    </div>
                    
                    <div class="price-card mb-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="price-item">
                                    <i class="fas fa-money-bill-wave text-success mb-2"></i>
                                    <div class="price-label">Harga/Hari</div>
                                    <div class="price-value">Rp {{ number_format($equipment->price_per_day, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="price-item">
                                    <i class="fas fa-warehouse text-info mb-2"></i>
                                    <div class="price-label">Stok</div>
                                    <div class="price-value">{{ $equipment->stock }} Unit</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Booking Summary -->
                    <div class="booking-summary-card" id="bookingSummary" style="display: none;">
                        <div class="card bg-light border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-calculator me-2"></i>Ringkasan Booking
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="summary-row">
                                    <span>Tanggal Mulai</span>
                                    <span id="summaryStartDate" class="fw-bold">-</span>
                                </div>
                                <div class="summary-row">
                                    <span>Tanggal Selesai</span>
                                    <span id="summaryEndDate" class="fw-bold">-</span>
                                </div>
                                <div class="summary-row">
                                    <span>Durasi</span>
                                    <span id="summaryDuration" class="fw-bold text-info">-</span>
                                </div>
                                <hr class="my-3">
                                <div class="summary-row total-row">
                                    <span class="fw-bold">Total Biaya</span>
                                    <span id="summaryTotal" class="fw-bold text-success fs-5">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 booking-form-card">
                <div class="card-header bg-gradient-success text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-edit fa-2x me-3"></i>
                        <div>
                            <h5 class="mb-1">Form Pemesanan</h5>
                            <small class="opacity-75">Lengkapi data booking Anda</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    @if($errors->any())
                    <div class="alert alert-danger alert-modern">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                            <div>
                                <h6 class="alert-heading mb-2">Terjadi Kesalahan!</h6>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">
                        
                        <!-- Date Selection -->
                        <div class="form-section">
                            <h6 class="section-title">
                                <i class="fas fa-calendar-alt me-2"></i>Pilih Tanggal Sewa
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control form-control-modern" id="start_date" 
                                               name="start_date" value="{{ old('start_date') }}" required min="{{ date('Y-m-d') }}">
                                        <label for="start_date">
                                            <i class="fas fa-play me-2"></i>Tanggal Mulai
                                        </label>
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="fas fa-info-circle me-1"></i>Pilih tanggal mulai penyewaan
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control form-control-modern" id="end_date" 
                                               name="end_date" value="{{ old('end_date') }}" required min="{{ date('Y-m-d') }}">
                                        <label for="end_date">
                                            <i class="fas fa-stop me-2"></i>Tanggal Selesai
                                        </label>
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="fas fa-info-circle me-1"></i>Pilih tanggal selesai penyewaan
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Notes Section -->
                        <div class="form-section">
                            <h6 class="section-title">
                                <i class="fas fa-sticky-note me-2"></i>Catatan & Kebutuhan Khusus
                            </h6>
                            <div class="form-floating">
                                <textarea class="form-control form-control-modern" id="notes" name="notes" 
                                          style="height: 120px" placeholder="Catatan...">{{ old('notes') }}</textarea>
                                <label for="notes">Catatan tambahan (opsional)</label>
                            </div>
                            <div class="form-text mt-2">
                                <i class="fas fa-lightbulb me-1"></i>Contoh: Butuh operator berpengalaman, lokasi proyek di Jakarta Selatan, dll.
                            </div>
                        </div>
                        
                        <!-- Terms & Conditions -->
                        <div class="form-section">
                            <h6 class="section-title">
                                <i class="fas fa-shield-alt me-2"></i>Syarat & Ketentuan
                            </h6>
                            <div class="terms-card">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="term-item">
                                            <i class="fas fa-credit-card text-primary"></i>
                                            <span>Pembayaran sebelum pengiriman</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="term-item">
                                            <i class="fas fa-shield-alt text-info"></i>
                                            <span>Deposit keamanan diperlukan</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="term-item">
                                            <i class="fas fa-gas-pump text-warning"></i>
                                            <span>Biaya BBM ditanggung penyewa</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="term-item">
                                            <i class="fas fa-clock text-danger"></i>
                                            <span>Pembatalan min. 24 jam</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-check agreement-check">
                                <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms" required>
                                <label class="form-check-label" for="agree_terms">
                                    Saya menyetujui <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal" class="text-decoration-none">syarat dan ketentuan</a> yang berlaku <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <a href="{{ route('equipment.show', $equipment->id) }}" class="btn btn-outline-secondary btn-lg w-100">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success btn-lg w-100 btn-submit" {{ $equipment->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-paper-plane me-2"></i>
                                        {{ $equipment->stock <= 0 ? 'Stok Habis' : 'Kirim Permintaan Booking' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="termsModalLabel">
                    <i class="fas fa-file-contract me-2"></i>Syarat dan Ketentuan Penyewaan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="terms-content">
                    <div class="term-section">
                        <h6><i class="fas fa-info-circle me-2 text-primary"></i>1. Ketentuan Umum</h6>
                        <p>Dengan melakukan booking, Anda setuju untuk mematuhi semua syarat dan ketentuan yang berlaku dalam penyewaan alat berat.</p>
                    </div>
                    
                    <div class="term-section">
                        <h6><i class="fas fa-credit-card me-2 text-success"></i>2. Pembayaran</h6>
                        <ul>
                            <li>Pembayaran harus dilakukan sebelum alat dikirim ke lokasi</li>
                            <li>Deposit keamanan sebesar 20% dari total biaya sewa wajib dibayar</li>
                            <li>Pembayaran dapat dilakukan melalui transfer bank atau tunai</li>
                            <li>Biaya transportasi alat sudah termasuk dalam harga sewa</li>
                        </ul>
                    </div>
                    
                    <div class="term-section">
                        <h6><i class="fas fa-tools me-2 text-warning"></i>3. Penggunaan Alat</h6>
                        <ul>
                            <li>Alat harus digunakan sesuai dengan fungsi dan spesifikasinya</li>
                            <li>Dilarang menggunakan alat di luar area yang telah disepakati</li>
                            <li>Operator harus memiliki sertifikat yang valid dan berpengalaman</li>
                            <li>Jam operasional maksimal 8 jam per hari</li>
                        </ul>
                    </div>
                    
                    <div class="term-section">
                        <h6><i class="fas fa-exclamation-triangle me-2 text-danger"></i>4. Tanggung Jawab</h6>
                        <ul>
                            <li>Kerusakan akibat kesalahan operasional menjadi tanggung jawab penyewa</li>
                            <li>Penyewa wajib menjaga keamanan dan kondisi alat</li>
                            <li>Kehilangan alat atau parts menjadi tanggung jawab penuh penyewa</li>
                            <li>Asuransi alat ditanggung oleh pemilik alat</li>
                        </ul>
                    </div>
                    
                    <div class="term-section">
                        <h6><i class="fas fa-ban me-2 text-info"></i>5. Pembatalan</h6>
                        <ul>
                            <li>Pembatalan minimal 24 jam sebelum tanggal mulai sewa</li>
                            <li>Biaya pembatalan 10% dari total biaya sewa</li>
                            <li>Pembatalan mendadak akan dikenakan denda sesuai ketentuan</li>
                            <li>Force majeure tidak dikenakan biaya pembatalan</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="document.getElementById('agree_terms').checked = true;">
                    <i class="fas fa-check me-2"></i>Saya Setuju
                </button>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<style>
/* Hero Section */
.booking-hero {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 50%, #28a745 100%);
    position: relative;
    overflow: hidden;
}

.booking-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M0 100h100L50 0z" fill="rgba(255,255,255,0.1)"/></svg>') center/cover;
    opacity: 0.1;
}

.breadcrumb-dark .breadcrumb-item a {
    color: rgba(255,255,255,0.7);
    text-decoration: none;
}

.breadcrumb-dark .breadcrumb-item a:hover {
    color: white;
}

/* Equipment Card */
.equipment-card {
    border-radius: 20px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.equipment-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.equipment-image {
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.equipment-card:hover .equipment-image {
    transform: scale(1.05);
}

.category-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.price-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    padding: 20px;
    border: 2px solid #dee2e6;
}

.price-item {
    text-align: center;
    padding: 15px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: transform 0.2s ease;
}

.price-item:hover {
    transform: translateY(-2px);
}

.price-label {
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 5px;
}

.price-value {
    font-size: 1.1rem;
    font-weight: bold;
    color: #495057;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
}

.total-row {
    border-top: 2px solid #28a745;
    padding-top: 15px;
    margin-top: 10px;
}

/* Booking Form */
.booking-form-card {
    border-radius: 20px;
    overflow: hidden;
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.form-section {
    margin-bottom: 2.5rem;
    padding: 25px;
    background: #f8f9fa;
    border-radius: 15px;
    border-left: 5px solid #007bff;
}

.section-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 20px;
    font-size: 1.1rem;
}

.form-control-modern {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control-modern:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.15);
    transform: translateY(-2px);
}

.form-floating > .form-control-modern {
    padding: 1rem 0.75rem;
}

.form-floating > label {
    padding: 1rem 0.75rem;
    color: #6c757d;
    font-weight: 500;
}

.terms-card {
    background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 20px;
}

.term-item {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    background: rgba(255,255,255,0.8);
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 500;
}

.term-item i {
    margin-right: 12px;
    font-size: 1.2rem;
}

.agreement-check {
    background: white;
    padding: 20px;
    border-radius: 12px;
    border: 2px solid #dee2e6;
}

.agreement-check .form-check-input {
    width: 1.2rem;
    height: 1.2rem;
    border-radius: 4px;
    border: 2px solid #28a745;
}

.agreement-check .form-check-input:checked {
    background-color: #28a745;
    border-color: #28a745;
}

.action-buttons {
    margin-top: 30px;
    padding-top: 25px;
    border-top: 3px solid #e9ecef;
}

.btn-submit {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    border-radius: 12px;
    padding: 12px 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.btn-submit:hover {
    background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
}

.btn-outline-secondary {
    border: 2px solid #6c757d;
    border-radius: 12px;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    transform: translateY(-2px);
}

/* Alert Modern */
.alert-modern {
    border: none;
    border-radius: 15px;
    border-left: 5px solid #dc3545;
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
}

/* Modal Enhancements */
.modal-content {
    border-radius: 20px;
}

.terms-content .term-section {
    margin-bottom: 25px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 12px;
    border-left: 4px solid #007bff;
}

.terms-content .term-section h6 {
    color: #495057;
    margin-bottom: 15px;
}

.terms-content ul {
    margin-bottom: 0;
}

.terms-content li {
    margin-bottom: 8px;
    padding-left: 5px;
}

/* Sticky positioning */
.sticky-top {
    top: 30px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .booking-hero {
        text-align: center;
    }
    
    .booking-hero .display-5 {
        font-size: 2rem;
    }
    
    .form-section {
        padding: 20px;
        margin-bottom: 2rem;
    }
    
    .equipment-card {
        margin-bottom: 2rem;
    }
    
    .sticky-top {
        position: relative !important;
        top: auto !important;
    }
}

/* Loading animation */
.btn-submit:disabled {
    background: #6c757d;
    cursor: not-allowed;
}

.btn-submit.loading::after {
    content: '';
    width: 16px;
    height: 16px;
    margin-left: 10px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    display: inline-block;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const bookingForm = document.getElementById('bookingForm');
    const submitBtn = bookingForm.querySelector('.btn-submit');
    const pricePerDay = {{ $equipment->price_per_day }};
    
    // Enhanced booking summary update
    function updateBookingSummary() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        
        if (startDate && endDate && startDate <= endDate) {
            const timeDiff = endDate.getTime() - startDate.getTime();
            const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
            const totalPrice = daysDiff * pricePerDay;
            
            // Format dates
            const startFormatted = startDate.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long', 
                day: 'numeric'
            });
            const endFormatted = endDate.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            document.getElementById('summaryStartDate').textContent = startFormatted;
            document.getElementById('summaryEndDate').textContent = endFormatted;
            document.getElementById('summaryDuration').textContent = daysDiff + ' hari';
            document.getElementById('summaryTotal').textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
            
            // Show summary with animation
            const summaryElement = document.getElementById('bookingSummary');
            summaryElement.style.display = 'block';
            summaryElement.style.opacity = '0';
            summaryElement.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                summaryElement.style.transition = 'all 0.3s ease';
                summaryElement.style.opacity = '1';
                summaryElement.style.transform = 'translateY(0)';
            }, 100);
        } else {
            document.getElementById('bookingSummary').style.display = 'none';
        }
    }
    
    // Enhanced date validation
    function validateDates() {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        
        // Start date validation
        if (startDate < today) {
            showNotification('Tanggal mulai tidak boleh kurang dari hari ini', 'error');
            startDateInput.value = '';
            return false;
        }
        
        // End date validation
        if (endDate < startDate) {
            showNotification('Tanggal selesai harus setelah tanggal mulai', 'error');
            endDateInput.value = '';
            return false;
        }
        
        return true;
    }
    
    // Show notification
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.floating-notification');
        existingNotifications.forEach(notif => notif.remove());
        
        const notification = document.createElement('div');
        notification.className = `floating-notification alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            border-radius: 12px;
            border: none;
        `;
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'check-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 4 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 4000);
    }
    
    // Update end date minimum when start date changes
    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
        if (endDateInput.value && endDateInput.value < this.value) {
            endDateInput.value = this.value;
        }
        if (validateDates()) {
            updateBookingSummary();
        }
    });
    
    endDateInput.addEventListener('change', function() {
        if (validateDates()) {
            updateBookingSummary();
        }
    });
    
    // Enhanced form validation
    bookingForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const agreeTerms = document.getElementById('agree_terms');
        
        let isValid = true;
        
        // Validate dates
        if (!startDate || !endDate) {
            showNotification('Mohon pilih tanggal mulai dan selesai', 'error');
            isValid = false;
        } else if (startDate > endDate) {
            showNotification('Tanggal selesai harus setelah tanggal mulai', 'error');
            isValid = false;
        }
        
        // Validate terms agreement
        if (!agreeTerms.checked) {
            showNotification('Anda harus menyetujui syarat dan ketentuan', 'error');
            agreeTerms.focus();
            isValid = false;
        }
        
        if (isValid) {
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim Booking...';
            
            // Simulate API call delay
            setTimeout(() => {
                this.submit();
            }, 1000);
        }
    });
    
    // Enhanced input animations
    const inputs = document.querySelectorAll('.form-control-modern');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });
    
    // Terms modal enhancement
    const termsModal = document.getElementById('termsModal');
    if (termsModal) {
        termsModal.addEventListener('shown.bs.modal', function() {
            // Add some entrance animation
            const modalBody = this.querySelector('.modal-body');
            modalBody.style.opacity = '0';
            modalBody.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                modalBody.style.transition = 'all 0.3s ease';
                modalBody.style.opacity = '1';
                modalBody.style.transform = 'translateY(0)';
            }, 100);
        });
    }
    
    // Smooth scroll to form validation errors
    function scrollToError(element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
        
        // Highlight the field
        element.style.transition = 'all 0.3s ease';
        element.style.borderColor = '#dc3545';
        element.style.boxShadow = '0 0 0 0.25rem rgba(220, 53, 69, 0.25)';
        
        setTimeout(() => {
            element.style.borderColor = '';
            element.style.boxShadow = '';
        }, 2000);
    }
    
    // Initialize page
    updateBookingSummary();
    showNotification('Silakan lengkapi form booking Anda', 'info');
});
</script>
@endsection
