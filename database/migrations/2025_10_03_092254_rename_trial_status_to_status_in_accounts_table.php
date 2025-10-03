<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Rename trial_status to status if it hasn't been renamed yet
        if (Schema::hasColumn('accounts', 'trial_status') && !Schema::hasColumn('accounts', 'status')) {
            Schema::table('accounts', function (Blueprint $table) {
                $table->renameColumn('trial_status', 'status');
            });
        }

        // First, convert ENUM to VARCHAR to allow any value temporarily
        DB::statement("ALTER TABLE accounts MODIFY COLUMN status VARCHAR(50) NULL");

        // Update existing values to new status types
        DB::table('accounts')
            ->where('status', 'active')
            ->whereNotNull('trial_ends_at')
            ->where('trial_ends_at', '>', now())
            ->update(['status' => 'trial']);

        DB::table('accounts')
            ->where('status', 'expired')
            ->update(['status' => 'trial_expired']);

        DB::table('accounts')
            ->where('status', 'converted')
            ->update(['status' => 'active']);
            
        // Now convert to ENUM with the new values
        DB::statement("ALTER TABLE accounts MODIFY COLUMN status ENUM('trial', 'trial_expired', 'active', 'churned') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert to VARCHAR first
        DB::statement("ALTER TABLE accounts MODIFY COLUMN status VARCHAR(50) NULL");
        
        // Revert status values back to trial_status values
        DB::table('accounts')
            ->where('status', 'trial')
            ->update(['status' => 'active']);

        DB::table('accounts')
            ->where('status', 'trial_expired')
            ->update(['status' => 'expired']);

        DB::table('accounts')
            ->where('status', 'churned')
            ->update(['status' => 'converted']);

        // Change ENUM back to original values
        DB::statement("ALTER TABLE accounts MODIFY COLUMN status ENUM('active', 'expired', 'converted') NULL");

        // Rename back to trial_status
        if (Schema::hasColumn('accounts', 'status') && !Schema::hasColumn('accounts', 'trial_status')) {
            Schema::table('accounts', function (Blueprint $table) {
                $table->renameColumn('status', 'trial_status');
            });
        }
    }
};
