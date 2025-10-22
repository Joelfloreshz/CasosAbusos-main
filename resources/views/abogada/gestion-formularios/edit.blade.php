@extends('layouts.abogada')
@section('title', 'Gestionar Formulario')

@section('content')
{{-- Aplicamos max-w-4xl aquí para el primer cuadro --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-lg max-w-4xl mx-auto mb-6">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100"><i class="fas fa-edit mr-2"></i> Editar Formulario</h2>
    </div>
    <div class="p-6">
        <form action="{{ route('abogada.gestion-formularios.update', $formulario) }}" method="POST">
            @csrf
            @method('PUT')
            @include('abogada.gestion-formularios._form')

            <div class="flex justify-end mt-6">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Actualizar Datos
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Aplicamos el MISMO max-w-4xl aquí para el segundo cuadro --}}
<div class="bg-white dark:bg-gray-800 shadow rounded-lg max-w-4xl mx-auto">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100"><i class="fas fa-list-ol mr-2"></i> Preguntas del Formulario</h3>
    </div>

    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Añadir Nueva Pregunta</h4>
        <form action="{{ route('abogada.gestion-formularios.preguntas.store', $formulario) }}" method="POST">
            @csrf
            @include('abogada.gestion-formularios._pregunta-form')
            <div class="flex justify-end mt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="fas fa-plus mr-2"></i> Añadir Pregunta
                </button>
            </div>
        </form>
    </div>

    <div class="p-6">
        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Preguntas Existentes</h4>
        <div class="space-y-6">
            @forelse($formulario->preguntas->sortBy('numero') as $pregunta)
                <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg" x-data="{ open: false }">
                    <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
                        <p class="font-medium text-gray-800 dark:text-gray-100">{{ $pregunta->numero }}. {{ $pregunta->pregunta }}</p>
                        <i class="fas" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
                    </div>
                    <div x-show="open" x-collapse class="mt-4 pt-4 border-t dark:border-gray-600">
                        <form action="{{ route('abogada.gestion-formularios.preguntas.update', [$formulario, $pregunta]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            @include('abogada.gestion-formularios._pregunta-form', ['pregunta' => $pregunta])

                            <div class="flex justify-end items-center space-x-4 mt-4">
                                <form action="{{ route('abogada.gestion-formularios.preguntas.destroy', [$formulario, $pregunta]) }}" method="POST" onsubmit="return confirm('¿Segura?');" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Eliminar
                                    </button>
                                </form>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Actualizar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">Este formulario aún no tiene preguntas.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection