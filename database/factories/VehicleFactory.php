<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Common UK vehicle makes and models
        $makeModels = [
            'FORD' => ['FIESTA', 'FOCUS', 'MONDEO', 'KUGA', 'TRANSIT'],
            'VAUXHALL' => ['CORSA', 'ASTRA', 'INSIGNIA', 'CROSSLAND', 'VIVARO'],
            'VOLKSWAGEN' => ['GOLF', 'POLO', 'PASSAT', 'TIGUAN', 'CADDY'],
            'BMW' => ['3 SERIES', '5 SERIES', 'X3', 'X5', '1 SERIES'],
            'AUDI' => ['A3', 'A4', 'A6', 'Q3', 'Q5'],
            'MERCEDES-BENZ' => ['C-CLASS', 'E-CLASS', 'A-CLASS', 'GLC', 'SPRINTER'],
            'TOYOTA' => ['YARIS', 'COROLLA', 'CAMRY', 'RAV4', 'PRIUS'],
            'NISSAN' => ['MICRA', 'QASHQAI', 'JUKE', 'X-TRAIL', 'LEAF'],
            'PEUGEOT' => ['208', '308', '3008', '5008', 'PARTNER'],
            'RENAULT' => ['CLIO', 'MEGANE', 'CAPTUR', 'KADJAR', 'TRAFIC'],
            'HONDA' => ['CIVIC', 'ACCORD', 'CR-V', 'HR-V', 'JAZZ'],
            'HYUNDAI' => ['I10', 'I20', 'I30', 'TUCSON', 'SANTA FE'],
            'KIA' => ['PICANTO', 'RIO', 'CEED', 'SPORTAGE', 'SORENTO'],
            'LAND ROVER' => ['DISCOVERY SPORT', 'RANGE ROVER EVOQUE', 'DEFENDER', 'FREELANDER'],
            'MINI' => ['COOPER', 'COUNTRYMAN', 'CLUBMAN', 'CONVERTIBLE'],
        ];
        
        $make = $this->faker->randomElement(array_keys($makeModels));
        $model = $this->faker->randomElement($makeModels[$make]);
        
        // Generate UK registration plate
        $registration = $this->generateUKRegistration();
        
        // Generate realistic vehicle data
        $yearOfManufacture = $this->faker->numberBetween(2008, 2023);
        $engineCapacity = $this->generateEngineCapacity($make);
        $fuelType = $this->faker->randomElement(['PETROL', 'DIESEL', 'ELECTRIC', 'HYBRID']);
        
        // Common UK vehicle colours
        $colours = ['WHITE', 'BLACK', 'SILVER', 'GREY', 'BLUE', 'RED', 'GREEN', 'YELLOW', 'ORANGE', 'PURPLE', 'BROWN', 'PINK'];
        
        return [
            'account_id' => \App\Models\Account::factory(),
            'registration' => $registration,
            'name' => $make . ' ' . $model,
            'colour' => $this->faker->randomElement($colours),
            'engine_capacity' => $engineCapacity,
            'fuel_type' => $fuelType,
            'year_of_manufacture' => $yearOfManufacture,
            'co2_emissions' => $this->faker->numberBetween(95, 250),
            'marked_for_export' => false,
            'month_of_first_registration' => $this->faker->numberBetween(1, 12),
            'mot_status' => $this->faker->randomElement(['Valid', 'Not valid', 'No details held']),
            'revenue_weight' => $this->faker->numberBetween(1000, 3500),
            'tax_due_date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'tax_status' => $this->faker->randomElement(['Taxed', 'Untaxed', 'SORN']),
            'type_approval' => 'M1',
            'wheelplan' => $this->faker->randomElement(['2 AXLE RIGID BODY', '3 AXLE RIGID BODY']),
            'euro_status' => $this->faker->randomElement(['EURO 5', 'EURO 6']),
            'transmission' => $this->faker->randomElement(['MANUAL', 'AUTOMATIC']),
            'forward_gears' => $this->faker->numberBetween(5, 8),
            'combined_vin' => $this->generateVIN(),
            'dvla_date_of_manufacture' => $yearOfManufacture . '-' . sprintf('%02d', $this->faker->numberBetween(1, 12)) . '-' . sprintf('%02d', $this->faker->numberBetween(1, 28)),
            'dvla_last_mileage' => $this->faker->numberBetween(5000, 150000),
            'dvla_last_mileage_date' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'last_dvla_sync_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Generate a realistic UK registration plate.
     */
    private function generateUKRegistration(): string
    {
        // Modern UK format: AA00 AAA (2001 onwards)
        $letters1 = $this->faker->randomLetter . $this->faker->randomLetter;
        $numbers = sprintf('%02d', $this->faker->numberBetween(1, 71)); // 01-71 for different periods
        $letters2 = $this->faker->randomLetter . $this->faker->randomLetter . $this->faker->randomLetter;
        
        return strtoupper($letters1 . $numbers . ' ' . $letters2);
    }

    /**
     * Generate VIN number.
     */
    private function generateVIN(): string
    {
        $chars = 'ABCDEFGHJKLMNPRSTUVWXYZ1234567890';
        $vin = '';
        for ($i = 0; $i < 17; $i++) {
            $vin .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $vin;
    }

    /**
     * Generate realistic engine capacity based on make.
     */
    private function generateEngineCapacity(string $make): int
    {
        $capacityRanges = [
            'FORD' => [1000, 1100, 1200, 1400, 1500, 1600, 2000, 2300],
            'VAUXHALL' => [1000, 1200, 1400, 1600, 1800, 2000],
            'BMW' => [1500, 1600, 1800, 2000, 2500, 3000, 3500],
            'AUDI' => [1400, 1600, 1800, 2000, 2500, 3000],
            'MERCEDES-BENZ' => [1600, 1800, 2000, 2200, 2500, 3000, 3500],
            'TOYOTA' => [1000, 1200, 1400, 1600, 1800, 2000, 2400],
            'DEFAULT' => [1000, 1200, 1400, 1600, 1800, 2000],
        ];
        
        $capacities = $capacityRanges[$make] ?? $capacityRanges['DEFAULT'];
        return $this->faker->randomElement($capacities);
    }

    /**
     * Create an electric vehicle.
     */
    public function electric(): static
    {
        return $this->state(fn (array $attributes) => [
            'fuel_type' => 'ELECTRIC',
            'engine_capacity' => 0,
            'co2_emissions' => 0,
            'transmission' => 'AUTOMATIC',
        ]);
    }

    /**
     * Create a hybrid vehicle.
     */
    public function hybrid(): static
    {
        return $this->state(fn (array $attributes) => [
            'fuel_type' => 'HYBRID',
            'co2_emissions' => $this->faker->numberBetween(20, 120),
        ]);
    }

    /**
     * Create an old vehicle (pre-2010).
     */
    public function old(): static
    {
        return $this->state(fn (array $attributes) => [
            'year_of_manufacture' => $this->faker->numberBetween(1995, 2009),
            'euro_status' => $this->faker->randomElement(['EURO 3', 'EURO 4']),
            'dvla_last_mileage' => $this->faker->numberBetween(80000, 250000),
        ]);
    }

    /**
     * Create a newer vehicle (2020+).
     */
    public function newer(): static
    {
        return $this->state(fn (array $attributes) => [
            'year_of_manufacture' => $this->faker->numberBetween(2020, 2023),
            'euro_status' => 'EURO 6',
            'dvla_last_mileage' => $this->faker->numberBetween(100, 25000),
        ]);
    }

    /**
     * Create a commercial vehicle.
     */
    public function commercial(): static
    {
        $commercialMakes = ['FORD TRANSIT', 'MERCEDES SPRINTER', 'VAUXHALL VIVARO', 'RENAULT TRAFIC', 'VOLKSWAGEN CRAFTER'];
        
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->randomElement($commercialMakes),
            'engine_capacity' => $this->faker->randomElement([2000, 2200, 2500, 3000]),
            'fuel_type' => 'DIESEL',
            'revenue_weight' => $this->faker->numberBetween(2500, 7500),
            'type_approval' => 'N1',
        ]);
    }
}
