<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\VehicleJob;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehicleJob>
 */
class VehicleJobFactory extends Factory
{
    protected $model = VehicleJob::class;

    public function definition(): array
    {
        $startAt = $this->faker->optional(0.8)->dateTimeBetween('-30 days', '+30 days');
        $endAt = $startAt ? $this->faker->optional(0.6)->dateTimeBetween($startAt, $startAt->format('Y-m-d H:i:s').' +8 hours') : null;

        return [
            'account_id' => Account::factory(),
            'vehicle_id' => Vehicle::factory(),
            'title' => $this->faker->randomElement([
                'Annual Service',
                'MOT Test',
                'Brake Inspection',
                'Oil Change',
                'Tyre Replacement',
                'Battery Test',
                'Clutch Repair',
                'Engine Diagnostics',
                'Suspension Check',
                'Exhaust Repair',
            ]),
            'description' => $this->faker->optional(0.7)->paragraph(),
            'status' => $this->faker->randomElement(['scheduled', 'in_progress', 'completed', 'cancelled']),
            'start_at' => $startAt,
            'end_at' => $endAt,
        ];
    }

    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'scheduled',
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_progress',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }
}