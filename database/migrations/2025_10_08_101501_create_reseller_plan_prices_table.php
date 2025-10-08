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
        Schema::create('reseller_plan_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reseller_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2); // The price the reseller pays you
            $table->timestamps();

            // Ensure unique pricing per reseller-plan combination
            $table->unique(['reseller_id', 'plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseller_plan_prices');
    }
};