{{-- Ruta: resources/views/abogada/casos/form.blade.php --}}
@extends('layouts.abogada')

{{-- El título de la página cambia si estoy editando o creando un caso. --}}
@section('title', isset($caso) ? 'Editar Caso' : 'Crear Nuevo Caso')

@section('content')
<div class="form-container">
    <h2>{{ isset($caso) ? 'Editar Caso: ' . $caso->codigo_caso : 'Registrar Nuevo Caso Jurídico' }}</h2>

    {{-- Si hay errores de validación, los muestro aquí. --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- El formulario apunta a la ruta 'update' si edito, o 'store' si creo. --}}
    <form action="{{ isset($caso) ? route('abogada.casos.update', $caso) : route('abogada.casos.store') }}" method="POST">
        @csrf
        {{-- Si estoy editando, necesito agregar el método PUT. --}}
        @if(isset($caso))
            @method('PUT')
        @endif

        {{-- Divido el formulario en secciones para que sea más fácil de leer. --}}
        
        <h3>Información General del Caso</h3>
        <div class="form-group">
            <label for="codigo_caso">Código del Caso</label>
            <input type="text" id="codigo_caso" name="codigo_caso" class="form-control" value="{{ old('codigo_caso', $caso->codigo_caso ?? '') }}" required>
        </div>
        <div class="form-group">
            <label for="fecha_ingreso">Fecha de Ingreso</label>
            <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control" value="{{ old('fecha_ingreso', isset($caso) ? $caso->fecha_ingreso->format('Y-m-d') : '') }}" required>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" class="form-control">
                <option value="activo" {{ old('estado', $caso->estado ?? 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="cerrado" {{ old('estado', $caso->estado ?? '') == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
            </select>
        </div>

        <h3>Datos de la Afectada</h3>
        <div class="form-group">
            <label for="nombre_afectada">Nombre Completo</label>
            <input type="text" id="nombre_afectada" name="nombre_afectada" class="form-control" value="{{ old('nombre_afectada', $caso->nombre_afectada ?? '') }}" required>
        </div>
        <div class="form-group">
            <label for="dui">DUI</label>
            <input type="text" id="dui" name="dui" class="form-control" value="{{ old('dui', $caso->dui ?? '') }}">
        </div>
        <div class="form-group">
            <label for="edad">Edad</label>
            <input type="number" id="edad" name="edad" class="form-control" value="{{ old('edad', $caso->edad ?? '') }}">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" class="form-control" value="{{ old('telefono', $caso->telefono ?? '') }}">
        </div>
        <div class="form-group">
            <label for="departamento">Departamento</label>
            <input type="text" id="departamento" name="departamento" class="form-control" value="{{ old('departamento', $caso->departamento ?? '') }}">
        </div>
        <div class="form-group">
            <label for="municipio">Municipio</label>
            <input type="text" id="municipio" name="municipio" class="form-control" value="{{ old('municipio', $caso->municipio ?? '') }}">
        </div>
        <div class="form-group">
            <label for="motivo">Motivo de la Consulta</label>
            <textarea id="motivo" name="motivo" class="form-control">{{ old('motivo', $caso->motivo ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($caso) ? 'Actualizar Caso' : 'Guardar Caso' }}</button>
      
<a href="{{ route('abogada.casos.index') }}" class="btn" style="background-color: #7f8c8d;">Cancelar</a>
    </form>
</div>
@endsection