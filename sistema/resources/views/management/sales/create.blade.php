{{-- Hereda la plantilla padre: menú, encabezado y estilos --}}
@extends('template.administrador')

{{-- Rellena los huecos (@yield) de la plantilla --}}
@section('title', 'Ventas')
@section('name_section', 'Ventas')
@section('description', 'Registrar nueva venta')
@section('item_section', 'Nueva')
@section('route_section', route('sales.index'))
@section('section', 'Ventas')
@section('module', 'Gestión')

{{-- Ventas: no hay edit; se registra, se consulta y, si hace falta, se anula --}}
@section('content')
<div class="card bg-white border-0 shadow-sm border-5 border-top border-secondary">
    <div class="card-body">
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf {{-- token de seguridad; sin él aparece el error 419 --}}

            {{-- Datos generales --}}
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="customer_id" class="form-label">Cliente</label>
                    <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror">
                        <option value="">-- Seleccione --</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                                {{ $customer->name }} - DNI {{ $customer->dni }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="user_id" class="form-label">Vendedor</label>
                    <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror">
                        <option value="">-- Seleccione --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Detalle de productos --}}
            <h6 class="text-uppercase small text-muted mt-2 mb-2">Medicamentos</h6>

            {{-- Errores del detalle: falta de productos, repetidos o stock insuficiente --}}
            @if ($errors->has('items') || $errors->has('items.*'))
                <div class="alert alert-danger py-2">
                    @foreach ($errors->get('items*') as $messages)
                        @foreach ((array) $messages as $message)
                            <div>{{ $message }}</div>
                        @endforeach
                    @endforeach
                </div>
            @endif

            <table class="table table-sm align-middle">
                <thead>
                    <tr>
                        <th class="small text-uppercase">Medicamento</th>
                        <th class="small text-uppercase text-center" style="width: 120px">Cantidad</th>
                        <th class="small text-uppercase text-end" style="width: 120px">Precio</th>
                        <th class="small text-uppercase text-end" style="width: 120px">Subtotal</th>
                        <th style="width: 50px"></th>
                    </tr>
                </thead>
                <tbody id="items">
                    {{-- Si la validación falla, se vuelven a mostrar las filas enviadas --}}
                    @foreach (old('items', []) as $i => $item)
                        @include('management.sales.item-row', ['index' => $i, 'item' => $item])
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-semibold">Total (incluye IGV)</td>
                        <td class="text-end fw-bold" id="total">S/ 0.00</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <button type="button" id="add-item" class="btn btn-outline-primary btn-sm mb-4">
                <i class="bi bi-plus-lg me-1"></i>Agregar medicamento
            </button>

            <div>
                <button type="submit" class="btn btn-primary text-white">Registrar venta</button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

{{-- Plantilla de una fila vacía (la copia el JavaScript) --}}
<template id="item-template">
    @include('management.sales.item-row', ['index' => '__INDEX__', 'item' => []])
</template>
@endsection

@push('scripts')
<script>
    const tbody = document.getElementById('items');
    const template = document.getElementById('item-template').innerHTML;
    // Siguiente índice libre: uno más que el mayor índice enviado (si se quitó una fila, no se repite)
    let index = {{ old('items') ? max(array_keys(old('items'))) + 1 : 0 }};

    // Recalcula subtotales y total
    function recalculate() {
        let total = 0;
        tbody.querySelectorAll('tr').forEach(row => {
            const option = row.querySelector('select').selectedOptions[0];
            const price = parseFloat(option?.dataset.price || 0);
            const amount = parseInt(row.querySelector('input').value || 0);
            const subtotal = price * amount;

            row.querySelector('.price').textContent = 'S/ ' + price.toFixed(2);
            row.querySelector('.subtotal').textContent = 'S/ ' + subtotal.toFixed(2);
            total += subtotal;
        });
        document.getElementById('total').textContent = 'S/ ' + total.toFixed(2);
    }

    // Agregar una fila nueva
    document.getElementById('add-item').addEventListener('click', () => {
        tbody.insertAdjacentHTML('beforeend', template.replaceAll('__INDEX__', index++));
    });

    // Quitar una fila
    tbody.addEventListener('click', e => {
        if (e.target.closest('.remove-item')) {
            e.target.closest('tr').remove();
            recalculate();
        }
    });

    // Recalcular al cambiar medicamento o cantidad
    tbody.addEventListener('input', recalculate);

    // Empieza con una fila si no hay ninguna
    if (index === 0) document.getElementById('add-item').click();
    recalculate();
</script>
@endpush
