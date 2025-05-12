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
            // This will trigger the getVrid() method internally
            $tree = $haynesPro->getIdentificationTree();
            
            $this->info('Authentication successful!');
            $this->info('VRID retrieved and cached for 8 hours.');
            $this->info('Successfully retrieved identification tree.');
            
            // Show a sample of the tree data
            $this->info("\nSample of identification tree:");
            $this->table(
                ['Make', 'Model Count'],
                collect($tree)->take(5)->map(fn($make) => [
                    $make['name'] ?? 'N/A',
                    count($make['models'] ?? [])
                ])
            );

        } catch (\Exception $e) {
            $this->error('Authentication failed: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
} 