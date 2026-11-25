<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Analgésicos', 'description' => 'Alivian el dolor'],
            ['name' => 'Antibióticos', 'description' => 'Tratan infecciones bacterianas'],
            ['name' => 'Antiinflamatorios', 'description' => 'Reducen la inflamación'],
            ['name' => 'Antialérgicos', 'description' => 'Controlan reacciones alérgicas'],
            ['name' => 'Antigripales', 'description' => 'Alivian síntomas del resfrío y la gripe'],
            ['name' => 'Gastrointestinales', 'description' => 'Tratan problemas digestivos'],
            ['name' => 'Vitaminas y suplementos', 'description' => 'Complementos nutricionales'],
            ['name' => 'Dermatológicos', 'description' => 'Cuidado y tratamiento de la piel'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
