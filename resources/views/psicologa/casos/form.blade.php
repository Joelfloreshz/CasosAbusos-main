{{-- resources/views/psicologa/casos/form.blade.php --}}
@csrf

<div class="row g-3">

    {{-- Título o nombre del caso --}}
    <div class="col-12">
        <label for="titulo" class="form-label">Título del caso <span class="text-danger">*</span></label>
        <input type="text"
               id="titulo"
               name="titulo"
               value="{{ old('titulo', $caso->titulo ?? '') }}"
               class="form-control @error('titulo') is-invalid @enderror"
               placeholder="Ej: Intervención psicológica inicial" required>
        @error('titulo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Nombre de la persona atendida --}}
    <div class="col-md-6">
        <label for="paciente_nombre" class="form-label">Nombre de la persona atendida <span class="text-danger">*</span></label>
        <input type="text"
               id="paciente_nombre"
               name="paciente_nombre"
               value="{{ old('paciente_nombre', $caso->paciente_nombre ?? '') }}"
               class="form-control @error('paciente_nombre') is-invalid @enderror"
               placeholder="Nombre completo" required>
        @error('paciente_nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Edad --}}
    <div class="col-md-3">
        <label for="paciente_edad" class="form-label">Edad</label>
        <input type="number"
               id="paciente_edad"
               name="paciente_edad"
               value="{{ old('paciente_edad', $caso->paciente_edad ?? '') }}"
               min="0"
               class="form-control @error('paciente_edad') is-invalid @enderror">
        @error('paciente_edad')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Sexo --}}
    <div class="col-md-3">
        <label for="paciente_sexo" class="form-label">Sexo</label>
        <select name="paciente_sexo" id="paciente_sexo" class="form-select @error('paciente_sexo') is-invalid @enderror">
            <option value="" selected disabled>Seleccione...</option>
            <option value="Femenino" {{ old('paciente_sexo', $caso->paciente_sexo ?? '') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
            <option value="Masculino" {{ old('paciente_sexo', $caso->paciente_sexo ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="Otro" {{ old('paciente_sexo', $caso->paciente_sexo ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
        </select>
        @error('paciente_sexo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Fecha de apertura --}}
    <div class="col-md-4">
        <label for="fecha_apertura" class="form-label">Fecha de apertura</label>
        <input type="date"
               id="fecha_apertura"
               name="fecha_apertura"
               value="{{ old('fecha_apertura', isset($caso->fecha_apertura) ? $caso->fecha_apertura->format('Y-m-d') : now()->format('Y-m-d')) }}"
               class="form-control @error('fecha_apertura') is-invalid @enderror">
        @error('fecha_apertura')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Canal de referencia --}}
    <div class="col-md-4">
        <label for="canal_referencia" class="form-label">Canal de referencia</label>
        <input type="text"
               id="canal_referencia"
               name="canal_referencia"
               value="{{ old('canal_referencia', $caso->canal_referencia ?? '') }}"
               class="form-control @error('canal_referencia') is-invalid @enderror"
               placeholder="Ej: Escuela, referencia interna, etc.">
        @error('canal_referencia')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Proyecto --}}
    <div class="col-md-4">
        <label for="proyecto" class="form-label">Proyecto asociado</label>
        <input type="text"
               id="proyecto"
               name="proyecto"
               value="{{ old('proyecto', $caso->proyecto ?? '') }}"
               class="form-control @error('proyecto') is-invalid @enderror"
               placeholder="Nombre del proyecto o programa">
        @error('proyecto')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Estado --}}
    <div class="col-md-4">
        <label for="estado" class="form-label">Estado del caso</label>
        <select id="estado" name="estado" class="form-select @error('estado') is-invalid @enderror">
            <option value="Abierto" {{ old('estado', $caso->estado ?? '') == 'Abierto' ? 'selected' : '' }}>Abierto</option>
            <option value="En proceso" {{ old('estado', $caso->estado ?? '') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
            <option value="Cerrado" {{ old('estado', $caso->estado ?? '') == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
        </select>
        @error('estado')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Descripción / resumen --}}
    <div class="col-12">
        <label for="descripcion" class="form-label">Descripción / resumen del caso</label>
        <textarea id="descripcion" name="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror"
                  placeholder="Describa brevemente la situación, antecedentes y motivo de atención.">{{ old('descripcion', $caso->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Botones --}}
    <div class="col-12 d-flex justify-content-end mt-3">
        <a href="{{ route('psicologa.casos.index') }}" class="btn btn-outline-secondary me-2">
            <i class="bi bi-x-circle"></i> Cancelar
        </a>
        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Guardar
        </button>
    </div>
</div>
