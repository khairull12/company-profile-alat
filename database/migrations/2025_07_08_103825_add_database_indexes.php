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
        Schema::table('equipment', function (Blueprint $table) {
            $table->index(['category_id', 'is_active']); // For equipment listing by category
            $table->index(['price_per_day']); // For price filtering
            $table->index(['is_active', 'stock']); // For available equipment
            $table->index(['slug']); // For SEO friendly URLs
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->index(['user_id', 'status']); // For user booking history
            $table->index(['equipment_id', 'status']); // For equipment booking history
            $table->index(['status', 'created_at']); // For admin dashboard
            $table->index(['start_date', 'end_date']); // For availability checking
            $table->index(['booking_code']); // For booking search
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index(['role']); // For role-based queries
            $table->index(['email', 'role']); // For authentication
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index(['is_active']); // For active categories
            $table->index(['slug']); // For SEO friendly URLs
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->index(['group']); // For grouped settings
            $table->index(['key', 'group']); // For specific setting lookup
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropIndex(['category_id', 'is_active']);
            $table->dropIndex(['price_per_day']);
            $table->dropIndex(['is_active', 'stock']);
            $table->dropIndex(['slug']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['equipment_id', 'status']);
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['start_date', 'end_date']);
            $table->dropIndex(['booking_code']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['email', 'role']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['slug']);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropIndex(['group']);
            $table->dropIndex(['key', 'group']);
        });
    }
};
