<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\HaynesPro;
use App\Models\DiagnosticsAiLog;
use Illuminate\Support\Facades\Http;

class TestDiagnosticsAI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnostics:test {registration=MS02MUD} {message="What is the engine capacity of this car?"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the diagnostics AI system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $registration = $this->argument('registration');
        $message = $this->argument('message');
        
        $this->info("Testing Diagnostics AI for vehicle: {$registration}");
        $this->info("Message: {$message}");
        $this->line('');

        try {
            // Test 1: Check if vehicle exists
            $vehicle = \App\Models\Vehicle::with(['make', 'model'])
                ->where('registration', $registration)
                ->first();

            if (!$vehicle) {
                $this->error("Vehicle with registration {$registration} not found in database.");
                return;
            }

            $this->info("✓ Vehicle found: {$vehicle->year_of_manufacture} {$vehicle->make?->name} {$vehicle->model?->name}");

            // Test 2: Check Haynes Pro integration
            $this->info("Testing Haynes Pro data fetching...");
            $haynesProService = app(HaynesPro::class);
            $haynesProData = $haynesProService->ensureVehicleDataCached($registration);
            
            if ($haynesProData) {
                $this->info("✓ Haynes Pro data available (Car Type ID: {$haynesProData->car_type_id})");
                $availableSections = array_filter([
                    $haynesProData->vehicle_identification_data ? 'Vehicle ID' : null,
                    $haynesProData->warning_lights ? 'Warning Lights' : null,
                    $haynesProData->technical_bulletins ? 'Technical Bulletins' : null,
                    $haynesProData->maintenance_systems ? 'Maintenance Systems' : null,
                    $haynesProData->lubricants ? 'Lubricants' : null,
                ]);
                $this->info("  Available sections: " . implode(', ', $availableSections));
            } else {
                $this->warn("⚠ No Haynes Pro data available");
            }

            // Test 3: Check OpenAI configuration
            $this->info("Testing OpenAI configuration...");
            $apiKey = config('services.openai.api_key');
            $model = config('services.openai.model');
            
            if (empty($apiKey)) {
                $this->error("✗ OpenAI API key not configured");
                return;
            }
            
            $this->info("✓ OpenAI API key configured");
            $this->info("✓ Model: {$model}");

            // Test 4: Simulate the diagnostics request
            $this->info("Simulating diagnostics request...");
            
            $vehicleData = [
                'registration' => $vehicle->registration,
                'make' => $vehicle->make?->name ?? 'Unknown',
                'model' => $vehicle->model?->name ?? 'Unknown',
                'year' => $vehicle->year_of_manufacture ?? 'Unknown',
                'engine' => $vehicle->engine_capacity ? $vehicle->engine_capacity . 'cc' : 'Unknown',
            ];

            // Build system message like the controller does
            $systemMessage = "You are DiagnosticsAI, an expert automotive diagnostic assistant specializing in vehicle issues. " .
                            "You're currently helping with a {$vehicleData['year']} {$vehicleData['make']} {$vehicleData['model']} " .
                            "with a {$vehicleData['engine']} engine (registration: {$vehicleData['registration']}). " .
                            "Provide helpful, accurate diagnostic information based on the symptoms described. " .
                            "Be concise but thorough. Organize your response with clear sections when appropriate. " .
                            "Be conversational but focus on technical accuracy.";

            if ($haynesProData) {
                $technicalData = $haynesProData->getFormattedDataForAI();
                if (!empty($technicalData)) {
                    $systemMessage .= "\n\nYou have access to the following comprehensive technical data for this specific vehicle:\n\n" . substr($technicalData, 0, 500) . "...";
                }
            }

            $this->info("System message length: " . strlen($systemMessage) . " characters");
            
            // Test OpenAI API call
            $this->info("Testing OpenAI API call...");
            $startTime = microtime(true);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemMessage],
                    ['role' => 'user', 'content' => $message]
                ],
                'temperature' => 0.7,
                'max_tokens' => 500, // Reduced for testing
            ]);

            $responseTime = round((microtime(true) - $startTime) * 1000);

            if ($response->successful()) {
                $responseData = $response->json();
                $aiResponse = $responseData['choices'][0]['message']['content'];
                
                $this->info("✓ OpenAI API call successful");
                $this->info("Response time: {$responseTime}ms");
                $this->line('');
                $this->info("AI Response:");
                $this->line(str_repeat('-', 50));
                $this->line($aiResponse);
                $this->line(str_repeat('-', 50));

                // Test logging
                $this->info("Testing logging...");
                $logData = DiagnosticsAiLog::logInteraction([
                    'user_message' => $message,
                    'ai_response' => $aiResponse,
                    'session_id' => 'test_' . uniqid(),
                    'vehicle_registration' => $registration,
                    'vehicle_data' => $vehicleData,
                    'haynes_car_type_id' => $haynesProData?->car_type_id,
                    'haynes_data_available' => !is_null($haynesProData),
                    'ai_model' => $model,
                    'response_time_ms' => $responseTime,
                    'temperature' => 0.7,
                    'max_tokens' => 500,
                    'status' => 'success',
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'Test Command',
                ]);

                $this->info("✓ Logging successful (Log ID: {$logData->id})");
                $this->info("✓ All tests passed!");

            } else {
                $this->error("✗ OpenAI API call failed");
                $this->error("Status: " . $response->status());
                $this->error("Response: " . $response->body());
            }

        } catch (\Exception $e) {
            $this->error("✗ Test failed with exception:");
            $this->error($e->getMessage());
            $this->error("File: " . $e->getFile() . ":" . $e->getLine());
        }
    }
}