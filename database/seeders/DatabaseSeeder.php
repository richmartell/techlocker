<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting GarageIQ Database Seeding...');
        $this->command->newLine();

        // 1. Seed Admin users (system administrators)
        $this->command->info('1. Creating system administrators...');
        $this->call(AdminSeeder::class);
        
        // 2. Seed Plans (subscription tiers)
        $this->command->info('2. Creating subscription plans...');
        $this->call(PlanSeeder::class);
        
        // 3. Seed Resellers
        $this->command->info('3. Creating reseller accounts...');
        $this->call(ResellerSeeder::class);
        
        // 4. Create main demo account with user
        $this->command->info('4. Creating main demo workshop account...');
        $this->createDemoAccount();
        
        // 5. Seed Customers and Vehicles (creates multiple accounts)
        $this->command->info('5. Creating customers, vehicles, and additional accounts...');
        $this->call(CustomerSeeder::class);
        
        // 6. Create a direct billing account (no reseller)
        $this->command->info('6. Creating direct billing account...');
        $this->call(DirectBillingAccountSeeder::class);
        
        // 7. Seed Jobs and Technicians for all accounts
        $this->command->info('7. Creating jobs and technicians...');
        $this->call(JobsAndTechniciansSeeder::class);
        
        // 8. Seed Invoices
        $this->command->info('8. Creating invoices...');
        $this->call(InvoiceSeeder::class);
        
        $this->command->newLine();
        $this->displaySummary();
    }
    
    private function createDemoAccount(): void
    {
        // Create a demo account
        $account = Account::create([
            'company_name' => 'Demo Workshop',
            'registered_address' => '123 Main Street',
            'town' => 'London',
            'county' => 'Greater London',
            'post_code' => 'SW1A 1AA',
            'country' => 'United Kingdom',
            'company_phone' => '020 1234 5678',
            'company_email' => 'info@demoworkshop.com',
            'web_address' => 'https://demoworkshop.com',
            'hourly_labour_rate' => 75.00,
            'labour_loading_percentage' => 0,
            'vat_registered' => true,
            'status' => 'trial',
            'trial_started_at' => Carbon::now(),
            'trial_ends_at' => Carbon::now()->addDays(30),
        ]);

        // Create an admin user for demo account
        User::create([
            'account_id' => $account->id,
            'name' => 'Demo Admin',
            'email' => 'admin@demoworkshop.com',
            'password' => Hash::make('password'),
            'phone' => '07700 900123',
            'role' => 'admin',
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);
        
        $this->command->info("✓ Created Demo Workshop account");
    }
    
    private function displaySummary(): void
    {
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('🎉 Database Seeding Complete!');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->newLine();
        
        $this->command->info('📊 Summary:');
        $this->command->info('  • Accounts: ' . \App\Models\Account::count());
        $this->command->info('  • Users: ' . \App\Models\User::count());
        $this->command->info('  • Customers: ' . \App\Models\Customer::count());
        $this->command->info('  • Vehicles: ' . \App\Models\Vehicle::count());
        $this->command->info('  • Jobs: ' . \App\Models\VehicleJob::count());
        $this->command->info('  • Technicians: ' . \App\Models\Technician::count());
        $this->command->info('  • Plans: ' . \App\Models\Plan::count());
        $this->command->info('  • Resellers: ' . \App\Models\Reseller::count());
        $this->command->info('  • Admins: ' . \App\Models\Admin::count());
        $this->command->info('  • Invoices: ' . \App\Models\Invoice::count());
        
        $this->command->newLine();
        $this->command->info('🔑 Login Credentials:');
        $this->command->newLine();
        
        $this->command->info('┌─ SYSTEM ADMIN ─────────────────────────────────────┐');
        $this->command->info('│ Email:    admin@garageiq.com                       │');
        $this->command->info('│ Password: password                                 │');
        $this->command->info('│ URL:      http://localhost/admin                   │');
        $this->command->info('└────────────────────────────────────────────────────┘');
        $this->command->newLine();
        
        $this->command->info('┌─ DEMO WORKSHOP ────────────────────────────────────┐');
        $this->command->info('│ Email:    admin@demoworkshop.com                   │');
        $this->command->info('│ Password: password                                 │');
        $this->command->info('│ URL:      http://localhost                         │');
        $this->command->info('└────────────────────────────────────────────────────┘');
        $this->command->newLine();
        
        $this->command->info('┌─ RESELLER ACCOUNT ─────────────────────────────────┐');
        $this->command->info('│ Email:    reseller@garageiq.com                    │');
        $this->command->info('│ Password: password                                 │');
        $this->command->info('│ URL:      http://localhost/reseller               │');
        $this->command->info('└────────────────────────────────────────────────────┘');
        $this->command->newLine();
        
        $this->command->info('┌─ DIRECT BILLING ACCOUNT ───────────────────────────┐');
        $this->command->info('│ Email:    sarah@independencemotors.co.uk           │');
        $this->command->info('│ Password: password                                 │');
        $this->command->info('│ URL:      http://localhost                         │');
        $this->command->info('└────────────────────────────────────────────────────┘');
        $this->command->newLine();
        
        $this->command->info('═══════════════════════════════════════════════════════');
    }
}
