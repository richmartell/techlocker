<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // UK common first names
        $maleFirstNames = ['James', 'John', 'Robert', 'Michael', 'William', 'David', 'Richard', 'Joseph', 'Thomas', 'Christopher', 'Daniel', 'Matthew', 'Anthony', 'Mark', 'Donald', 'Steven', 'Paul', 'Andrew', 'Joshua', 'Kenneth'];
        $femaleFirstNames = ['Mary', 'Patricia', 'Jennifer', 'Linda', 'Elizabeth', 'Barbara', 'Susan', 'Jessica', 'Sarah', 'Karen', 'Nancy', 'Lisa', 'Betty', 'Helen', 'Sandra', 'Donna', 'Carol', 'Ruth', 'Sharon', 'Michelle'];
        
        // UK common surnames
        $surnames = ['Smith', 'Jones', 'Taylor', 'Williams', 'Brown', 'Davies', 'Evans', 'Wilson', 'Thomas', 'Roberts', 'Johnson', 'Lewis', 'Walker', 'Robinson', 'Wood', 'Thompson', 'White', 'Watson', 'Jackson', 'Wright', 'Green', 'Harris', 'Cooper', 'King', 'Lee', 'Martin', 'Clarke', 'James', 'Morgan', 'Hughes'];
        
        $firstName = $this->faker->randomElement(array_merge($maleFirstNames, $femaleFirstNames));
        $lastName = $this->faker->randomElement($surnames);
        
        // Generate UK phone number
        $phone = $this->generateUKPhone();
        
        // Generate email based on name with various providers
        $emailProviders = ['gmail.com', 'hotmail.co.uk', 'yahoo.co.uk', 'outlook.com', 'btinternet.com', 'sky.com', 'virginmedia.com'];
        $emailProvider = $this->faker->randomElement($emailProviders);
        $email = strtolower($firstName . '.' . $lastName . rand(1, 999) . '@' . $emailProvider);
        
        // Optional tags for segmentation
        $tags = [];
        if ($this->faker->boolean(20)) { // 20% chance of having tags
            $availableTags = ['VIP', 'Trade', 'Fleet', 'Regular', 'New'];
            $tags = $this->faker->randomElements($availableTags, $this->faker->numberBetween(1, 2));
        }
        
        return [
            'account_id' => \App\Models\Account::factory(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $this->faker->boolean(85) ? $email : null, // 85% have email
            'phone' => $this->faker->boolean(95) ? $phone : null, // 95% have phone
            'notes' => $this->faker->boolean(30) ? $this->generateCustomerNotes() : null,
            'tags' => empty($tags) ? null : $tags,
            'source' => $this->faker->randomElement(['web', 'phone', 'walk-in', 'referral']),
            'last_contact_at' => $this->faker->boolean(60) ? $this->faker->dateTimeBetween('-6 months', 'now') : null,
        ];
    }

    /**
     * Generate realistic UK phone numbers.
     */
    private function generateUKPhone(): string
    {
        $formats = [
            // Mobile numbers
            '07' . $this->faker->randomElement(['4', '5', '7', '8', '9']) . $this->faker->numerify('## ######'),
            '07' . $this->faker->randomElement(['4', '5', '7', '8', '9']) . $this->faker->numerify('########'),
            
            // Landline numbers
            '01' . $this->faker->numerify('## ######'),
            '020 ' . $this->faker->numerify('#### ####'), // London
            '0113 ' . $this->faker->numerify('### ####'), // Leeds
            '0114 ' . $this->faker->numerify('### ####'), // Sheffield
            '0115 ' . $this->faker->numerify('### ####'), // Nottingham
            '0116 ' . $this->faker->numerify('### ####'), // Leicester
            '0117 ' . $this->faker->numerify('### ####'), // Bristol
            '0118 ' . $this->faker->numerify('### ####'), // Reading
            '0121 ' . $this->faker->numerify('### ####'), // Birmingham
        ];
        
        return $this->faker->randomElement($formats);
    }

    /**
     * Generate realistic customer notes.
     */
    private function generateCustomerNotes(): string
    {
        $noteTypes = [
            'Prefers morning appointments',
            'Regular customer since 2019',
            'Fleet manager for local company',
            'Retired mechanic - knowledgeable about cars',
            'Young driver - first car',
            'Drives company vehicle',
            'Lives in rural area - may need collection service',
            'Prefers to wait during service',
            'Usually brings wife\'s car too',
            'Works shifts - available afternoons only',
            'Very price conscious',
            'Always books full service package',
            'Interested in electric vehicles',
            'Has mobility issues - may need assistance',
            'Speaks limited English - son translates',
        ];
        
        $additionalNotes = [
            'Last service: replaced brake pads',
            'Mentioned strange noise from engine',
            'MOT due next month',
            'Interested in tyre replacement deals',
            'Asked about winter service package',
            'Recommended by neighbour',
            'Found us through Google',
            'Previous garage closed down',
        ];
        
        $notes = [$this->faker->randomElement($noteTypes)];
        
        if ($this->faker->boolean(40)) {
            $notes[] = $this->faker->randomElement($additionalNotes);
        }
        
        return implode('. ', $notes) . '.';
    }

    /**
     * Create a customer with VIP status.
     */
    public function vip(): static
    {
        return $this->state(fn (array $attributes) => [
            'tags' => ['VIP'],
            'notes' => 'VIP customer - priority service. ' . ($attributes['notes'] ?? ''),
            'source' => 'referral',
        ]);
    }

    /**
     * Create a trade customer.
     */
    public function trade(): static
    {
        return $this->state(fn (array $attributes) => [
            'tags' => ['Trade'],
            'notes' => 'Trade customer - invoice account. ' . ($attributes['notes'] ?? ''),
            'source' => 'referral',
        ]);
    }

    /**
     * Create a customer without email.
     */
    public function withoutEmail(): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => null,
        ]);
    }

    /**
     * Create a customer without phone.
     */
    public function withoutPhone(): static
    {
        return $this->state(fn (array $attributes) => [
            'phone' => null,
            'phone_e164' => null,
        ]);
    }
}
