<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => strtoupper($this->faker->name),
            'role' => 3,
            'address_id' => 1,
            'contactnumber' => '09312158479',
            'email' => $this->faker->email,
            'email_verified_at' => now(),
            'password' => Hash::make($this->faker->email), // password
            'remember_token' => Str::random(10),
            // 'name' => 'JEROME BAHIAN PORCADO',
            // 'role' => 1,
            // 'address_id' => 1,
            // 'contactnumber' => '09312158479',
            // 'email' => 'porcadojerome@gmail.com',
            // 'email_verified_at' => now(),
            // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
