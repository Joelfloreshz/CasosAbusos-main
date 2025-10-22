{{-- Ruta: resources/views/abogada/gestion-formularios/edit.blade.php --}}
@extends('layouts.abogada')
@section('title', 'Gestionar Formulario')

@section('content')
<div class="card">
    <div class="card-header"><h2><i class="fas fa-edit"></i> Editar Formulario</h2></div>
    <div class="card-body">
        <form action="{{ route('abogada.gestion-formularios.update', $formulario) }}" method="POST">
            @csrf @method('PUT')
            @include('abogada.gestion-formularios._form')
            <button type="submit" class="btn btn-primary">Actualizar Datos</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3><i class="fas fa-list-ol"></i> Preguntas del Formulario</h3>
        {{-- Aquí puedes añadir un botón para abrir un modal de creación de pregunta --}}
    </div>
    <div class="card-body">
        <h4>Añadir Nueva Pregunta</h4>
        <form action="{{ route('abogada.gestion-formularios.preguntas.store', $formulario) }}" method="POST">
            @csrf
            {{-- Incluyo el formulario de preguntas aquí mismo --}}
            @include('abogada.gestion-formularios._pregunta-form')
            <button type="submit" class="btn btn-secondary"><i class="fas fa-plus"></i> Añadir Pregunta</button>
        </form>
        <hr style="margin: 30px 0;">
        <h4>Preguntas Existentes</h4>
        @forelse($formulario->preguntas as $pregunta)
            <div class="card">
                <form action="{{ route('abogada.gestion-formularios.preguntas.update', [$formulario, $pregunta]) }}" method="POST">
                    @csrf @method('PUT')
                    @include('abogada.gestion-formularios._pregunta-form', ['pregunta' => $pregunta])
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    {{-- Formulario anidado para borrar --}}
                    <form action="{{ route('abogada.gestion-formularios.preguntas.destroy', [$formulario, $pregunta]) }}" method="POST" onsubmit="return confirm('¿Segura?');" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </form>
            </div>
        @empty
            <p>Este formulario aún no tiene preguntas.</p>
        @endforelse
    </div>
</div>
@endsection