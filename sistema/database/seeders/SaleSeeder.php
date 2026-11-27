<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Medicine;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Genera ventas de los últimos 90 días con entre 1 y 4 medicamentos cada una.
 * Sigue las mismas reglas que SaleController@store: precio de la base de datos,
 * descuento de stock e IGV incluido en el precio (total × 18 / 118).
 */
class SaleSeeder extends Seeder
{
    private const TOTAL_SALES = 60;

    public function run(): void
    {
        $customers = Customer::all();
        $users = User::all();

        for ($i = 0; $i < self::TOTAL_SALES; $i++) {
            // Solo medicamentos que aún tienen stock
            $available = Medicine::where('stock', '>', 0)->get();

            if ($available->isEmpty()) {
                break;
            }

            $sale = Sale::create([
                'customer_id' => $customers->random()->id,
                'user_id' => $users->random()->id,
                'date' => now()->subDays(fake()->numberBetween(0, 90))
                    ->setTime(fake()->numberBetween(8, 21), fake()->numberBetween(0, 59)),
                'total' => 0,
                'igv' => 0,
            ]);

            $total = 0;

            foreach ($available->random(min(fake()->numberBetween(1, 4), $available->count())) as $medicine) {
                $amount = min(fake()->numberBetween(1, 5), $medicine->stock);
                $subtotal = $medicine->price * $amount;

                $sale->details()->create([
                    'medicine_id' => $medicine->id,
                    'amount' => $amount,
                    'price_unit' => $medicine->price,
                    'subtotal' => $subtotal,
                ]);

                $medicine->decrement('stock', $amount);
                $total += $subtotal;
            }

            $sale->update([
                'total' => $total,
                'igv' => round($total * 18 / 118, 2),
            ]);
        }
    }
}
