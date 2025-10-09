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
        // Update existing values first
        DB::table('quotes')->where('status', 'accepted')->update(['status' => 'approved']);
        DB::table('quotes')->where('status', 'rejected')->update(['status' => 'declined']);
        DB::table('quotes')->where('status', 'expired')->update(['status' => 'declined']);
        
        // Change the enum values
        DB::statement("ALTER TABLE quotes MODIFY COLUMN status ENUM('draft', 'sent', 'approved', 'declined') DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to old enum values
        DB::statement("ALTER TABLE quotes MODIFY COLUMN status ENUM('draft', 'sent', 'accepted', 'rejected', 'expired') DEFAULT 'draft'");
        
        // Revert data
        DB::table('quotes')->where('status', 'approved')->update(['status' => 'accepted']);
        DB::table('quotes')->where('status', 'declined')->update(['status' => 'rejected']);
    }
};
