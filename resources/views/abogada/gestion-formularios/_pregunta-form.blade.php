<div x-data="{ tipo: '{{ old('tipo_respuesta', $pregunta->tipo_respuesta ?? 'texto') }}' }" class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número</label>
            <input type="number" name="numero" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ old('numero', $pregunta->numero ?? ($formulario->preguntas->max('numero') + 1)) }}" required>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Respuesta</label>
            <select name="tipo_respuesta" x-model="tipo" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                <option value="texto">Texto (Largo)</option>
                <option value="corta">Texto (Corto)</option>
                <option value="numero">Número</option>
                <option value="si_no">Sí / No</option>
                <option value="multiple">Selección Múltiple</option>
            </select>
        </div>
    </div>
    
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pregunta</label>
        <textarea name="pregunta" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" required>{{ old('pregunta', $pregunta->pregunta ?? '') }}</textarea>
    </div>
    
    <div x-show="tipo === 'multiple'" class="transition-all">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Opciones (separadas por coma)</label>
        <input type="text" name="opciones" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ old('opciones', $pregunta->opciones ?? '') }}" placeholder="Opción 1,Opción 2,Opción 3">
    </div>
    
    <div>
        <label class="flex items-center">
            <input type="checkbox" name="requerida" value="1" @checked(old('requerida', $pregunta->requerida ?? false)) class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-700">
            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Requerida</span>
        </label>
    </div>
</div>