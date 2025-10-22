@extends('layouts.abogada')

@section('title', 'Llenando Formulario: ' . $formulario->nombre)

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg max-w-3xl mx-auto">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $formulario->nombre }}</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Caso:</strong> {{ $caso->codigo_caso }} - {{ $caso->nombre_afectada }}</p>
    </div>
    <form action="{{ route('abogada.respuestas.store', $sesion) }}" method="POST">
        @csrf
        <div class="p-6 space-y-6">
            @foreach($formulario->preguntas->sortBy('numero') as $pregunta)
                <div>
                    <label for="pregunta-{{ $pregunta->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ $pregunta->numero }}. {{ $pregunta->pregunta }}
                        @if($pregunta->requerida) <span class="text-red-500">*</span> @endif
                    </label>

                    @switch($pregunta->tipo_respuesta)
                        @case('texto')
                            <textarea name="respuestas[{{ $pregunta->id }}]" id="pregunta-{{ $pregunta->id }}" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" @if($pregunta->requerida) required @endif></textarea>
                            @break
                        @case('corta')
                            <input type="text" name="respuestas[{{ $pregunta->id }}]" id="pregunta-{{ $pregunta->id }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" @if($pregunta->requerida) required @endif>
                            @break
                        @case('numero')
                            <input type="number" name="respuestas[{{ $pregunta->id }}]" id="pregunta-{{ $pregunta->id }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" @if($pregunta->requerida) required @endif>
                            @break
                        @case('si_no')
                            <select name="respuestas[{{ $pregunta->id }}]" id="pregunta-{{ $pregunta->id }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" @if($pregunta->requerida) required @endif>
                                <option value="">Seleccione...</option>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                            </select>
                            @break
                        @case('multiple')
                            <select name="respuestas[{{ $pregunta->id }}]" id="pregunta-{{ $pregunta->id }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" @if($pregunta->requerida) required @endif>
                                <option value="">Seleccione...</option>
                                @foreach($pregunta->getOpcionesArray() as $opcion)
                                    <option value="{{ $opcion }}">{{ $opcion }}</option>
                                @endforeach
                            </select>
                            @break
                    @endswitch
                </div>
            @endforeach
        </div>

        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                Guardar y Finalizar Sesión
            </button>
        </div>
    </form>
</div>
@endsection