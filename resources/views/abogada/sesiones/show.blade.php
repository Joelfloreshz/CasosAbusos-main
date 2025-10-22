{{-- Ruta: resources/views/abogada/sesiones/show.blade.php --}}
@extends('layouts.abogada')

@section('title', 'Respuestas del Formulario: ' . $sesion->formulario->nombre)

@section('content')
<div class="card">
    <div class="card-header">
        <h2>{{ $sesion->formulario->nombre }}</h2>
        <p>
            <strong>Caso:</strong> <a href="{{ route('abogada.casos.show', $sesion->caso) }}">{{ $sesion->caso->codigo_caso }}</a> - {{ $sesion->caso->nombre_afectada }}<br>
            <strong>Fecha de Sesión:</strong> {{ $sesion->created_at->format('d/m/Y H:i') }}
        </p>
    </div>
    <div class="card-body">
        @foreach($sesion->formulario->preguntas as $pregunta)
            <div style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #f0f0f0;">
                <p><strong>{{ $pregunta->numero }}. {{ $pregunta->pregunta }}</strong></p>
                @php
                    // Busco la respuesta para esta pregunta en la colección de respuestas de la sesión.
                    $respuesta = $sesion->respuestas->firstWhere('pregunta_id', $pregunta->id);
                @endphp
                <p style="background-color: #f9f9f9; padding: 10px; border-radius: 5px;">
                    <em>Respuesta:</em> {{ $respuesta->respuesta ?? 'No contestada' }}
                </p>
            </div>
        @endforeach
    </div>
</div>
@endsection