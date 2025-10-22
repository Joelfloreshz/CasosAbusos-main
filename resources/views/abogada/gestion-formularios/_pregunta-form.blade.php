{{-- Ruta: resources/views/abogada/gestion-formularios/_pregunta-form.blade.php --}}
<div class="grid-2-cols">
    <div class="form-group">
        <label>Número de Pregunta</label>
        <input type="number" name="numero" class="form-control" value="{{ old('numero', $pregunta->numero ?? ($formulario->preguntas->max('numero') + 1)) }}" required>
    </div>
    <div class="form-group">
        <label>Tipo de Respuesta</label>
        <select name="tipo_respuesta" class="form-control">
            <option value="texto" @selected(old('tipo_respuesta', $pregunta->tipo_respuesta ?? '') == 'texto')>Texto Largo</option>
            <option value="numero" @selected(old('tipo_respuesta', $pregunta->tipo_respuesta ?? '') == 'numero')>Número</option>
            <option value="si_no" @selected(old('tipo_respuesta', $pregunta->tipo_respuesta ?? '') == 'si_no')>Sí / No</option>
            <option value="multiple" @selected(old('tipo_respuesta', $pregunta->tipo_respuesta ?? '') == 'multiple')>Selección Múltiple</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label>Texto de la Pregunta</label>
    <textarea name="pregunta" class="form-control" required>{{ old('pregunta', $pregunta->pregunta ?? '') }}</textarea>
</div>
<div class="form-group">
    <label>Opciones (separadas por coma, solo para Selección Múltiple)</label>
    <input type="text" name="opciones" class="form-control" value="{{ old('opciones', $pregunta->opciones ?? '') }}">
</div>
<div class="form-group">
    <label><input type="checkbox" name="requerida" value="1" @checked(old('requerida', $pregunta->requerida ?? false))> Es requerida</label>
</div>