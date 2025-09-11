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
            // Remove conflicting make and model string columns if they exist
            // These conflict with the Eloquent relationship methods
            $columnsToRemove = [];
            if (Schema::hasColumn('vehicles', 'make')) {
                $columnsToRemove[] = 'make';
            }
            if (Schema::hasColumn('vehicles', 'model')) {
                $columnsToRemove[] = 'model';
            }
            
            if (!empty($columnsToRemove)) {
                $table->dropColumn($columnsToRemove);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Add back the make and model string columns if they don't exist
            if (!Schema::hasColumn('vehicles', 'make')) {
                $table->string('make')->nullable()->after('co2_emissions');
            }
            if (!Schema::hasColumn('vehicles', 'model')) {
                $table->string('model')->nullable()->after('make');
            }
        });
    }
};
