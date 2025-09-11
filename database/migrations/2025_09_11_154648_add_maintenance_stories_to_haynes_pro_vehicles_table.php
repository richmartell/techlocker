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
            $table->json('maintenance_stories')->nullable()->after('maintenance_tasks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('haynes_pro_vehicles', function (Blueprint $table) {
            $table->dropColumn('maintenance_stories');
        });
    }
};
