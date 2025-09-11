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
            // Remove unused field if it exists
            if (Schema::hasColumn('vehicles', 'technical_type_id')) {
                $table->dropColumn('technical_type_id');
            }
            
            // Add new fields if they don't exist
            if (!Schema::hasColumn('vehicles', 'combined_vin')) {
                $table->string('combined_vin')->nullable()->after('forward_gears');
            }
            if (!Schema::hasColumn('vehicles', 'haynes_model_variant_description')) {
                $table->string('haynes_model_variant_description')->nullable()->after('combined_vin');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Remove new fields if they exist
            if (Schema::hasColumn('vehicles', 'combined_vin')) {
                $table->dropColumn('combined_vin');
            }
            if (Schema::hasColumn('vehicles', 'haynes_model_variant_description')) {
                $table->dropColumn('haynes_model_variant_description');
            }
            
            // Add back the removed field if it doesn't exist
            if (!Schema::hasColumn('vehicles', 'technical_type_id')) {
                $table->string('technical_type_id')->nullable()->after('forward_gears');
            }
        });
    }
};
