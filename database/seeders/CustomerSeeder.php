<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating account-based customers and vehicles...');
        
        // Create 3 different accounts for testing multi-tenancy
        $this->command->info('Creating test accounts...');
        $accounts = [
            \App\Models\Account::factory()->create([
                'company_name' => 'Main Street Motors',
                'company_email' => 'info@mainstreetmotors.com',
                'company_phone' => '01234 567890',
            ]),
            \App\Models\Account::factory()->create([
                'company_name' => 'City Auto Repair',
                'company_email' => 'hello@cityautorepair.co.uk',
                'company_phone' => '01987 654321',
            ]),
            \App\Models\Account::factory()->create([
                'company_name' => 'Premium Garage Services',
                'company_email' => 'contact@premiumgarage.com',
                'company_phone' => '01555 123456',
            ]),
        ];
        
        $this->command->info('Created 3 accounts');
        
        // Create customers distributed across accounts
        $this->command->info('Creating 50 customers across accounts...');
        $allCustomers = collect();
        
        foreach ($accounts as $index => $account) {
            // Main account gets more customers (testing the primary account)
            $customerCount = $index === 0 ? 30 : ($index === 1 ? 15 : 5);
            
            $customers = \App\Models\Customer::factory($customerCount)->create([
                'account_id' => $account->id
            ]);
            
            $allCustomers = $allCustomers->merge($customers);
            
            // Create special customers for first account
            if ($index === 0) {
                $vipCustomer = \App\Models\Customer::factory()->vip()->create([
                    'account_id' => $account->id,
                    'first_name' => 'Victoria',
                    'last_name' => 'Important',
                    'email' => 'vip@example.com',
                    'phone' => '07700 900123',
                ]);
                
                $tradeCustomer = \App\Models\Customer::factory()->trade()->create([
                    'account_id' => $account->id,
                    'first_name' => 'Thomas',
                    'last_name' => 'Trader',
                    'email' => 'trade@example.com',
                    'phone' => '01234 567890',
                ]);
                
                $allCustomers->push($vipCustomer);
                $allCustomers->push($tradeCustomer);
            }
        }
        
        $this->command->info('Created ' . $allCustomers->count() . ' customers total');
        
        // Create vehicles distributed across accounts
        $this->command->info('Creating vehicles across accounts...');
        $allVehicles = collect();
        
        foreach ($accounts as $index => $account) {
            // Main account gets more vehicles
            $vehicleCount = $index === 0 ? 50 : ($index === 1 ? 25 : 15);
            
            $vehicles = \App\Models\Vehicle::factory($vehicleCount)->create([
                'account_id' => $account->id
            ]);
            
            $allVehicles = $allVehicles->merge($vehicles);
            
            // Create special vehicles for first account
            if ($index === 0) {
                $specialVehicles = collect();
                $specialVehicles = $specialVehicles->merge(\App\Models\Vehicle::factory(5)->electric()->create(['account_id' => $account->id]));
                $specialVehicles = $specialVehicles->merge(\App\Models\Vehicle::factory(3)->hybrid()->create(['account_id' => $account->id]));
                $specialVehicles = $specialVehicles->merge(\App\Models\Vehicle::factory(2)->commercial()->create(['account_id' => $account->id]));
                
                $allVehicles = $allVehicles->merge($specialVehicles);
            }
        }
        
        $this->command->info('Created ' . $allVehicles->count() . ' vehicles total');
        
        // Link vehicles to customers within each account
        $this->command->info('Linking vehicles to customers within each account...');
        
        foreach ($accounts as $account) {
            $accountCustomers = $allCustomers->where('account_id', $account->id);
            $accountVehicles = $allVehicles->where('account_id', $account->id);
            
            if ($accountCustomers->isEmpty() || $accountVehicles->isEmpty()) {
                continue;
            }
            
            $usedVehicles = collect();
            
            // 60% of customers get 1-3 vehicles each
            $customersWithVehicles = $accountCustomers->random(ceil($accountCustomers->count() * 0.6));
            
            foreach ($customersWithVehicles as $customer) {
                $vehicleCount = rand(1, min(3, $accountVehicles->count() - $usedVehicles->count()));
                
                if ($vehicleCount <= 0) break;
                
                $availableVehicles = $accountVehicles->diff($usedVehicles);
                
                if ($availableVehicles->count() < $vehicleCount) {
                    $vehicleCount = $availableVehicles->count();
                }
                
                if ($vehicleCount > 0) {
                    $customerVehicles = $availableVehicles->random($vehicleCount);
                    
                    foreach ($customerVehicles as $vehicle) {
                        $relationship = $this->getRandomRelationship();
                        $ownedFrom = fake()->dateTimeBetween('-5 years', '-1 month')->format('Y-m-d');
                        $ownedTo = fake()->boolean(20) ? fake()->dateTimeBetween($ownedFrom, 'now')->format('Y-m-d') : null;
                        
                        $customer->linkVehicle($vehicle, $relationship, $ownedFrom, $ownedTo);
                        $usedVehicles->push($vehicle);
                    }
                }
            }
        }
        
        $this->command->info('Linked vehicles to customers');
        
        // Create some historical ownership records for testing
        $this->createHistoricalRecords($allCustomers, $allVehicles);
        
        $this->command->info('Created historical ownership records');
        
        // Display summary by account
        foreach ($accounts as $index => $account) {
            $customerCount = \App\Models\Customer::where('account_id', $account->id)->count();
            $vehicleCount = \App\Models\Vehicle::where('account_id', $account->id)->count();
            $activeLinks = \App\Models\Customer::where('account_id', $account->id)->has('currentVehicles')->count();
            
            $accountNumber = $index + 1;
            $this->command->info("Account {$accountNumber} ({$account->company_name}):");
            $this->command->info("  - Customers: {$customerCount}");
            $this->command->info("  - Vehicles: {$vehicleCount}");
            $this->command->info("  - Customers with vehicles: {$activeLinks}");
        }
        
        $totalCustomers = \App\Models\Customer::count();
        $totalVehicles = \App\Models\Vehicle::count();
        $totalLinks = \DB::table('customer_vehicle')->count();
        
        $this->command->info("\nOverall Summary:");
        $this->command->info("- Total Accounts: " . count($accounts));
        $this->command->info("- Total Customers: {$totalCustomers}");
        $this->command->info("- Total Vehicles: {$totalVehicles}");
        $this->command->info("- Total ownership records: {$totalLinks}");
    }
    
    /**
     * Get a random relationship type weighted toward 'owner'.
     */
    private function getRandomRelationship(): string
    {
        $relationships = ['owner', 'owner', 'owner', 'owner', 'driver', 'billing_contact'];
        return $relationships[array_rand($relationships)];
    }
    
    /**
     * Create some historical ownership records for testing.
     */
    private function createHistoricalRecords($customers, $vehicles): void
    {
        // Create 10 historical records (vehicles that were previously owned)
        $randomCustomers = $customers->random(10);
        $randomVehicles = $vehicles->random(10);
        
        foreach ($randomCustomers as $index => $customer) {
            $vehicle = $randomVehicles[$index];
            
            // Create a historical record (ownership ended)
            $ownedFrom = fake()->dateTimeBetween('-3 years', '-1 year')->format('Y-m-d');
            $ownedTo = fake()->dateTimeBetween($ownedFrom, '-6 months')->format('Y-m-d');
            
            \DB::table('customer_vehicle')->insert([
                'id' => \Illuminate\Support\Str::ulid(),
                'customer_id' => $customer->id,
                'vehicle_id' => $vehicle->id,
                'relationship' => 'owner',
                'owned_from' => $ownedFrom,
                'owned_to' => $ownedTo,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
