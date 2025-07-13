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
            $table->string('technical_type_id')->nullable()->after('date_of_last_v5c_issued');
            $table->string('transmission')->nullable()->after('technical_type_id');
            $table->string('forward_gears')->nullable()->after('transmission');
            $table->timestamp('last_haynespro_sync_at')->nullable()->after('forward_gears');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['technical_type_id', 'transmission', 'forward_gears', 'last_haynespro_sync_at']);
        });
    }
};
