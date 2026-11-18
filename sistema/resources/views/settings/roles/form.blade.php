<div class="mb-3">
    <label for="name" class="form-label">Nombre</label>
    <input type="text" name="name" id="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $role->name ?? '') }}">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descripcion</label>
    <textarea name="description" id="description" rows="3"
        class="form-control @error('description') is-invalid @enderror">
        {{ old('description', $role->description ?? '') }}
    </textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary text-white">Guardar</button>
<a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>