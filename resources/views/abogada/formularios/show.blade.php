{{-- Ruta: resources/views/abogada/formularios/show.blade.php --}}
@extends('layouts.abogada')

@section('title', 'Llenando Formulario: ' . $formulario->nombre)

@section('content')
<div class="card">
    <div class="card-header">
        <h2>{{ $formulario->nombre }}</h2>
        <p><strong>Caso:</strong> {{ $caso->codigo_caso }} - {{ $caso->nombre_afectada }}</p>
    </div>
    <form action="{{ route('abogada.respuestas.store', $sesion) }}" method="POST">
        @csrf
        
        @foreach($formulario->preguntas as $pregunta)
            <div class="form-group">
                <label for="pregunta-{{ $pregunta->id }}">
                    {{ $pregunta->numero }}. {{ $pregunta->pregunta }}
                    @if($pregunta->requerida) <span style="color:red;">*</span> @endif
                </label>

                {{-- Aquí viene la lógica para mostrar el tipo de campo correcto según la pregunta. --}}
                @switch($pregunta->tipo_respuesta)
                    @case('texto')
                        <textarea name="respuestas[{{ $pregunta->id }}]" class="form-control"></textarea>
                        @break
                    @case('numero')
                        <input type="number" name="respuestas[{{ $pregunta->id }}]" class="form-control">
                        @break
                    @case('si_no')
                        <select name="respuestas[{{ $pregunta->id }}]" class="form-control">
                            <option value="">Seleccione...</option>
                            <option value="si">Sí</option>
                            <option value="no">No</option>
                        </select>
                        @break
                    @case('multiple')
                        <select name="respuestas[{{ $pregunta->id }}]" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach($pregunta->getOpcionesArray() as $opcion)
                                <option value="{{ $opcion }}">{{ $opcion }}</option>
                            @endforeach
                        </select>
                        @break
                @endswitch
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Guardar y Finalizar Sesión</button>
    </form>
</div>
@endsection