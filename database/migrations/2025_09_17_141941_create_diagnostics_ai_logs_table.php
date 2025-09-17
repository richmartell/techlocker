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
        Schema::create('diagnostics_ai_logs', function (Blueprint $table) {
            $table->id();
            
            // User interaction data
            $table->text('user_message'); // The user's question/prompt
            $table->longText('ai_response'); // The AI's response
            $table->string('session_id')->nullable(); // To track conversation sessions
            
            // Vehicle information
            $table->string('vehicle_registration'); // Vehicle number plate
            $table->unsignedBigInteger('haynes_car_type_id')->nullable(); // Haynes Pro car type ID
            $table->json('vehicle_data')->nullable(); // Basic vehicle info (make, model, year, etc.)
            
            // Technical context
            $table->boolean('haynes_data_available')->default(false); // Whether Haynes Pro data was available
            $table->json('haynes_data_sections')->nullable(); // Which Haynes Pro data sections were included
            $table->timestamp('haynes_last_fetch')->nullable(); // When Haynes data was last fetched
            
            // AI request metadata
            $table->string('ai_model')->nullable(); // Which AI model was used (e.g., gpt-3.5-turbo)
            $table->integer('system_message_length')->nullable(); // Length of system prompt
            $table->integer('user_message_length')->nullable(); // Length of user message
            $table->integer('ai_response_length')->nullable(); // Length of AI response
            $table->integer('response_time_ms')->nullable(); // Response time in milliseconds
            $table->float('temperature')->nullable(); // AI temperature setting
            $table->integer('max_tokens')->nullable(); // Max tokens setting
            
            // Status and debugging
            $table->enum('status', ['success', 'error', 'fallback'])->default('success');
            $table->text('error_message')->nullable(); // Any error that occurred
            $table->string('fallback_reason')->nullable(); // Reason for fallback (e.g., "api_unavailable")
            
            // Request tracking
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            
            $table->timestamps();
            
            // Indexes for efficient querying
            $table->index('vehicle_registration');
            $table->index('haynes_car_type_id');
            $table->index('status');
            $table->index('created_at');
            $table->index(['vehicle_registration', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnostics_ai_logs');
    }
};