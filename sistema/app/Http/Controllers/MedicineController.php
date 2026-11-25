<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    // Unidades a partir de las cuales el stock se considera bajo
    const LOW_STOCK = 10;

    // Listado de medicamentos con búsqueda y filtros
    public function index(Request $request)
    {
        $medicines = Medicine::with('category')                          // carga la categoría en 1 sola consulta (evita N+1)
            ->when($request->search, function ($query, $search) {        // solo si escribió algo en el buscador
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($request->category_id, function ($query, $categoryId) { // solo si eligió una categoría
                $query->where('category_id', $categoryId);
            })
            ->when($request->boolean('low_stock'), function ($query) {    // solo si marcó "stock bajo"
                $query->where('stock', '<=', self::LOW_STOCK);
            })
            ->orderBy('name')
            ->get();

        // Para llenar el <select> del filtro
        $categories = Category::orderBy('name')->get();
        $lowStock = self::LOW_STOCK;

        return view('management.medicines.index', compact('medicines', 'categories', 'lowStock'));
    }

    // Formulario para crear
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('management.medicines.create', compact('categories'));
    }

    // Guardar nuevo medicamento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:120',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // máx. 2 MB
        ]);

        // Si subió una imagen, se guarda en storage/app/public/medicines
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('medicines', 'public');
        }

        Medicine::create($validated);

        return to_route('medicines.index')->with('ok', 'Medicamento registrado');
    }

    // Formulario para editar
    public function edit(Medicine $medicine)
    {
        $categories = Category::orderBy('name')->get();

        return view('management.medicines.edit', compact('medicine', 'categories'));
    }

    // Actualizar medicamento
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:120',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Borra la imagen anterior y guarda la nueva
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            $validated['image'] = $request->file('image')->store('medicines', 'public');
        } else {
            // Si no subió imagen nueva, se mantiene la actual
            unset($validated['image']);
        }

        $medicine->update($validated);

        return to_route('medicines.index')->with('ok', 'Medicamento actualizado');
    }

    // Eliminar medicamento (solo si no se ha vendido)
    public function destroy(Medicine $medicine)
    {
        if ($medicine->detailSales()->exists()) {
            return to_route('medicines.index')->with('error', 'No se puede eliminar el medicamento porque tiene ventas registradas');
        }

        // Borra también su imagen
        if ($medicine->image) {
            Storage::disk('public')->delete($medicine->image);
        }

        $medicine->delete();

        return to_route('medicines.index')->with('ok', 'Medicamento eliminado');
    }
}
