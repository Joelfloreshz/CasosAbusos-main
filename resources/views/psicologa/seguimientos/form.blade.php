{{-- resources/views/psicologa/seguimientos/form.blade.php --}}
@csrf

<div class="row g-3">
    <div class="col-12">
        <label for="descripcion" class="form-label">Descripción del seguimiento <span class="text-danger">*</span></label>
        <textarea name="descripcion"
                  id="descripcion"
                  rows="4"
                  class="form-control @error('descripcion') is-invalid @enderror"
                  placeholder="Detalles de la intervención o seguimiento"
                  required>{{ old('descripcion', $seguimiento->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="date"
               id="fecha"
               name="fecha"
               value="{{ old('fecha', isset($seguimiento->fecha) ? $seguimiento->fecha->format('Y-m-d') : now()->format('Y-m-d')) }}"
               class="form-control @error('fecha') is-invalid @enderror">
        @error('fecha')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="adjunto" class="form-label">Archivo adjunto</label>
        <input type="file"
               id="adjunto"
               name="adjunto"
               class="form-control @error('adjunto') is-invalid @enderror"
               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
        @error('adjunto')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Guardar seguimiento
        </button>
    </div>
</div>
