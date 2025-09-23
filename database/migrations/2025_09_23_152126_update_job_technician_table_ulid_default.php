<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the existing primary key and recreate with auto-generating ULID
        Schema::table('job_technician', function (Blueprint $table) {
            $table->dropPrimary(['id']);
            $table->dropColumn('id');
        });
        
        Schema::table('job_technician', function (Blueprint $table) {
            $table->id()->first(); // Use regular auto-incrementing ID for pivot tables
        });
    }

    public function down(): void
    {
        Schema::table('job_technician', function (Blueprint $table) {
            $table->dropColumn('id');
        });
        
        Schema::table('job_technician', function (Blueprint $table) {
            $table->ulid('id')->primary()->first();
        });
    }
};