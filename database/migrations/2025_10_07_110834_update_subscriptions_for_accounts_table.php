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
        Schema::table('subscriptions', function (Blueprint $table) {
            // Drop the existing index
            $table->dropIndex(['user_id', 'stripe_status']);
            
            // Rename user_id to account_id
            $table->renameColumn('user_id', 'account_id');
        });
        
        Schema::table('subscriptions', function (Blueprint $table) {
            // Add the new index with account_id
            $table->index(['account_id', 'stripe_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            // Drop the new index
            $table->dropIndex(['account_id', 'stripe_status']);
            
            // Rename account_id back to user_id
            $table->renameColumn('account_id', 'user_id');
        });
        
        Schema::table('subscriptions', function (Blueprint $table) {
            // Restore the original index
            $table->index(['user_id', 'stripe_status']);
        });
    }
};
