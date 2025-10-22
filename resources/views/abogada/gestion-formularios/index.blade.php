{{-- Ruta: resources/views/abogada/gestion-formularios/index.blade.php --}}
@extends('layouts.abogada')
@section('title', 'Gestión de Formularios')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2><i class="fas fa-clipboard-list"></i> Mis Formularios</h2>
        <a href="{{ route('abogada.gestion-formularios.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear Formulario</a>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Área</th>
                    <th>Nº Preguntas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($formularios as $formulario)
                <tr>
                    <td>{{ $formulario->nombre }}</td>
                    <td>{{ ucfirst($formulario->tipo) }}</td>
                    <td>{{ ucfirst($formulario->area) }}</td>
                    <td>{{ $formulario->preguntas->count() }}</td>
                    <td class="actions">
                        <a href="{{ route('abogada.gestion-formularios.edit', $formulario) }}" class="btn btn-secondary">Gestionar</a>
                        <form action="{{ route('abogada.gestion-formularios.destroy', $formulario) }}" method="POST" onsubmit="return confirm('¿Segura? Se borrará el formulario y todas sus preguntas.');" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align: center;">No has creado ningún formulario.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection