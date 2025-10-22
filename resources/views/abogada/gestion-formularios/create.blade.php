{{-- Ruta: resources/views/abogada/gestion-formularios/create.blade.php --}}
@extends('layouts.abogada')
@section('title', 'Crear Nuevo Formulario')

@section('content')
<div class="card">
    <div class="card-header"><h2><i class="fas fa-file-medical"></i> Nuevo Formulario</h2></div>
    <div class="card-body">
        <form action="{{ route('abogada.gestion-formularios.store') }}" method="POST">
            @csrf
            @include('abogada.gestion-formularios._form') {{-- Reutilizo un formulario parcial --}}
            <button type="submit" class="btn btn-primary">Guardar y Añadir Preguntas</button>
        </form>
    </div>
</div>
@endsection