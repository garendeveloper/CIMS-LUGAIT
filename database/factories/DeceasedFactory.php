<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
// use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deceased>
 */
class DeceasedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    

    public function definition(): array
    {
        return [
            'service_id' => 1,
            'address_id' => 1,
            'causeofdeath' => $this->faker->randomElement(['A', 'H', 'N', 'U', 'O']),
            'lastname' => strtoupper($this->faker->lastname),
            'firstname' => strtoupper($this->faker->firstname),
            'middlename' => strtoupper($this->faker->lastname),
            'suffix' => $this->faker->randomElement(['N', 'I', 'III', 'IV', 'V']),
            'civilstatus' => $this->faker->randomElement(['S', 'M', 'D', 'W']),
            'sex' => $this->faker->randomElement(['M', 'F']),
            'dateof_death' => date('Y-m-d'),
            'dateof_burial' => date('Y-m-d'),
            'burial_time' => now()->format('H:i:s'),
            'dateofbirth' => date('Y-m-d'),
        ];
    }
}
