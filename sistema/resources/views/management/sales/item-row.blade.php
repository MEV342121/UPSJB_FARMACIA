{{-- Una fila del detalle de venta.
     items[0][medicine_id], items[1][medicine_id]... llegan al controlador como un arreglo $request->items.
     data-price guarda el precio para que JavaScript calcule el subtotal en pantalla. --}}
<tr>
    <td>
        <select name="items[{{ $index }}][medicine_id]" class="form-select form-select-sm">
            <option value="" data-price="0">-- Seleccione --</option>
            @foreach ($medicines as $medicine)
                <option value="{{ $medicine->id }}" data-price="{{ $medicine->price }}"
                    @selected(($item['medicine_id'] ?? '') == $medicine->id)>
                    {{ $medicine->name }} (stock: {{ $medicine->stock }})
                </option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="number" name="items[{{ $index }}][amount]" min="1"
            class="form-control form-control-sm text-center" value="{{ $item['amount'] ?? 1 }}">
    </td>
    <td class="text-end price">S/ 0.00</td>
    <td class="text-end subtotal">S/ 0.00</td>
    <td class="text-center">
        <button type="button" class="btn btn-sm btn-outline-danger remove-item" title="Quitar">
            <i class="bi bi-trash"></i>
        </button>
    </td>
</tr>
