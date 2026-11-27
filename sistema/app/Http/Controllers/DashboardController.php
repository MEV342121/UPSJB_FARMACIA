<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Medicine;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── 1. Indicadores (tarjetas)
        $salesToday = Sale::whereDate('date', today())->sum('total');
        $salesMonth = Sale::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->sum('total');
        $customers = Customer::count();
        $lowStock = Medicine::where('stock', '<=', 10)->count();

        // ── 2. Ventas de los últimos 7 días (una sola tabla, agrupada por día)
        // SQL: SELECT DATE(date) AS day, SUM(total) AS total FROM sales
        //      WHERE date >= ? GROUP BY day ORDER BY day
        $perDay = Sale::selectRaw('DATE(date) as day, SUM(total) as total')
            ->where('date', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day'); // ['2026-11-24' => 85.50, ...]

        // Un día sin ventas no aparece en la consulta: se completa con 0
        $days = [];
        $totals = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $days[] = $day->format('d/m');
            $totals[] = (float) ($perDay[$day->toDateString()] ?? 0);
        }

        // ── 3. Ventas del mes por categoría (tres tablas unidas con JOIN)
        $byCategory = DB::table('detail_sales')
            ->join('medicines', 'medicines.id', '=', 'detail_sales.medicine_id')
            ->join('categories', 'categories.id', '=', 'medicines.category_id')
            ->join('sales', 'sales.id', '=', 'detail_sales.sale_id')
            ->whereBetween('sales.date', [now()->startOfMonth(), now()->endOfMonth()])
            ->select('categories.name', DB::raw('SUM(detail_sales.subtotal) as total'))
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->get();

        // ── 4. Los 5 medicamentos más vendidos del mes (unidades vendidas)
        $topMedicines = DB::table('detail_sales')
            ->join('medicines', 'medicines.id', '=', 'detail_sales.medicine_id')
            ->join('sales', 'sales.id', '=', 'detail_sales.sale_id')
            ->whereBetween('sales.date', [now()->startOfMonth(), now()->endOfMonth()])
            ->select('medicines.name', DB::raw('SUM(detail_sales.amount) as units'))
            ->groupBy('medicines.name')
            ->orderByDesc('units')
            ->limit(5)
            ->get();

        return view('principal.dashboard.index', compact(
            'salesToday', 'salesMonth', 'customers', 'lowStock',
            'days', 'totals', 'byCategory', 'topMedicines'
        ));
    }
}
