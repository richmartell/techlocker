<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_technician', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('job_id')->constrained('service_jobs')->cascadeOnDelete();
            $table->foreignUlid('technician_id')->constrained('technicians')->cascadeOnDelete();
            $table->string('role')->nullable();
            $table->timestamps();

            $table->unique(['job_id', 'technician_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_technician');
    }
};
