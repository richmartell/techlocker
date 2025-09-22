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
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->after('id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->index(['account_id', 'last_name', 'first_name']);
            
            // Update unique email constraint to be scoped to account
            $table->dropUnique('customers_email_unique');
            $table->unique(['account_id', 'email'], 'customers_account_email_unique')->whereNull('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropUnique('customers_account_email_unique');
            $table->dropIndex(['account_id', 'last_name', 'first_name']);
            $table->dropColumn('account_id');
            
            // Restore original email unique constraint
            $table->unique(['email'], 'customers_email_unique')->whereNull('deleted_at');
        });
    }
};
