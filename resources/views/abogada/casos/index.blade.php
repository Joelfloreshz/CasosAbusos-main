{{-- Ruta: resources/views/abogada/casos/index.blade.php --}}
@extends('layouts.abogada')

@section('title', 'Lista de Casos Jurídicos')

@section('content')
<div class="table-container">
    <div class="card-header">
        <h2>Casos Jurídicos Activos y Cerrados</h2>
    </div>

    {{-- Aquí reviso si hay un mensaje de éxito en la sesión y lo muestro. --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Afectada</th>
                <th>Fecha de Ingreso</th>
                <th>Estado</th>
                <th>Responsable</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- Reviso si la lista de casos está vacía. --}}
            @forelse ($casos as $caso)
                <tr>
                    <td>{{ $caso->codigo_caso }}</td>
                    <td>{{ $caso->nombre_afectada }}</td>
                    <td>{{ $caso->fecha_ingreso->format('d/m/Y') }}</td>
                    <td>
                        
                        <span class="badge {{ $caso->estado == 'activo' ? 'badge-activo' : 'badge-cerrado' }}">
                            {{ ucfirst($caso->estado) }}
                        </span>
                    </td>
                    <td>{{ $caso->usuario->nombre }}</td>
                   <td class="actions">
    {{-- Estos son los botones de acción para cada caso. --}}
    <a href="{{ route('abogada.casos.show', $caso) }}" class="btn btn-primary">Ver</a>
    <a href="{{ route('abogada.casos.show', $caso) }}" class="btn" style="background-color: #f39c12;">Seguimiento</a>
    <a href="{{ route('abogada.casos.edit', $caso) }}" class="btn btn-secondary">Editar</a>
    <form action="{{ route('abogada.casos.destroy', $caso) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás segura de que quieres eliminar este caso? Esta acción no se puede deshacer.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Eliminar</button>
    </form>
</td>
                </tr>
            @empty
                {{-- Si no hay casos, muestro este mensaje. --}}
                <tr>
                    <td colspan="6" class="text-center">No hay casos jurídicos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection