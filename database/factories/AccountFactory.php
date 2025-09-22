<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate realistic garage business names
        $businessTypes = ['Motors', 'Auto', 'Garage', 'Service Centre', 'Automotive', 'Car Care', 'Vehicle Services'];
        $descriptors = ['Main Street', 'City', 'Premium', 'Express', 'Professional', 'Quality', 'Reliable', 'Fast Lane'];
        
        $businessType = $this->faker->randomElement($businessTypes);
        $descriptor = $this->faker->randomElement($descriptors);
        $companyName = $descriptor . ' ' . $businessType;
        
        // Generate UK-style address
        $streetNames = ['High Street', 'Main Road', 'Church Lane', 'Victoria Road', 'Kings Road', 'Mill Lane', 'Station Road'];
        $towns = ['Manchester', 'Birmingham', 'Liverpool', 'Leeds', 'Sheffield', 'Bristol', 'Newcastle', 'Nottingham', 'Leicester', 'Coventry'];
        $counties = ['Greater Manchester', 'West Midlands', 'Merseyside', 'West Yorkshire', 'South Yorkshire', 'Avon', 'Tyne and Wear', 'Nottinghamshire', 'Leicestershire', 'West Midlands'];
        
        $streetNumber = $this->faker->numberBetween(1, 999);
        $streetName = $this->faker->randomElement($streetNames);
        $town = $this->faker->randomElement($towns);
        $county = $this->faker->randomElement($counties);
        $postCode = strtoupper($this->faker->regexify('[A-Z]{1,2}[0-9]{1,2} [0-9][A-Z]{2}'));
        
        // Generate UK phone numbers
        $areaCode = '01' . $this->faker->numberBetween(200, 999);
        $phoneNumber = $areaCode . ' ' . $this->faker->numberBetween(100000, 999999);
        
        // Generate email from company name
        $emailDomain = strtolower(str_replace(' ', '', $companyName)) . '.co.uk';
        $companyEmail = 'info@' . $emailDomain;
        
        // Generate website
        $webAddress = 'https://www.' . $emailDomain;
        
        return [
            'company_name' => $companyName,
            'registered_address' => $streetNumber . ' ' . $streetName,
            'town' => $town,
            'county' => $county,
            'post_code' => $postCode,
            'country' => 'United Kingdom',
            'vat_number' => 'GB' . $this->faker->numerify('#########'),
            'company_phone' => $phoneNumber,
            'company_email' => $companyEmail,
            'web_address' => $webAddress,
            'is_active' => true,
        ];
    }
}
