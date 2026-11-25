<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Distribuidora Andina Salud S.A.C.',
                'ruc' => '20000000001',
                'phone' => '900000001',
                'email' => 'ventas@andinasalud.test',
                'address' => 'Av. Los Olivos 120, Lima',
            ],
            [
                'name' => 'Suministros Farmacéuticos del Valle S.A.C.',
                'ruc' => '20000000002',
                'phone' => '900000002',
                'email' => 'pedidos@farmaval.test',
                'address' => 'Jr. Las Gardenias 245, Arequipa',
            ],
            [
                'name' => 'Laboratorios Buenavista S.R.L.',
                'ruc' => '20000000003',
                'phone' => '900000003',
                'email' => 'contacto@buenavista.test',
                'address' => 'Calle Los Pinos 580, Cusco',
            ],
            [
                'name' => 'Comercializadora Botica Verde S.A.C.',
                'ruc' => '20000000004',
                'phone' => '900000004',
                'email' => 'ventas@boticaverde.test',
                'address' => 'Av. Primavera 810, Trujillo',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
