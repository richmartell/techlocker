<?php

namespace App\Console\Commands;

use App\Services\HaynesPro;
use Illuminate\Console\Command;

class TestHaynesProAuth extends Command
{
    protected $signature = 'haynespro:test-auth';
    protected $description = 'Test HaynesPro authentication and VRID retrieval';

    public function handle(HaynesPro $haynesPro)
    {
        $this->info('Testing HaynesPro authentication...');

        try {
            // Test authentication by getting VRID directly
            $vrid = $haynesPro->vrid();
            
            $this->info('Authentication successful!');
            $this->info('VRID retrieved and cached for 8 hours.');
            $this->info('VRID: ' . $vrid);
            
            // Test a secondary method that requires authentication
            $makes = $haynesPro->getVehicleMakes();
            
            $this->info('Successfully retrieved vehicle makes.');
            
            // Show a sample of the makes data
            $this->info("\nSample of vehicle makes:");
            $this->table(
                ['Make ID', 'Make Name'],
                collect($makes)->take(5)->map(fn($make) => [
                    $make['id'] ?? 'N/A',
                    $make['name'] ?? 'N/A'
                ])
            );

        } catch (\Exception $e) {
            $this->error('Authentication failed: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
} 