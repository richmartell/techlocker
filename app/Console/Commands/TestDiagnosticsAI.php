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
    protected $signature = 'diagnostics:test {registration=MS02MUD} {message="Vehicle has intermittent misfire on cylinder 3, P0303 stored. What are the diagnostic steps?"}';

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

            // Test 4: Use the actual diagnostics controller logic
            $this->info("Testing with actual DiagnosticsController logic...");
            
            $controller = new \App\Http\Controllers\DiagnosticsController();
            $request = new \Illuminate\Http\Request([
                'message' => $message,
                'registration' => $registration
            ]);
            
            // Manually set required headers
            $request->headers->set('X-Session-ID', 'test_' . uniqid());
            $request->server->set('REMOTE_ADDR', '127.0.0.1');
            $request->headers->set('User-Agent', 'Test Command');
            
            $startTime = microtime(true);
            
            try {
                $response = $controller->processMessage($request);
                $responseTime = round((microtime(true) - $startTime) * 1000);
                
                if ($response->getStatusCode() === 200) {
                    $responseData = json_decode($response->getContent(), true);
                    $aiResponse = $responseData['message'] ?? 'No message returned';
                    
                    $this->info("✓ DiagnosticsController call successful");
                    $this->info("Response time: {$responseTime}ms");
                    $this->line('');
                    $this->info("AI Response:");
                    $this->line(str_repeat('-', 50));
                    $this->line($aiResponse);
                    $this->line(str_repeat('-', 50));

                    $this->info("✓ All tests passed!");
                } else {
                    $this->error("✗ DiagnosticsController call failed");
                    $this->error("Status: " . $response->getStatusCode());
                    $this->error("Response: " . $response->getContent());
                }
            } catch (\Exception $e) {
                $this->error("✗ DiagnosticsController call failed with exception");
                $this->error("Error: " . $e->getMessage());
            }

        } catch (\Exception $e) {
            $this->error("✗ Test failed with exception:");
            $this->error($e->getMessage());
            $this->error("File: " . $e->getFile() . ":" . $e->getLine());
        }
    }
}