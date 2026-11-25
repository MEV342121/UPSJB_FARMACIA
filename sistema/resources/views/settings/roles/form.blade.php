{{-- Formulario compartido por create y edit.
     old('campo', $role->campo ?? '') muestra: lo que el usuario escribió si la validación falló,
     o el valor guardado al editar, o vacío al crear. --}}
<div class="mb-3">
    <label for="name" class="form-label">Nombre del rol</label>
    <input type="text" name="name" id="name" maxlength="50"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $role->name ?? '') }}">
    {{-- @error muestra el mensaje de validación de ese campo --}}
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descripción</label>
    <textarea name="description" id="description" rows="3"
        class="form-control @error('description') is-invalid @enderror">{{ old('description', $role->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary text-white">Guardar</button>
<a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
