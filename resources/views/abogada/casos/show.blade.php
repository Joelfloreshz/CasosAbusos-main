@extends('layouts.abogada')

@section('title', 'Detalle del Caso ' . $caso->codigo_caso)

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-20">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <h2><i class="fas fa-briefcase"></i> Detalles del Caso: {{ $caso->codigo_caso }}</h2>
            <div class="actions">
                <a href="{{ route('abogada.casos.edit', $caso) }}" class="btn btn-secondary">
                    <i class="fas fa-edit"></i> Editar Caso
                </a>
                @if($caso->isActive())
                    <a href="{{ route('abogada.formularios.index', $caso) }}" class="btn btn-primary">
                        <i class="fas fa-file-alt"></i> Iniciar Formulario
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body grid-2-cols">
            <div>
                <p><strong>Nombre de la Afectada:</strong> {{ $caso->nombre_afectada }}</p>
                <p><strong>DUI:</strong> {{ $caso->dui ?? 'No especificado' }}</p>
                <p><strong>Edad:</strong> {{ $caso->edad ?? 'No especificada' }}</p>
                <p><strong>Teléfono:</strong> {{ $caso->telefono ?? 'No especificado' }}</p>
            </div>
            <div>
                <p><strong>Ubicación:</strong> {{ $caso->municipio ?? 'N/A' }}, {{ $caso->departamento ?? 'N/A' }}</p>
                <p><strong>Fecha de Ingreso:</strong> {{ $caso->fecha_ingreso->format('d/m/Y') }}</p>
                <p><strong>Estado:</strong> <span class="badge {{ $caso->estado == 'activo' ? 'badge-activo' : 'badge-cerrado' }}">{{ ucfirst($caso->estado) }}</span></p>
                <p><strong>Motivo de Consulta:</strong> {{ $caso->motivo }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3><i class="fas fa-history"></i> Historial de Seguimientos</h3>
            <button id="toggle-seguimiento-form" class="btn btn-primary" style="padding: 5px 12px;">
                <i class="fas fa-plus"></i> Añadir
            </button>
        </div>
        <div class="card-body">
            <div id="form-seguimiento-container" style="display: none; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px dashed #eee;">
                @if($caso->isActive())
                    <form action="{{ route('abogada.seguimientos.store', $caso) }}" method="POST">
                        @csrf
                        <div class="grid-2-cols">
                            <div class="form-group">
                                <label for="fecha">Fecha del Seguimiento</label>
                                <input type="date" id="fecha" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="proxima_cita">Próxima Cita (Opcional)</label>
                                <input type="date" id="proxima_cita" name="proxima_cita" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción (Avances, notas, nuevos hechos)</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="6" required placeholder="Describe aquí los avances del caso, si la víctima ha sufrido nuevos abusos, etc."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Seguimiento</button>
                    </form>
                @else
                    <p class="text-center">Este caso está cerrado y no se pueden añadir nuevos seguimientos.</p>
                @endif
            </div>

            @forelse($caso->seguimientos->sortByDesc('fecha') as $seguimiento)
                <div class="card seguimiento-card">
                    <div class="delete-form">
                        <form action="{{ route('abogada.seguimientos.destroy', $seguimiento) }}" method="POST" onsubmit="return confirm('¿Confirmas que quieres eliminar este seguimiento?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 4px 8px; font-size: 0.75rem;">Eliminar</button>
                        </form>
                    </div>

                    <p><strong>Fecha:</strong> {{ $seguimiento->fecha->format('d/m/Y') }}</p>
                    <p><strong>Registrado por:</strong> {{ $seguimiento->usuario->nombre }}</p>
                    <p>{{ $seguimiento->descripcion }}</p>
                    @if($seguimiento->proxima_cita)
                        <p style="color: var(--accent-color); font-weight: bold;">
                            <i class="fas fa-calendar-check"></i> Próxima Cita: {{ $seguimiento->proxima_cita->format('d/m/Y') }}
                        </p>
                    @endif
                </div>
            @empty
                <p>No hay seguimientos registrados para este caso.</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-tasks"></i> Sesiones de Formularios Completadas</h3>
        </div>
        <div class="card-body">
            @forelse($caso->sesiones->where('completado', true) as $sesion)
                <div style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        <strong>{{ $sesion->formulario->nombre }}</strong> -
                        Completado el {{ $sesion->updated_at->format('d/m/Y') }}
                    </span>
                    <a href="{{ route('abogada.sesiones.show', $sesion) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 0.8rem;">Ver Respuestas</a>
                </div>
            @empty
                <p>No se ha completado ninguna sesión de formulario para este caso.</p>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('toggle-seguimiento-form');
        const formContainer = document.getElementById('form-seguimiento-container');

        if (toggleButton) {
            toggleButton.addEventListener('click', function() {
                if (formContainer.style.display === 'none' || formContainer.style.display === '') {
                    formContainer.style.display = 'block';
                } else {
                    formContainer.style.display = 'none';
                }
            });
        }
    });
</script>
@endpush