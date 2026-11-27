<div class="mb-3">
    <label for="categoria_id" class="form-label">Categoría</label>
    <select name="categoria_id" id="categoria_id"
        class="form-select @error('categoria_id') is-invalid @enderror">
        <option value="">Seleccione una categoría</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                {{ (string) old('categoria_id', $medicine->categoria_id ?? '') === (string) $category->id ? 'selected' : '' }}>
                {{ $category->nombre ?? $category->name }}
            </option>
        @endforeach
    </select>
    @error('categoria_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre del medicamento</label>
    <input type="text" name="nombre" id="nombre"
        class="form-control @error('nombre') is-invalid @enderror"
        value="{{ old('nombre', $medicine->nombre ?? '') }}">
    @error('nombre')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="precio" class="form-label">Precio</label>
    <input type="number" step="0.01" min="0" name="precio" id="precio"
        class="form-control @error('precio') is-invalid @enderror"
        value="{{ old('precio', $medicine->precio ?? '') }}">
    @error('precio')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="stock" class="form-label">Stock</label>
    <input type="number" step="1" min="0" name="stock" id="stock"
        class="form-control @error('stock') is-invalid @enderror"
        value="{{ old('stock', $medicine->stock ?? '') }}">
    @error('stock')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary text-white">Guardar</button>
<a href="{{ route('medicines.index') }}" class="btn btn-secondary">Cancelar</a>