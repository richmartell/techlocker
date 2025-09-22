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
        Schema::create('customer_vehicle', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('customer_id');
            $table->unsignedBigInteger('vehicle_id'); // Vehicle uses standard auto-increment IDs
            $table->enum('relationship', ['owner', 'driver', 'billing_contact'])->default('owner');
            $table->date('owned_from')->nullable();
            $table->date('owned_to')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            
            // Unique constraint to prevent duplicate open ownerships
            // Allow history rows but prevent duplicate open ownerships (where owned_to is null)
            $table->unique(['customer_id', 'vehicle_id', 'relationship', 'owned_to'], 'customer_vehicle_unique');
            
            // Indexes for efficient querying
            $table->index(['customer_id', 'owned_to']);
            $table->index(['vehicle_id', 'owned_to']);
            $table->index(['relationship', 'owned_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_vehicle');
    }
};
