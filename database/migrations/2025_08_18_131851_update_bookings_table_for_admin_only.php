<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('bookings');
        
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            
            // Customer Information
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('company_name')->nullable();
            $table->string('project_location');
            
            // Rental Details
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration_days');
            $table->text('project_description');
            $table->text('special_requirements')->nullable();
            
            // Pricing
            $table->decimal('rental_price', 12, 2);
            $table->decimal('total_price', 12, 2);
            
            // Status
            $table->enum('status', ['pending', 'confirmed', 'ongoing', 'completed', 'cancelled'])->default('pending');
            
            $table->timestamps();
            
            // Indexes
            $table->index(['status', 'start_date']);
            $table->index(['booking_code']);
            $table->index(['customer_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
