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
        Schema::create('customers', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('first_name', 80);
            $table->string('last_name', 80);
            $table->string('email', 191)->nullable()->index();
            $table->string('phone', 30)->nullable()->index();
            $table->string('phone_e164', 30)->nullable()->index()->comment('Normalized phone number in E.164 format');
            $table->text('notes')->nullable();
            $table->json('tags')->nullable()->comment('Optional tags for customer segmentation');
            $table->enum('source', ['web', 'phone', 'walk-in', 'referral'])->nullable();
            $table->timestamp('last_contact_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Composite index for name sorting
            $table->index(['last_name', 'first_name']);
            
            // Unique constraint on email only for non-deleted records
            $table->unique(['email'], 'customers_email_unique')->whereNull('deleted_at');
            
            // Full-text index on notes if supported (MySQL/PostgreSQL)
            if (config('database.default') === 'mysql') {
                $table->fullText(['notes']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
