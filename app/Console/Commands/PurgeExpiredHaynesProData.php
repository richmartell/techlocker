<?php

namespace App\Console\Commands;

use App\Models\HaynesProVehicle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PurgeExpiredHaynesProData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'haynes-pro:purge-expired {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge expired HaynesPro vehicle data older than 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        // Count expired records
        $expiredCount = HaynesProVehicle::expired()->count();
        
        if ($expiredCount === 0) {
            $this->info('No expired HaynesPro vehicle data found.');
            return 0;
        }
        
        if ($isDryRun) {
            $this->info("Dry run: Would delete {$expiredCount} expired HaynesPro vehicle records.");
            
            // Show some details about what would be deleted
            $expiredRecords = HaynesProVehicle::expired()
                ->select('car_type_id', 'created_at')
                ->orderBy('created_at')
                ->limit(10)
                ->get();
                
            $this->table(
                ['Car Type ID', 'Created At', 'Age (hours)'],
                $expiredRecords->map(function ($record) {
                    return [
                        $record->car_type_id,
                        $record->created_at->format('Y-m-d H:i:s'),
                        round($record->created_at->diffInHours(now()), 1)
                    ];
                })
            );
            
            if ($expiredCount > 10) {
                $this->info("... and " . ($expiredCount - 10) . " more records.");
            }
            
            return 0;
        }
        
        // Actually delete expired records
        $this->info("Purging {$expiredCount} expired HaynesPro vehicle records...");
        
        $deletedCount = HaynesProVehicle::purgeExpired();
        
        $this->info("Successfully purged {$deletedCount} expired records.");
        
        // Log the purge operation
        Log::info('HaynesPro cache purge completed', [
            'deleted_count' => $deletedCount,
            'executed_at' => now()
        ]);
        
        return 0;
    }
}
