@extends('admin.layouts.app')

@section('title', 'Edit Booking')
@section('page-title', 'Edit Booking #' . $booking->booking_number)

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Edit Booking #{{ $booking->booking_number }}</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-eye me-1"></i>Detail
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
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

        <!-- Status Alert -->
        <div class="alert alert-info d-flex align-items-center mb-4">
            <i class="fas fa-info-circle me-2"></i>
            <div>
                <strong>Status Booking:</strong> {!! $booking->getStatusBadge() !!}
                <br>
                <small class="text-muted">Dibuat: {{ $booking->created_at->format('d/m/Y H:i') }}</small>
            </div>
        </div>

        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
            @csrf
            @method('PUT')
            
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
                        <select name="user_id" class="form-select" required>
                            <option value="">Pilih Customer</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $booking->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Kontak <span class="text-danger">*</span></label>
                        <input type="text" name="contact_name" class="form-control" value="{{ $booking->contact_name }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ $booking->contact_phone }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ $booking->contact_email }}">
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
                                        {{ $booking->equipment_id == $item->id ? 'selected' : '' }}>
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
                        <input type="date" name="start_date" class="form-control" value="{{ $booking->start_date->format('Y-m-d') }}" required id="start-date">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control" value="{{ $booking->end_date->format('Y-m-d') }}" required id="end-date">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Alamat Pengiriman</label>
                        <textarea name="delivery_address" class="form-control" rows="2">{{ $booking->delivery_address }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Cost Details -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="fw-bold text-primary border-bottom pb-2">
                        <i class="fas fa-money-bill-wave me-2"></i>Detail Biaya
                    </h6>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Biaya Pengiriman</label>
                        <input type="number" name="delivery_cost" class="form-control cost-input" value="{{ $booking->delivery_cost }}" min="0" step="1000">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Biaya Operator</label>
                        <input type="number" name="operator_cost" class="form-control cost-input" value="{{ $booking->operator_cost }}" min="0" step="1000">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Biaya Asuransi</label>
                        <input type="number" name="insurance_cost" class="form-control cost-input" value="{{ $booking->insurance_cost }}" min="0" step="1000">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Deposit</label>
                        <input type="number" name="deposit_amount" class="form-control" value="{{ $booking->deposit_amount }}" min="0" step="1000">
                    </div>
                </div>
            </div>

            <!-- Calculation Summary -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold">Ringkasan Biaya</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1">Harga per hari: <span id="price-per-day">Rp {{ number_format($booking->equipment->price_per_day, 0, ',', '.') }}</span></p>
                                    <p class="mb-1">Durasi: <span id="duration">{{ $booking->getDurationDays() }} hari</span></p>
                                    <p class="mb-1">Subtotal rental: <span id="rental-subtotal">Rp {{ number_format($booking->rental_cost, 0, ',', '.') }}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1">Biaya tambahan: <span id="additional-costs">Rp {{ number_format($booking->delivery_cost + $booking->operator_cost + $booking->insurance_cost, 0, ',', '.') }}</span></p>
                                    <p class="mb-1 fw-bold">Total: <span id="grand-total">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Management -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="fw-bold text-primary border-bottom pb-2">
                        <i class="fas fa-cogs me-2"></i>Manajemen Status
                    </h6>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Status Booking</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="active" {{ $booking->status == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="payment_status" class="form-select">
                            <option value="pending" {{ $booking->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="partial" {{ $booking->payment_status == 'partial' ? 'selected' : '' }}>Dibayar Sebagian</option>
                            <option value="paid" {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>Lunas</option>
                            <option value="overdue" {{ $booking->payment_status == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Jumlah Dibayar</label>
                        <input type="number" name="paid_amount" class="form-control" value="{{ $booking->paid_amount }}" min="0" step="1000">
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
                        <textarea name="notes" class="form-control" rows="3">{{ $booking->notes }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea name="admin_notes" class="form-control" rows="3">{{ $booking->admin_notes }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Update Booking
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
    const costInputs = document.querySelectorAll('.cost-input');

    startDate.addEventListener('change', function() {
        endDate.min = this.value;
        if (endDate.value && endDate.value < this.value) {
            endDate.value = this.value;
        }
        calculateTotal();
    });

    endDate.addEventListener('change', calculateTotal);
    equipmentSelect.addEventListener('change', calculateTotal);
    
    costInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });

    function calculateTotal() {
        const selectedOption = equipmentSelect.options[equipmentSelect.selectedIndex];
        const pricePerDay = selectedOption.dataset.price || 0;
        
        // Calculate duration
        let duration = 0;
        if (startDate.value && endDate.value) {
            const start = new Date(startDate.value);
            const end = new Date(endDate.value);
            duration = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
        }

        // Calculate costs
        const deliveryCost = parseFloat(document.querySelector('[name="delivery_cost"]').value) || 0;
        const operatorCost = parseFloat(document.querySelector('[name="operator_cost"]').value) || 0;
        const insuranceCost = parseFloat(document.querySelector('[name="insurance_cost"]').value) || 0;
        
        const rentalSubtotal = pricePerDay * duration;
        const additionalCosts = deliveryCost + operatorCost + insuranceCost;
        const grandTotal = rentalSubtotal + additionalCosts;

        // Update display
        document.getElementById('price-per-day').textContent = formatCurrency(pricePerDay);
        document.getElementById('duration').textContent = duration + ' hari';
        document.getElementById('rental-subtotal').textContent = formatCurrency(rentalSubtotal);
        document.getElementById('additional-costs').textContent = formatCurrency(additionalCosts);
        document.getElementById('grand-total').textContent = formatCurrency(grandTotal);
    }

    function formatCurrency(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    // Initial calculation
    calculateTotal();
});
</script>
@endpush
