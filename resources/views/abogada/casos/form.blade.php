@extends('layouts.abogada')

@section('title', isset($caso) ? 'Editar Caso' : 'Crear Nuevo Caso')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">
        {{ isset($caso) ? 'Editar Caso: ' . $caso->codigo_caso : 'Registrar Nuevo Caso Jurídico' }}
    </h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($caso) ? route('abogada.casos.update', $caso) : route('abogada.casos.store') }}" method="POST">
        @csrf
        @if(isset($caso))
            @method('PUT')
        @endif

        <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Información General del Caso</h3>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="codigo_caso" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código del Caso</label>
                    <input type="text" id="codigo_caso" name="codigo_caso" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ old('codigo_caso', $caso->codigo_caso ?? '') }}" required>
                </div>
                <div>
                    <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Ingreso</label>
                    <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ old('fecha_ingreso', isset($caso) ? $caso->fecha_ingreso->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
                </div>
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                    <select id="estado" name="estado" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                        <option value="activo" {{ old('estado', $caso->estado ?? 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="cerrado" {{ old('estado', $caso->estado ?? '') == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                    </select>
                </div>
                <div class="md:col-span-3">
                    <label for="proyecto_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proyecto (Opcional)</label>
                    <select id="proyecto_id" name="proyecto_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                        <option value="">Ningún proyecto</option>
                        @foreach($proyectos as $proyecto)
                            <option value="{{ $proyecto->id }}" @selected(old('proyecto_id', $caso->proyecto_id ?? '') == $proyecto->id)>
                                {{ $proyecto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Datos de la Afectada</h3>
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre_afectada" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre Completo</label>
                    <input type="text" id="nombre_afectada" name="nombre_afectada" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ old('nombre_afectada', $caso->nombre_afectada ?? '') }}" required>
                </div>
                <div>
                    <label for="dui" class="block text-sm font-medium text-gray-700 dark:text-gray-300">DUI</label>
                    <input type="text" id="dui" name="dui" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ old('dui', $caso->dui ?? '') }}">
                </div>
                <div>
                    <label for="edad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Edad</label>
                    <input type="number" id="edad" name="edad" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ old('edad', $caso->edad ?? '') }}">
                </div>
                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ old('telefono', $caso->telefono ?? '') }}">
                </div>
                <div>
                    <label for="departamento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departamento</label>
                    <input type="text" id="departamento" name="departamento" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ old('departamento', $caso->departamento ?? '') }}">
                </div>
                <div>
                    <label for="municipio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Municipio</label>
                    <input type="text" id="municipio" name="municipio" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ old('municipio', $caso->municipio ?? '') }}">
                </div>
                <div class="md:col-span-2">
                    <label for="motivo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Motivo de la Consulta</label>
                    <textarea id="motivo" name="motivo" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">{{ old('motivo', $caso->motivo ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Datos del Agresor (Opcional)</h3>
             <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre_agresor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Agresor</label>
                    <input type="text" id="nombre_agresor" name="nombre_agresor" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ old('nombre_agresor', $caso->nombre_agresor ?? '') }}">
                </div>
                 <div>
                    <label for="ocupacion_agresor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ocupación</label>
                    <input type="text" id="ocupacion_agresor" name="ocupacion_agresor" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ old('ocupacion_agresor', $caso->ocupacion_agresor ?? '') }}">
                </div>
                <div>
                    <label for="parentesco_agresor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Parentesco con la víctima</label>
                    <select id="parentesco_agresor" name="parentesco_agresor" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                        <option value="">Seleccione...</option>
                        <option value="Conyuge" @selected(old('parentesco_agresor', $caso->parentesco_agresor ?? '') == 'Conyuge')>Cónyuge</option>
                        <option value="Ex-conyuge" @selected(old('parentesco_agresor', $caso->parentesco_agresor ?? '') == 'Ex-conyuge')>Ex-cónyuge</option>
                        <option value="Conviviente" @selected(old('parentesco_agresor', $caso->parentesco_agresor ?? '') == 'Conviviente')>Conviviente</option>
                        <option value="Ex-conviviente" @selected(old('parentesco_agresor', $caso->parentesco_agresor ?? '') == 'Ex-conviviente')>Ex-conviviente</option>
                        <option value="Padre" @selected(old('parentesco_agresor', $caso->parentesco_agresor ?? '') == 'Padre')>Padre</option>
                        <option value="Padrastro" @selected(old('parentesco_agresor', $caso->parentesco_agresor ?? '') == 'Padrastro')>Padrastro</option>
                        <option value="Hermano" @selected(old('parentesco_agresor', $caso->parentesco_agresor ?? '') == 'Hermano')>Hermano</option>
                        <option value="Otro Familiar" @selected(old('parentesco_agresor', $caso->parentesco_agresor ?? '') == 'Otro Familiar')>Otro Familiar</option>
                        <option value="Desconocido" @selected(old('parentesco_agresor', $caso->parentesco_agresor ?? '') == 'Desconocido')>Desconocido</option>
                        <option value="Otro" @selected(old('parentesco_agresor', $caso->parentesco_agresor ?? '') == 'Otro')>Otro (No familiar)</option>
                    </select>
                </div>
                <div>
                    <label for="estado_civil_agresor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado Civil del Agresor</label>
                    <select id="estado_civil_agresor" name="estado_civil_agresor" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                        <option value="">Seleccione...</option>
                        <option value="Soltero" @selected(old('estado_civil_agresor', $caso->estado_civil_agresor ?? '') == 'Soltero')>Soltero(a)</option>
                        <option value="Casado" @selected(old('estado_civil_agresor', $caso->estado_civil_agresor ?? '') == 'Casado')>Casado(a)</option>
                        <option value="Acompanado" @selected(old('estado_civil_agresor', $caso->estado_civil_agresor ?? '') == 'Acompanado')>Acompañado(a)</option>
                        <option value="Divorciado" @selected(old('estado_civil_agresor', $caso->estado_civil_agresor ?? '') == 'Divorciado')>Divorciado(a)</option>
                        <option value="Viudo" @selected(old('estado_civil_agresor', $caso->estado_civil_agresor ?? '') == 'Viudo')>Viudo(a)</option>
                        <option value="No sabe" @selected(old('estado_civil_agresor', $caso->estado_civil_agresor ?? '') == 'No sabe')>No sabe</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-end items-center space-x-4 mt-6">
            <a href="{{ route('abogada.casos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-100 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150">
                Cancelar
            </a>
            
            @if(isset($caso))
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Actualizar Caso
                </button>
            @else
                <button type="submit" name="action" value="save" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Guardar
                </button>
                <button type="submit" name="action" value="save_and_form" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Guardar e Iniciar Formulario
                </button>
            @endif
        </div>
    </form>
</div>
@endsection