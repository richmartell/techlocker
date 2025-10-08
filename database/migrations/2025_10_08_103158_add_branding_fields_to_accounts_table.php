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
            $table->string('branding_logo')->nullable()->after('web_address');
            $table->string('branding_trading_name')->nullable()->after('branding_logo');
            $table->text('branding_address')->nullable()->after('branding_trading_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['branding_logo', 'branding_trading_name', 'branding_address']);
        });
    }
};