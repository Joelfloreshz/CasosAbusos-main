@extends('layouts.abogada')

@section('title', 'Respuestas del Formulario: ' . $sesion->formulario->nombre)

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg max-w-3xl mx-auto">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $sesion->formulario->nombre }}</h2>
        <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            <p>
                <strong>Caso:</strong>
                <a href="{{ route('abogada.casos.show', $sesion->caso) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                    {{ $sesion->caso->codigo_caso }}
                </a> - {{ $sesion->caso->nombre_afectada }}
            </p>
            <p><strong>Fecha de Sesión:</strong> {{ $sesion->created_at->isoFormat('dddd, D [de] MMMM [de] YYYY, h:mm A') }}</p>
            <p><strong>Registrado por:</strong> {{ $sesion->usuario->nombre ?? 'Usuario desconocido' }}</p>
        </div>
    </div>
    <div class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($sesion->formulario->preguntas->sortBy('numero') as $pregunta)
            @php
                $respuesta = $sesion->respuestas->firstWhere('pregunta_id', $pregunta->id);
            @endphp
            <div class="px-6 py-4">
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ $pregunta->numero }}. {{ $pregunta->pregunta }}
                    @if($pregunta->requerida) <span class="text-red-500 text-xs">* Obligatoria</span> @endif
                </p>
                <div class="mt-2 text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 p-3 rounded-md border border-gray-200 dark:border-gray-600">
                    {{ $respuesta->respuesta ?? 'No contestada' }}
                </div>
            </div>
        @empty
            <div class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                Este formulario no tiene preguntas definidas.
            </div>
        @endforelse
    </div>
    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-end">
        <a href="{{ route('abogada.casos.show', $sesion->caso) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Volver al Caso
        </a>
    </div>
</div>
@endsection