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
            'trial_ends_at' => Carbon::now()->addDays(30),
        ]);

        // Create an admin user
        User::create([
            'account_id' => $account->id,
            'name' => 'Admin User',
            'email' => 'admin@demoworkshop.com',
            'password' => Hash::make('password'),
            'phone' => '07700 900123',
            'role' => 'admin',
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);
    }
}
