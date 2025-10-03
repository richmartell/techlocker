<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create three default plans (prices in GBP)
        Plan::firstOrCreate(
            ['name' => 'Starter'],
            [
                'description' => 'Perfect for small workshops just getting started',
                'price' => 24.99,
                'max_users' => 3,
                'max_customers' => 50,
                'max_searches' => 100,
                'is_active' => true,
            ]
        );

        Plan::firstOrCreate(
            ['name' => 'Professional'],
            [
                'description' => 'Ideal for growing businesses with multiple technicians',
                'price' => 64.99,
                'max_users' => 10,
                'max_customers' => 200,
                'max_searches' => 500,
                'is_active' => true,
            ]
        );

        Plan::firstOrCreate(
            ['name' => 'Enterprise'],
            [
                'description' => 'Full-featured plan for large workshops and chains',
                'price' => 124.99,
                'max_users' => null, // Unlimited
                'max_customers' => null, // Unlimited
                'max_searches' => null, // Unlimited
                'is_active' => true,
            ]
        );
    }
}
