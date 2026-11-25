{{-- Formulario compartido por create y edit.
     old('campo', $supplier->campo ?? '') muestra lo escrito si la validación falló,
     el valor guardado al editar o un valor vacío al crear. --}}
<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <label for="name" class="form-label">Razón social</label>
        <input type="text" name="name" id="name" maxlength="100" required
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $supplier->name ?? '') }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6 mb-3">
        <label for="ruc" class="form-label">RUC</label>
        <input type="text" name="ruc" id="ruc" inputmode="numeric" maxlength="11" required
            class="form-control @error('ruc') is-invalid @enderror"
            value="{{ old('ruc', $supplier->ruc ?? '') }}">
        @error('ruc')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6 mb-3">
        <label for="phone" class="form-label">Teléfono</label>
        <input type="text" name="phone" id="phone" inputmode="numeric" maxlength="9"
            class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone', $supplier->phone ?? '') }}">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6 mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" name="email" id="email" maxlength="100"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $supplier->email ?? '') }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 mb-3">
        <label for="address" class="form-label">Dirección</label>
        <textarea name="address" id="address" rows="3" maxlength="150"
            class="form-control @error('address') is-invalid @enderror">{{ old('address', $supplier->address ?? '') }}</textarea>
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<button type="submit" class="btn btn-primary text-white">Guardar</button>
<a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancelar</a>
