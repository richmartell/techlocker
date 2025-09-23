<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->ulid('id')->primary();
            // Multi-tenancy
            $table->foreignId('account_id')->constrained()->cascadeOnDelete();

            $table->string('first_name', 80);
            $table->string('last_name', 80);
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index(['account_id', 'last_name', 'first_name']);
            $table->unique(['account_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technicians');
    }
};
