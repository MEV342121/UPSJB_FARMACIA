<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = fake('es_PE'); // nombres peruanos

        for ($i = 0; $i < 40; $i++) {
            $name = $faker->firstName() . ' ' . $faker->lastName() . ' ' . $faker->lastName();

            Customer::create([
                'name' => mb_substr($name, 0, 50), // la columna admite 50 caracteres
                'dni' => $faker->unique()->numerify('########'),
                'phone' => $faker->optional(0.8)->numerify('9########'),
                'age' => $faker->numberBetween(18, 85),
            ]);
        }
    }
}
