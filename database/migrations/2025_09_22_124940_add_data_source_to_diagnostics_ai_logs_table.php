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
        Schema::table('diagnostics_ai_logs', function (Blueprint $table) {
            $table->string('data_source')->nullable()->after('status')->comment('Source of the response: haynes_only, ai_with_haynes, fallback');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagnostics_ai_logs', function (Blueprint $table) {
            $table->dropColumn('data_source');
        });
    }
};
