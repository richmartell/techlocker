<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DiagnosticsAiLog;

class CreateSampleDiagnosticsLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnostics:create-sample-logs {--count=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create sample diagnostics AI logs for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->option('count');
        
        $sampleData = [
            [
                'user_message' => 'My car is making a strange noise when I start it',
                'ai_response' => 'The starting noise could be related to several components. First, check if it\'s a grinding noise (starter motor) or squealing (belts). Based on your vehicle\'s maintenance records, I recommend checking the starter motor connections and belt tension.',
                'vehicle_registration' => 'ABC123',
                'status' => 'success',
                'haynes_data_available' => true,
                'haynes_car_type_id' => 12345,
            ],
            [
                'user_message' => 'Check engine light is on',
                'ai_response' => 'The check engine light indicates a diagnostic trouble code has been stored. You\'ll need an OBD scanner to read the specific code. Common causes include oxygen sensor failures, loose gas caps, or emission system issues.',
                'vehicle_registration' => 'DEF456',
                'status' => 'success',
                'haynes_data_available' => false,
            ],
            [
                'user_message' => 'Car won\'t start at all',
                'ai_response' => 'Complete failure to start usually indicates battery, starter, or fuel system issues. Try these steps: 1) Check battery voltage, 2) Listen for starter motor engagement, 3) Check for fuel delivery.',
                'vehicle_registration' => 'GHI789',
                'status' => 'fallback',
                'fallback_reason' => 'api_error',
                'error_message' => 'OpenAI API timeout',
                'haynes_data_available' => false,
            ],
        ];

        $sessions = ['sess_' . uniqid(), 'sess_' . uniqid(), 'sess_' . uniqid()];
        
        for ($i = 0; $i < $count; $i++) {
            $sample = $sampleData[$i % count($sampleData)];
            
            DiagnosticsAiLog::create([
                'user_message' => $sample['user_message'],
                'ai_response' => $sample['ai_response'],
                'session_id' => $sessions[$i % count($sessions)],
                'vehicle_registration' => $sample['vehicle_registration'],
                'haynes_car_type_id' => $sample['haynes_car_type_id'] ?? null,
                'vehicle_data' => [
                    'registration' => $sample['vehicle_registration'],
                    'make' => 'Test Make',
                    'model' => 'Test Model',
                    'year' => '2020',
                    'engine' => '2.0L Test Engine',
                ],
                'haynes_data_available' => $sample['haynes_data_available'],
                'haynes_data_sections' => $sample['haynes_data_available'] ? ['Warning Lights', 'Technical Bulletins', 'Maintenance Systems'] : null,
                'haynes_last_fetch' => $sample['haynes_data_available'] ? now()->subMinutes(rand(10, 120)) : null,
                'ai_model' => 'gpt-3.5-turbo',
                'system_message_length' => rand(500, 2000),
                'user_message_length' => strlen($sample['user_message']),
                'ai_response_length' => strlen($sample['ai_response']),
                'response_time_ms' => rand(800, 3000),
                'temperature' => 0.7,
                'max_tokens' => 1200,
                'status' => $sample['status'],
                'error_message' => $sample['error_message'] ?? null,
                'fallback_reason' => $sample['fallback_reason'] ?? null,
                'ip_address' => '192.168.1.' . rand(1, 254),
                'user_agent' => 'Mozilla/5.0 (Test Browser)',
                'created_at' => now()->subMinutes(rand(1, 1440)), // Random time in last 24 hours
            ]);
        }

        $this->info("Created {$count} sample diagnostic AI logs.");
    }
}