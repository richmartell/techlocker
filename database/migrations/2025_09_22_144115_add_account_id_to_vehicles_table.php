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
            $table->unsignedBigInteger('account_id')->after('id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->index(['account_id', 'registration']);
            
            // Update unique registration constraint to be scoped to account
            $table->dropUnique(['registration']);
            $table->unique(['account_id', 'registration'], 'vehicles_account_registration_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropUnique('vehicles_account_registration_unique');
            $table->dropIndex(['account_id', 'registration']);
            $table->dropColumn('account_id');
            
            // Restore original registration unique constraint
            $table->unique(['registration']);
        });
    }
};
