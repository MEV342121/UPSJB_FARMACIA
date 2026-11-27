<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    // Medicamentos que empiezan con poco stock
    private const LOW_STOCK = ['Tramadol 50 mg x 10 cap', 'Cefalexina 500 mg x 10 cap', 'Bloqueador solar FPS 50 60 ml'];

    public function run(): void
    {
        // Categoría => [nombre, precio]
        $medicines = [
            'Analgésicos' => [
                ['Paracetamol 500 mg x 10 tab', 2.50],
                ['Metamizol 500 mg x 10 tab', 3.00],
                ['Aspirina 100 mg x 30 tab', 8.90],
                ['Tramadol 50 mg x 10 cap', 12.50],
            ],
            'Antibióticos' => [
                ['Amoxicilina 500 mg x 10 cap', 6.50],
                ['Azitromicina 500 mg x 3 tab', 9.80],
                ['Ciprofloxacino 500 mg x 10 tab', 7.20],
                ['Cefalexina 500 mg x 10 cap', 8.40],
            ],
            'Antiinflamatorios' => [
                ['Ibuprofeno 400 mg x 10 tab', 3.50],
                ['Naproxeno 550 mg x 10 tab', 5.80],
                ['Diclofenaco 50 mg x 10 tab', 2.90],
                ['Meloxicam 15 mg x 10 tab', 6.20],
            ],
            'Antialérgicos' => [
                ['Loratadina 10 mg x 10 tab', 3.20],
                ['Cetirizina 10 mg x 10 tab', 3.80],
                ['Clorfenamina 4 mg x 20 tab', 2.40],
            ],
            'Antigripales' => [
                ['Panadol Antigripal x 12 tab', 9.50],
                ['Nastizol Compositum x 10 tab', 11.90],
                ['Jarabe para la tos 120 ml', 14.50],
            ],
            'Gastrointestinales' => [
                ['Omeprazol 20 mg x 10 cap', 4.50],
                ['Ranitidina 150 mg x 10 tab', 3.90],
                ['Sal de Andrews x 6 sobres', 6.00],
                ['Suero oral 500 ml', 5.50],
            ],
            'Vitaminas y suplementos' => [
                ['Vitamina C 1 g x 10 tab efervescentes', 12.00],
                ['Complejo B x 30 tab', 15.90],
                ['Calcio + Vitamina D x 30 tab', 24.50],
                ['Sulfato ferroso 300 mg x 30 tab', 9.90],
            ],
            'Dermatológicos' => [
                ['Clotrimazol crema 1% 20 g', 7.50],
                ['Hidrocortisona crema 1% 15 g', 8.90],
                ['Bloqueador solar FPS 50 60 ml', 39.90],
            ],
        ];

        $categories = Category::pluck('id', 'name');

        foreach ($medicines as $category => $items) {
            foreach ($items as [$name, $price]) {
                Medicine::create([
                    'category_id' => $categories[$category],
                    'name' => $name,
                    'price' => $price,
                    // Algunos con stock bajo (≤ 10) para probar el filtro del listado
                    'stock' => in_array($name, self::LOW_STOCK) ? fake()->numberBetween(3, 8) : fake()->numberBetween(80, 300),
                ]);
            }
        }
    }
}
