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
        Schema::table('mitra_profiles', function (Blueprint $table) {
            $table->string('service_area')->nullable();
            $table->integer('service_radius')->nullable(); // in km
            $table->string('operational_hours')->nullable();
            $table->json('portfolio_images')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mitra_profiles', function (Blueprint $table) {
            $table->dropColumn(['service_area', 'service_radius', 'operational_hours', 'portfolio_images']);
        });
    }
};
