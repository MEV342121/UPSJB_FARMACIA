{{-- Formulario compartido por create y edit.
     old('campo', $customer->campo ?? '') muestra: lo que el usuario escribió si la validación falló,
     o el valor guardado al editar, o vacío al crear. --}}
<div class="row">
    <div class="col-12 mb-3">
        <label for="name" class="form-label">Nombre completo</label>
        {{-- maxlength igual a la columna de la migración: string('name', 50) --}}
        <input type="text" name="name" id="name" maxlength="50"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $customer->name ?? '') }}">
        {{-- @error muestra el mensaje de validación de ese campo --}}
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-4 mb-3">
        <label for="dni" class="form-label">DNI</label>
        {{-- maxlength ayuda en el navegador; la regla digits:8 es la que de verdad valida --}}
        <input type="text" name="dni" id="dni" maxlength="8"
            class="form-control @error('dni') is-invalid @enderror"
            value="{{ old('dni', $customer->dni ?? '') }}">
        @error('dni')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-4 mb-3">
        <label for="phone" class="form-label">Teléfono <small class="text-muted">(opcional)</small></label>
        <input type="text" name="phone" id="phone" maxlength="9"
            class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone', $customer->phone ?? '') }}">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-4 mb-3">
        <label for="age" class="form-label">Edad <small class="text-muted">(opcional)</small></label>
        <input type="number" name="age" id="age" min="0" max="120"
            class="form-control @error('age') is-invalid @enderror"
            value="{{ old('age', $customer->age ?? '') }}">
        @error('age')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<button type="submit" class="btn btn-primary text-white">Guardar</button>
<a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancelar</a>
