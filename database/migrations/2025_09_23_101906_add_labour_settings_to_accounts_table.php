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
        Schema::table('accounts', function (Blueprint $table) {
            $table->decimal('hourly_labour_rate', 8, 2)->default(50.00)->after('is_active');
            $table->decimal('labour_loading_percentage', 5, 4)->default(0.0000)->after('hourly_labour_rate');
            
            // Add indexes for potential reporting queries
            $table->index('hourly_labour_rate');
            $table->index('labour_loading_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropIndex(['hourly_labour_rate']);
            $table->dropIndex(['labour_loading_percentage']);
            $table->dropColumn(['hourly_labour_rate', 'labour_loading_percentage']);
        });
    }
};