<?php

namespace App\Console\Commands;

use App\Services\DVLA;
use Illuminate\Console\Command;
use Exception;

class TestDvlaApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dvla:test 
                            {registration=AB12CDE : The vehicle registration to lookup}
                            {--key= : Manually specify the DVLA API key (overrides .env)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the DVLA API connection and keep the API key active';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $registration = strtoupper(str_replace(' ', '', $this->argument('registration')));

        $this->info('╔════════════════════════════════════════════╗');
        $this->info('║         DVLA API CONNECTION TEST          ║');
        $this->info('╚════════════════════════════════════════════╝');
        $this->newLine();

        $this->info("Testing DVLA API with registration: {$registration}");
        $this->newLine();

        try {
            // Check if API key is configured
            $apiKey = $this->option('key') ?: config('services.dvla.api_key');
            
            if (empty($apiKey)) {
                $this->error('❌ DVLA API key is not configured!');
                $this->warn('Please set DVLA_API_KEY in your .env file or use --key option');
                $this->line('Example: php artisan dvla:test AB12CDE --key=your-api-key-here');
                return Command::FAILURE;
            }

            if ($this->option('key')) {
                $this->line('✓ Using manually specified API Key: ' . substr($apiKey, 0, 8) . '...');
            } else {
                $this->line('✓ Using API Key from .env: ' . substr($apiKey, 0, 8) . '...');
            }
            $this->newLine();

            // Initialize DVLA service with custom API key if provided
            $this->comment('Sending request to DVLA API...');
            
            if ($this->option('key')) {
                // Create a temporary instance with custom API key
                $dvlaService = new DVLA();
                // Use reflection to set the protected apiKey property
                $reflection = new \ReflectionClass($dvlaService);
                $property = $reflection->getProperty('apiKey');
                $property->setAccessible(true);
                $property->setValue($dvlaService, $apiKey);
            } else {
                $dvlaService = app(DVLA::class);
            }
            
            // Make API call
            $startTime = microtime(true);
            $vehicleData = $dvlaService->getVehicleDetails($registration);
            $duration = round((microtime(true) - $startTime) * 1000, 2);

            $this->newLine();
            $this->info("✅ SUCCESS! Response received in {$duration}ms");
            $this->newLine();

            // Display vehicle data
            $this->line('╔════════════════════════════════════════════╗');
            $this->line('║          VEHICLE INFORMATION              ║');
            $this->line('╚════════════════════════════════════════════╝');
            $this->newLine();

            if (empty($vehicleData)) {
                $this->warn('No vehicle data returned');
                return Command::SUCCESS;
            }

            // Display key fields
            $keyFields = [
                'registrationNumber' => 'Registration',
                'make' => 'Make',
                'model' => 'Model',
                'colour' => 'Colour',
                'yearOfManufacture' => 'Year',
                'fuelType' => 'Fuel Type',
                'engineCapacity' => 'Engine (cc)',
                'co2Emissions' => 'CO2 Emissions',
                'taxStatus' => 'Tax Status',
                'motStatus' => 'MOT Status',
                'taxDueDate' => 'Tax Due',
                'motExpiryDate' => 'MOT Expiry',
            ];

            foreach ($keyFields as $key => $label) {
                if (isset($vehicleData[$key])) {
                    $value = $vehicleData[$key];
                    $this->line(sprintf('  %-20s: %s', $label, $value));
                }
            }

            $this->newLine();
            $this->line('╔════════════════════════════════════════════╗');
            $this->line('║          FULL API RESPONSE                ║');
            $this->line('╚════════════════════════════════════════════╝');
            $this->newLine();
            
            // Display full response as JSON
            $this->line(json_encode($vehicleData, JSON_PRETTY_PRINT));
            
            $this->newLine();
            $this->info('✓ API key is now active and will not be suspended');
            $this->info('✓ Total fields returned: ' . count($vehicleData));
            
            return Command::SUCCESS;

        } catch (Exception $e) {
            $this->newLine();
            $this->error('❌ ERROR: ' . $e->getMessage());
            $this->newLine();
            
            $this->warn('Troubleshooting:');
            $this->line('  1. Check your DVLA_API_KEY in .env file');
            $this->line('  2. Verify the registration number is valid');
            $this->line('  3. Check your internet connection');
            $this->line('  4. Review logs: storage/logs/laravel.log');
            
            return Command::FAILURE;
        }
    }
}
