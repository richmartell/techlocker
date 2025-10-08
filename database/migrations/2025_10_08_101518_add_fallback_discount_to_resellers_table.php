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
        Schema::table('resellers', function (Blueprint $table) {
            // Add fallback discount percentage (e.g., 15 = 15% discount)
            $table->decimal('fallback_discount_percentage', 5, 2)->default(0)->after('commission_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resellers', function (Blueprint $table) {
            $table->dropColumn('fallback_discount_percentage');
        });
    }
};