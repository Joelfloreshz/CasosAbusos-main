@extends('layouts.abogada')

@section('title', 'Iniciar Sesión de Formulario para el Caso: ' . $caso->codigo_caso)

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg max-w-2xl mx-auto">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Selecciona un formulario</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Caso: {{ $caso->codigo_caso }} - {{ $caso->nombre_afectada }}</p>
    </div>
    <div class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($formularios as $formulario)
            <div class="px-6 py-4 flex justify-between items-center">
                <div>
                    <p class="font-semibold text-gray-800 dark:text-gray-100">{{ $formulario->nombre }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">({{ $formulario->preguntas->count() }} preguntas)</p>
                </div>
                <a href="{{ route('abogada.formularios.show', ['caso' => $caso, 'formulario' => $formulario]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Iniciar Sesión
                </a>
            </div>
        @empty
            <p class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">No hay formularios jurídicos activos en este momento.</p>
        @endforelse
    </div>
</div>
@endsection