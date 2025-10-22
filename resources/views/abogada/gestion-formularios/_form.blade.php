<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Formulario</label>
        <input type="text" name="nombre" id="nombre" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ old('nombre', $formulario->nombre ?? '') }}" required>
    </div>
    <div>
        <label for="tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Formulario</label>
        <select name="tipo" id="tipo" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
            <option value="ingreso" @selected(old('tipo', $formulario->tipo ?? '') == 'ingreso')>Ingreso</option>
            <option value="seguimiento" @selected(old('tipo', $formulario->tipo ?? '') == 'seguimiento')>Seguimiento</option>
            <option value="evaluacion" @selected(old('tipo', $formulario->tipo ?? '') == 'evaluacion')>Evaluación</option>
        </select>
    </div>
    <div>
        <label for="area" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Área de Aplicación</label>
        <select name="area" id="area" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
            <option value="juridica" @selected(old('area', $formulario->area ?? '') == 'juridica')>Jurídica</option>
            <option value="psicologica" @selected(old('area', $formulario->area ?? '') == 'psicologica')>Psicológica</option>
            <option value="ambas" @selected(old('area', $formulario->area ?? '') == 'ambas')>Ambas</option>
        </select>
    </div>
</div>