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
            $table->integer('car_type_id')->nullable()->after('tecdoc_ktype')->comment('HaynesPro CarType ID from decodeVINV4');
            $table->text('available_subjects')->nullable()->after('car_type_id')->comment('CSV list of available subjects from HaynesPro');
            $table->timestamp('car_type_identified_at')->nullable()->after('available_subjects')->comment('When the car type was last identified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['car_type_id', 'available_subjects', 'car_type_identified_at']);
        });
    }
};
