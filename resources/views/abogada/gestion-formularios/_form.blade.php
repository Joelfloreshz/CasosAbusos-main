{{-- Ruta: resources/views/abogada/gestion-formularios/_form.blade.php --}}
<div class="form-group">
    <label for="nombre">Nombre del Formulario</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $formulario->nombre ?? '') }}" required>
</div>
<div class="grid-2-cols">
    <div class="form-group">
        <label for="tipo">Tipo de Formulario</label>
        <select name="tipo" class="form-control">
            <option value="ingreso" @selected(old('tipo', $formulario->tipo ?? '') == 'ingreso')>Ingreso</option>
            <option value="seguimiento" @selected(old('tipo', $formulario->tipo ?? '') == 'seguimiento')>Seguimiento</option>
            <option value="evaluacion" @selected(old('tipo', $formulario->tipo ?? '') == 'evaluacion')>Evaluación</option>
        </select>
    </div>
    <div class="form-group">
        <label for="area">Área de Aplicación</label>
        <select name="area" class="form-control">
            <option value="juridica" @selected(old('area', $formulario->area ?? '') == 'juridica')>Jurídica</option>
            <option value="psicologica" @selected(old('area', $formulario->area ?? '') == 'psicologica')>Psicológica</option>
            <option value="ambas" @selected(old('area', $formulario->area ?? '') == 'ambas')>Ambas</option>
        </select>
    </div>
</div>