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
            // Remove conflicting make and model string columns
            // These conflict with the Eloquent relationship methods
            $table->dropColumn(['make', 'model']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Add back the make and model string columns
            $table->string('make')->nullable()->after('co2_emissions');
            $table->string('model')->nullable()->after('make');
        });
    }
};
