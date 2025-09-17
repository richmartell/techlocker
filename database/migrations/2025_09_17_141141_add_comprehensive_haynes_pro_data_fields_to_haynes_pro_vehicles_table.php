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
        Schema::table('haynes_pro_vehicles', function (Blueprint $table) {
            // Vehicle identification and basic data
            $table->json('vehicle_identification_data')->nullable()->after('car_type_id');
            
            // Technical diagnostic data
            $table->json('repair_time_infos')->nullable()->after('maintenance_service_reset');
            $table->json('technical_drawings')->nullable();
            $table->json('wiring_diagrams')->nullable();
            $table->json('fuse_locations')->nullable();
            $table->json('technical_bulletins')->nullable();
            $table->json('recalls')->nullable();
            $table->json('management_systems')->nullable();
            $table->json('story_overview')->nullable();
            $table->json('warning_lights')->nullable();
            $table->json('engine_location')->nullable();
            $table->json('lubricants')->nullable();
            
            // Diagnostic and testing data
            $table->json('pids')->nullable();
            $table->json('test_procedures')->nullable();
            $table->json('structure')->nullable();
            
            // Additional maintenance data
            $table->json('maintenance_forms')->nullable();
            $table->json('maintenance_system_overview')->nullable();
            $table->json('maintenance_intervals')->nullable();
            $table->json('timing_belt_maintenance')->nullable();
            $table->json('timing_belt_intervals')->nullable();
            $table->json('wear_parts_intervals')->nullable();
            
            // Metadata for cache management
            $table->json('available_subjects')->nullable()->comment('Available system subjects for this vehicle');
            $table->timestamp('last_comprehensive_fetch')->nullable()->comment('When all data was last fetched');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('haynes_pro_vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'vehicle_identification_data',
                'repair_time_infos',
                'technical_drawings',
                'wiring_diagrams',
                'fuse_locations',
                'technical_bulletins',
                'recalls',
                'management_systems',
                'story_overview',
                'warning_lights',
                'engine_location',
                'lubricants',
                'pids',
                'test_procedures',
                'structure',
                'maintenance_forms',
                'maintenance_system_overview',
                'maintenance_intervals',
                'timing_belt_maintenance',
                'timing_belt_intervals',
                'wear_parts_intervals',
                'available_subjects',
                'last_comprehensive_fetch'
            ]);
        });
    }
};