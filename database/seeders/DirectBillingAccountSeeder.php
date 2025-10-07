<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DirectBillingAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating direct billing account (no reseller)...');

        // Get a plan (Professional)
        $plan = Plan::where('name', 'Professional')->first();

        // Create account without reseller (reseller_id = null)
        $account = Account::create([
            'company_name' => 'Independence Motors',
            'registered_address' => '45 Freedom Street',
            'town' => 'Brighton',
            'county' => 'East Sussex',
            'post_code' => 'BN1 4GH',
            'country' => 'United Kingdom',
            'vat_number' => 'GB123456789',
            'company_phone' => '01273 123456',
            'company_email' => 'billing@independencemotors.co.uk',
            'web_address' => 'https://www.independencemotors.co.uk',
            'is_active' => true,
            'hourly_labour_rate' => 75.00,
            'labour_loading_percentage' => 0.15,
            'plan_id' => $plan?->id,
            'reseller_id' => null, // No reseller - direct billing
            'status' => 'active',
            'trial_started_at' => Carbon::now()->subMonths(2),
            'trial_ends_at' => Carbon::now()->subMonths(1)->addDays(30),
            'subscribed_at' => Carbon::now()->subMonths(1),
        ]);

        $this->command->info("Created account: {$account->company_name} (ID: {$account->id})");

        // Create users for this account
        $manager = User::create([
            'account_id' => $account->id,
            'name' => 'Sarah Williams',
            'email' => 'sarah@independencemotors.co.uk',
            'password' => Hash::make('password'),
            'phone' => '07700 900100',
            'role' => 'manager',
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info("Created manager: {$manager->email}");

        User::create([
            'account_id' => $account->id,
            'name' => 'Mike Thompson',
            'email' => 'mike@independencemotors.co.uk',
            'password' => Hash::make('password'),
            'phone' => '07700 900101',
            'role' => 'technician',
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        User::create([
            'account_id' => $account->id,
            'name' => 'Emma Davies',
            'email' => 'emma@independencemotors.co.uk',
            'password' => Hash::make('password'),
            'phone' => '07700 900102',
            'role' => 'technician',
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        $this->command->info("Created 3 users total");

        // Create customers for this account
        $this->command->info('Creating 25 customers...');
        $customers = Customer::factory(25)->create([
            'account_id' => $account->id
        ]);

        // Add some VIP and trade customers
        $vipCustomer = Customer::factory()->vip()->create([
            'account_id' => $account->id,
            'first_name' => 'Richard',
            'last_name' => 'Sterling',
            'email' => 'richard.sterling@example.com',
            'phone' => '07700 900200',
        ]);

        $tradeCustomer = Customer::factory()->trade()->create([
            'account_id' => $account->id,
            'first_name' => 'ABC',
            'last_name' => 'Fleet Services',
            'email' => 'fleet@abcfleet.com',
            'phone' => '01273 555666',
        ]);

        $allCustomers = $customers->push($vipCustomer)->push($tradeCustomer);
        $this->command->info("Created {$allCustomers->count()} customers");

        // Create vehicles for this account
        $this->command->info('Creating 40 vehicles...');
        $vehicles = Vehicle::factory(35)->create([
            'account_id' => $account->id
        ]);

        // Add some special vehicles
        $electricVehicles = Vehicle::factory(3)->electric()->create(['account_id' => $account->id]);
        $hybridVehicles = Vehicle::factory(2)->hybrid()->create(['account_id' => $account->id]);

        $allVehicles = $vehicles->merge($electricVehicles)->merge($hybridVehicles);
        $this->command->info("Created {$allVehicles->count()} vehicles");

        // Link vehicles to customers (70% of customers get 1-2 vehicles)
        $this->command->info('Linking vehicles to customers...');
        $usedVehicles = collect();
        $customersWithVehicles = $allCustomers->random(ceil($allCustomers->count() * 0.7));

        foreach ($customersWithVehicles as $customer) {
            $vehicleCount = rand(1, min(2, $allVehicles->count() - $usedVehicles->count()));

            if ($vehicleCount <= 0) break;

            $availableVehicles = $allVehicles->diff($usedVehicles);

            if ($availableVehicles->count() < $vehicleCount) {
                $vehicleCount = $availableVehicles->count();
            }

            if ($vehicleCount > 0) {
                $customerVehicles = $availableVehicles->random($vehicleCount);

                foreach ($customerVehicles as $vehicle) {
                    $relationship = $this->getRandomRelationship();
                    $ownedFrom = fake()->dateTimeBetween('-3 years', '-1 month')->format('Y-m-d');
                    $ownedTo = fake()->boolean(15) ? fake()->dateTimeBetween($ownedFrom, 'now')->format('Y-m-d') : null;

                    $customer->linkVehicle($vehicle, $relationship, $ownedFrom, $ownedTo);
                    $usedVehicles->push($vehicle);
                }
            }
        }

        $linkedCount = $allCustomers->filter(fn($c) => $c->currentVehicles()->count() > 0)->count();
        $this->command->info("Linked vehicles to {$linkedCount} customers");

        // Summary
        $this->command->newLine();
        $this->command->info('=== Direct Billing Account Summary ===');
        $this->command->info("Account: {$account->company_name}");
        $this->command->info("Login Email: {$manager->email}");
        $this->command->info("Password: password");
        $this->command->info("Status: {$account->status}");
        $this->command->info("Plan: " . ($plan ? $plan->name : 'None'));
        $this->command->info("Reseller: None (Direct Billing)");
        $this->command->info("Users: 3");
        $this->command->info("Customers: {$allCustomers->count()}");
        $this->command->info("Vehicles: {$allVehicles->count()}");
        $this->command->info("Active customer-vehicle links: {$linkedCount}");
        $this->command->newLine();
    }

    /**
     * Get a random relationship type weighted toward 'owner'.
     */
    private function getRandomRelationship(): string
    {
        $relationships = ['owner', 'owner', 'owner', 'owner', 'driver', 'billing_contact'];
        return $relationships[array_rand($relationships)];
    }
}

