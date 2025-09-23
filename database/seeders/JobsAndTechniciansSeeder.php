<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Technician;
use App\Models\Vehicle;
use App\Models\VehicleJob;
use Illuminate\Database\Seeder;

class JobsAndTechniciansSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing accounts to seed data
        $accounts = Account::all();
        
        if ($accounts->isEmpty()) {
            $this->command->info('No accounts found. Please run the customer seeder first.');
            return;
        }

        foreach ($accounts as $account) {
            $this->seedForAccount($account);
        }
    }

    private function seedForAccount(Account $account): void
    {
        $this->command->info("Seeding jobs and technicians for account: {$account->company_name}");

        // Create 3-5 technicians per account
        $technicians = Technician::factory()
            ->count(rand(3, 5))
            ->state(['account_id' => $account->id])
            ->create();

        // Get vehicles for this account
        $vehicles = Vehicle::where('account_id', $account->id)->get();
        
        if ($vehicles->isEmpty()) {
            $this->command->info("No vehicles found for account {$account->company_name}. Skipping jobs.");
            return;
        }

        // Create 8-15 jobs per account
        $jobCount = rand(8, 15);
        
        for ($i = 0; $i < $jobCount; $i++) {
            $vehicle = $vehicles->random();
            
            $job = VehicleJob::factory()
                ->state([
                    'account_id' => $account->id,
                    'vehicle_id' => $vehicle->id,
                ])
                ->create();

            // Assign 1-3 technicians to each job
            $assignedTechnicians = $technicians->random(rand(1, 3));
            
            $syncData = [];
            foreach ($assignedTechnicians as $tech) {
                $syncData[$tech->id] = [
                    'role' => $this->getRandomRole(),
                ];
            }
            
            $job->technicians()->sync($syncData);
        }

        $this->command->info("Created {$jobCount} jobs and {$technicians->count()} technicians for {$account->company_name}");
    }

    private function getRandomRole(): ?string
    {
        $roles = [null, 'Lead', 'Assistant', 'Specialist', 'Trainee'];
        return fake()->optional(0.7)->randomElement($roles);
    }
}