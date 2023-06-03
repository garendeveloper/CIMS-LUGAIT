<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'region_no' => 1,
            'region' =>  'REGION I (ILOCOS REGION)',
            'province_no' => 129,
            'province' => 'ILOCOS SUR',
            'city_no' => 12918,
            'city' => 'SAN ESTEBAN',
            'barangay_no' => 12918006,
            'barangay' => 'POBLACION',
        ];
    }
}
