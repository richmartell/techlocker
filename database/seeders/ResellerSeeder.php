<?php

namespace Database\Seeders;

use App\Models\Reseller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ResellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default reseller user
        Reseller::firstOrCreate(
            ['email' => 'reseller@garageiq.com'],
            [
                'name' => 'Test Reseller',
                'password' => Hash::make('password'),
                'company_name' => 'Test Reseller Company Ltd',
                'phone' => '07700 900000',
                'commission_rate' => 10.00,
                'is_active' => true,
            ]
        );

        $this->command->info('Test reseller account created!');
        $this->command->info('Email: reseller@garageiq.com');
        $this->command->info('Password: password');
    }
}
