<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_jobs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            // Multi-tenancy
            $table->foreignId('account_id')->constrained()->cascadeOnDelete();

            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->string('job_number')->unique();
            $table->string('title', 120);
            $table->text('description')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('vehicle_id');
            $table->index('status');
            $table->index(['start_at', 'end_at']);
            $table->index(['account_id', 'start_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_jobs');
    }
};
