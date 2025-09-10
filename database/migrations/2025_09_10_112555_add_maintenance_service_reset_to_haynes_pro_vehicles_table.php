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
            $table->json('maintenance_service_reset')->nullable()->after('maintenance_stories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('haynes_pro_vehicles', function (Blueprint $table) {
            $table->dropColumn('maintenance_service_reset');
        });
    }
};
