@extends('layouts.abogada')
@section('title', 'Crear Nuevo Formulario')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg max-w-2xl mx-auto">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100"><i class="fas fa-file-medical mr-2"></i> Nuevo Formulario</h2>
    </div>
    <div class="p-6">
        <form action="{{ route('abogada.gestion-formularios.store') }}" method="POST">
            @csrf
            @include('abogada.gestion-formularios._form')
            
            <div class="flex justify-end mt-6">
                 <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Guardar y Añadir Preguntas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection