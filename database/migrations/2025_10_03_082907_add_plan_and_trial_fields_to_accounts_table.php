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
            if (!Schema::hasColumn('accounts', 'plan_id')) {
                $table->foreignId('plan_id')->nullable()->after('is_active')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('accounts', 'trial_started_at')) {
                $table->timestamp('trial_started_at')->nullable()->after('plan_id');
            }
            // trial_ends_at already exists in the original migration
            if (!Schema::hasColumn('accounts', 'trial_status')) {
                $table->enum('trial_status', ['active', 'expired', 'converted'])->nullable()->after('trial_ends_at');
            }
            if (!Schema::hasColumn('accounts', 'subscribed_at')) {
                $table->timestamp('subscribed_at')->nullable()->after('trial_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn(['plan_id', 'trial_started_at', 'trial_status', 'subscribed_at']);
        });
    }
};
