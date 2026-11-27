<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // Pantalla del reporte: filtros, resumen, gráfico (Chart.js) y tabla
    public function sales(Request $request)
    {
        [$sales, $from, $to] = $this->filteredSales($request);

        $summary = $this->summary($sales);

        // Datos para el gráfico: total por día dentro del rango
        $chart = $sales->groupBy(fn ($sale) => $sale->date->format('d/m'))
            ->map(fn ($group) => round($group->sum('total'), 2));

        // Listas para los <select> de los filtros
        $customers = Customer::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('principal.reports.sales', compact(
            'sales', 'summary', 'chart', 'from', 'to', 'customers', 'users', 'categories'
        ));
    }

    // Exportar a PDF con DOMPDF (barryvdh/laravel-dompdf), con los mismos filtros
    public function salesPdf(Request $request)
    {
        [$sales, $from, $to] = $this->filteredSales($request);

        $summary = $this->summary($sales);
        $filters = $this->filterLabels($request);

        return Pdf::loadView('principal.reports.sales-pdf', compact('sales', 'summary', 'from', 'to', 'filters'))
            ->setPaper('a4', 'portrait')
            ->download("reporte-ventas-{$from}-{$to}.pdf");
    }

    // Exportar a Excel con maatwebsite/excel, con los mismos filtros
    public function salesExcel(Request $request)
    {
        [$sales, $from, $to] = $this->filteredSales($request);

        return Excel::download(new SalesExport($sales), "reporte-ventas-{$from}-{$to}.xlsx");
    }

    // Valida los filtros y arma la consulta (la usan la pantalla, el PDF y el Excel)
    private function filteredSales(Request $request): array
    {
        // Todos son opcionales; si no llegan fechas, se usa el mes actual
        $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date|after_or_equal:from',
            'customer_id' => 'nullable|exists:customers,id',
            'user_id' => 'nullable|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $from = $request->input('from') ?: now()->startOfMonth()->toDateString();
        $to = $request->input('to') ?: now()->toDateString();

        // Filtros dinámicos: cada when() se aplica solo si el filtro tiene valor
        $sales = Sale::with(['customer', 'user'])
            ->whereBetween('date', [$from.' 00:00:00', $to.' 23:59:59']) // incluye todo el último día
            ->when($request->customer_id, fn ($q, $id) => $q->where('customer_id', $id))
            ->when($request->user_id, fn ($q, $id) => $q->where('user_id', $id))
            // whereHas: ventas que tienen AL MENOS un detalle de un medicamento de esa categoría
            ->when($request->category_id, fn ($q, $id) => $q->whereHas(
                'details.medicine', fn ($m) => $m->where('category_id', $id)
            ))
            ->orderBy('date')
            ->get();

        return [$sales, $from, $to];
    }

    // Totales del reporte (sobre la colección ya filtrada)
    private function summary($sales): array
    {
        return [
            'count' => $sales->count(),
            'total' => $sales->sum('total'),
            'igv' => $sales->sum('igv'),
            'average' => $sales->avg('total') ?? 0,
        ];
    }

    // Textos de los filtros elegidos, para mostrarlos en el PDF
    private function filterLabels(Request $request): array
    {
        return [
            'Cliente' => $request->customer_id ? Customer::find($request->customer_id)?->name : 'Todos',
            'Vendedor' => $request->user_id ? User::find($request->user_id)?->name : 'Todos',
            'Categoría' => $request->category_id ? Category::find($request->category_id)?->name : 'Todas',
        ];
    }
}
