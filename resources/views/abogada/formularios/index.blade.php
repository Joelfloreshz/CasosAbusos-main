{{-- Ruta: resources/views/abogada/formularios/index.blade.php --}}
@extends('layouts.abogada')

@section('title', 'Iniciar Sesión de Formulario para el Caso: ' . $caso->codigo_caso)

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Selecciona un formulario para aplicar</h2>
    </div>
    <div class="card-body">
        <p>Estos son los formularios disponibles para el área jurídica.</p>
        <ul>
            @forelse($formularios as $formulario)
                <li style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                    <span><strong>{{ $formulario->nombre }}</strong> ({{ $formulario->preguntas->count() }} preguntas)</span>
                    <a href="{{ route('abogada.formularios.show', ['caso' => $caso, 'formulario' => $formulario]) }}" class="btn btn-primary">Iniciar Sesión</a>
                </li>
            @empty
                <li>No hay formularios jurídicos activos en este momento.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection