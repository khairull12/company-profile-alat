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
        Schema::table('bookings', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('bookings', 'booking_code')) {
                $table->string('booking_code')->unique()->nullable();
            }
            if (!Schema::hasColumn('bookings', 'quantity')) {
                $table->integer('quantity')->default(1);
            }
            if (!Schema::hasColumn('bookings', 'rental_price')) {
                $table->decimal('rental_price', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('bookings', 'total_price')) {
                $table->decimal('total_price', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('bookings', 'duration_days')) {
                $table->integer('duration_days')->default(1);
            }
            if (!Schema::hasColumn('bookings', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
