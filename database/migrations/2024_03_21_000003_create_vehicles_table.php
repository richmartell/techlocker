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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('registration')->unique();
            $table->string('name')->nullable();
            $table->foreignId('vehicle_make_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vehicle_model_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('last_dvla_sync_at')->nullable();
            $table->string('colour')->nullable();
            $table->string('engine_capacity')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('year_of_manufacture')->nullable();
            $table->string('co2_emissions')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('marked_for_export')->nullable();
            $table->string('month_of_first_registration')->nullable();
            $table->string('mot_status')->nullable();
            $table->string('revenue_weight')->nullable();
            $table->string('tax_due_date')->nullable();
            $table->string('tax_status')->nullable();
            $table->string('type_approval')->nullable();
            $table->string('wheelplan')->nullable();
            $table->string('euro_status')->nullable();
            $table->string('real_driving_emissions')->nullable();
            $table->string('date_of_last_v5c_issued')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
}; 