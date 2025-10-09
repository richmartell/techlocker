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
        Schema::table('quote_items', function (Blueprint $table) {
            $table->enum('type', ['labour', 'parts'])->default('labour')->after('quote_id');
            $table->string('part_number', 100)->nullable()->after('description');
            $table->string('part_name', 255)->nullable()->after('part_number');
            $table->decimal('unit_price', 10, 2)->nullable()->after('part_name');
            
            // Make these nullable since they won't apply to parts
            $table->decimal('time_hours', 8, 2)->nullable()->change();
            $table->decimal('labour_rate', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quote_items', function (Blueprint $table) {
            $table->dropColumn(['type', 'part_number', 'part_name', 'unit_price']);
            
            // Revert nullable changes (this might fail if there are null values)
            $table->decimal('time_hours', 8, 2)->nullable(false)->change();
            $table->decimal('labour_rate', 10, 2)->nullable(false)->change();
        });
    }
};
