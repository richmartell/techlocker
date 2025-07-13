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
            $table->string('dvla_date_of_manufacture')->nullable()->after('last_haynespro_sync_at');
            $table->string('dvla_last_mileage')->nullable()->after('dvla_date_of_manufacture');
            $table->string('dvla_last_mileage_date')->nullable()->after('dvla_last_mileage');
            $table->string('haynes_maximum_power_at_rpm')->nullable()->after('dvla_last_mileage_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'dvla_date_of_manufacture',
                'dvla_last_mileage',
                'dvla_last_mileage_date',
                'haynes_maximum_power_at_rpm'
            ]);
        });
    }
};
