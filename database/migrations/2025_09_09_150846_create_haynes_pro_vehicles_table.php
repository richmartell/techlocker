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
        Schema::create('haynes_pro_vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('car_type_id')->primary();
            $table->json('adjustments')->nullable();
            $table->json('maintenance_systems')->nullable();
            $table->json('maintenance_tasks')->nullable();
            $table->timestamps();
            
            // Index for cleanup queries
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('haynes_pro_vehicles');
    }
};
