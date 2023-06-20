<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
// use Faker\Generator as Faker;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Address::factory(1)->create();
        // \App\Models\User::factory(1)->create();
        \App\Models\User::factory()->create([
            'name' => 'JEROME BAHIAN PORCADO',
            'role' => 1,
            'address_id' => 1,
            'contactnumber' => '09312158479',
            'email' => 'porcadojerome@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory()->create([
            'name' => 'JOHN PAUL ABARECE',
            'role' => 2,
            'address_id' => 1,
            'contactnumber' => '09312158479',
            'email' => 'johnpaul@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory(9)->create();
        \App\Models\Services::factory(1)->create();
        \App\Models\Deceased::factory(20)->create();
        \App\Models\ContactPerson::factory()->count(10)->create();
        \App\Models\Block::factory()->count(10)->create();
    }
}
