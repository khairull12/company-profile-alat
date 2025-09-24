@extends('admin.layouts.app')

@section('title', 'Buat Booking Baru')
@section('page-title', 'Buat Booking Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Form Booking Baru</h5>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
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

        <form action="{{ route('admin.bookings.store') }}" method="POST">
            @csrf
            
            <!-- Customer Information -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="fw-bold text-primary border-bottom pb-2">
                        <i class="fas fa-user me-2"></i>Informasi Customer
                    </h6>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Customer <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required placeholder="Nama Customer">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Kontak <span class="text-danger">*</span></label>
                        <input type="text" name="contact_name" class="form-control" value="{{ old('contact_name') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email') }}">
                    </div>
                </div>
            </div>

            <!-- Equipment & Rental Details -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="fw-bold text-primary border-bottom pb-2">
                        <i class="fas fa-tools me-2"></i>Detail Rental
                    </h6>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Alat Berat <span class="text-danger">*</span></label>
                        <select name="equipment_id" class="form-select" required id="equipment-select">
                            <option value="">Pilih Alat Berat</option>
                            @foreach($equipment as $item)
                                <option value="{{ $item->id }}" 
                                        data-price="{{ $item->price_per_day }}"
                                        {{ old('equipment_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} - {{ $item->category->name ?? '' }}
                                    (Rp {{ number_format($item->price_per_day, 0, ',', '.') }}/hari)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required id="start-date">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required id="end-date">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Alamat Pengiriman</label>
                        <textarea name="delivery_address" class="form-control" rows="2">{{ old('delivery_address') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Hidden fields for calculated values -->
            <input type="hidden" name="rental_cost" value="0">
            <input type="hidden" name="total_cost" value="0">

            <!-- Calculation Summary -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-light border-primary">
                        <div class="card-body">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="fas fa-calculator me-2"></i>Ringkasan Biaya
                            </h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td class="fw-semibold">Harga per hari:</td>
                                            <td class="text-end"><span id="price-per-day" class="fw-bold text-primary">Rp 0</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Durasi sewa:</td>
                                            <td class="text-end"><span id="duration" class="fw-bold">0 hari</span></td>
                                        </tr>
                                        <tr class="border-top border-2">
                                            <td class="fw-bold h6 text-primary">TOTAL KESELURUHAN:</td>
                                            <td class="text-end"><span id="grand-total" class="fw-bold h5 text-primary">Rp 0</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Hidden inputs untuk menyimpan nilai calculated -->
                            <input type="hidden" name="duration_days" id="hidden-duration">
                            <input type="hidden" name="daily_rate" id="hidden-daily-rate">
                            <input type="hidden" name="total_amount" id="hidden-total-amount">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="fw-bold text-primary border-bottom pb-2">
                        <i class="fas fa-sticky-note me-2"></i>Catatan
                    </h6>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Catatan Customer</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea name="admin_notes" class="form-control" rows="3">{{ old('admin_notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Simpan Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const equipmentSelect = document.getElementById('equipment-select');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');

    // Set minimum dates
    const today = new Date().toISOString().split('T')[0];
    startDate.min = today;
    
    startDate.addEventListener('change', function() {
        endDate.min = this.value;
        if (endDate.value && endDate.value < this.value) {
            endDate.value = this.value;
        }
        calculateTotal();
        showCalculationFeedback();
    });

    endDate.addEventListener('change', function() {
        calculateTotal();
        showCalculationFeedback();
    });
    
    equipmentSelect.addEventListener('change', function() {
        calculateTotal();
        showCalculationFeedback();
        
        // Auto-populate related fields if equipment is selected
        if (this.value) {
            document.querySelector('.card.bg-light.border-primary').classList.add('border-success');
            document.querySelector('.card.bg-light.border-primary').classList.remove('border-warning');
        }
    });

    function calculateTotal() {
        const selectedOption = equipmentSelect.options[equipmentSelect.selectedIndex];
        const pricePerDay = parseFloat(selectedOption.dataset.price) || 0;
        
        // Calculate duration
        let duration = 0;
        if (startDate.value && endDate.value) {
            const start = new Date(startDate.value);
            const end = new Date(endDate.value);
            duration = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
        }

        // Calculate costs (simplified - no additional costs)
        const rentalSubtotal = pricePerDay * duration;
        const additionalCosts = 0; // No additional costs anymore
        const grandTotal = rentalSubtotal;

        // Update display with smooth animation
        updateDisplayValue('price-per-day', formatCurrency(pricePerDay));
        updateDisplayValue('duration', duration + ' hari');
        updateDisplayValue('grand-total', formatCurrency(grandTotal));
        
        // Auto-fill the main cost fields (hidden from user but used for form submission)
        document.querySelector('[name="rental_cost"]').value = rentalSubtotal;
        document.querySelector('[name="total_cost"]').value = grandTotal;
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount);
    }

    function updateDisplayValue(elementId, newValue) {
        const element = document.getElementById(elementId);
        if (element) {
            // Add smooth color transition
            element.style.transition = 'color 0.3s ease';
            element.style.color = '#28a745';
            element.textContent = newValue;
            
            setTimeout(() => {
                element.style.color = '';
            }, 300);
        }
    }

    function showCalculationFeedback() {
        const equipmentValue = equipmentSelect.value;
        const startValue = startDate.value;
        const endValue = endDate.value;
        const calculationCard = document.querySelector('.card.bg-light.border-primary');
        
        if (equipmentValue && startValue && endValue) {
            calculationCard.classList.remove('border-primary', 'border-warning');
            calculationCard.classList.add('border-success');
            
            // Show success message
            showToast('Perhitungan otomatis berhasil!', 'success');
        } else {
            calculationCard.classList.remove('border-success');
            calculationCard.classList.add('border-warning');
        }
    }

    function showToast(message, type = 'info') {
        // Simple toast notification
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 300px;';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 3000);
    }

    // Form validation before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!equipmentSelect.value) {
            e.preventDefault();
            showToast('Silakan pilih unit/alat terlebih dahulu!', 'warning');
            equipmentSelect.focus();
            return false;
        }
        
        if (!startDate.value || !endDate.value) {
            e.preventDefault();
            showToast('Lengkapi tanggal mulai dan selesai sewa!', 'warning');
            if (!startDate.value) startDate.focus();
            else endDate.focus();
            return false;
        }
        
        if (new Date(startDate.value) > new Date(endDate.value)) {
            e.preventDefault();
            showToast('Tanggal mulai tidak boleh lebih besar dari tanggal selesai!', 'danger');
            startDate.focus();
            return false;
        }

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
        submitBtn.disabled = true;
        
        showToast('Sedang menyimpan booking...', 'info');
        return true;
    });

    // Initial calculation and setup
    calculateTotal();
    
    // Add helpful placeholder text
    if (equipmentSelect.options.length <= 1) {
        equipmentSelect.innerHTML = '<option value="">-- Tidak ada unit tersedia --</option>';
        equipmentSelect.disabled = true;
        showToast('Tidak ada unit/alat yang tersedia untuk disewa saat ini.', 'warning');
    }
});
</script>
@endpush
