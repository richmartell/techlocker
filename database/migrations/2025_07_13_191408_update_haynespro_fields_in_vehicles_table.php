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
        Schema::table('vehicles', function (Blueprint $table) {
            // Remove unused field
            $table->dropColumn('technical_type_id');
            
            // Add new fields
            $table->string('combined_vin')->nullable()->after('forward_gears');
            $table->string('haynes_model_variant_description')->nullable()->after('combined_vin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Remove new fields
            $table->dropColumn(['combined_vin', 'haynes_model_variant_description']);
            
            // Add back the removed field
            $table->string('technical_type_id')->nullable()->after('forward_gears');
        });
    }
};
