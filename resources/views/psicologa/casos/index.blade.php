{{-- Ruta: resources/views/psicologa/casos/index.blade.php --}}
@extends('layouts.psicologa')

@section('title', 'Casos Psicológicos')

@section('content')
<div class="container-fluid">

    {{-- Encabezado / Acciones --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <h3 class="m-0">
            <i class="fas fa-folder-open me-2"></i> Casos Psicológicos
        </h3>

        <div class="d-flex gap-2">
            <a href="{{ route('psicologa.casos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Nuevo Caso
            </a>
        </div>
    </div>

    {{-- Filtros y búsqueda --}}
    <form method="GET" action="{{ route('psicologa.casos.index') }}" class="card shadow-sm mb-3 p-3">
        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-label mb-1">Buscar</label>
                <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                       placeholder="Código, paciente, notas…">
            </div>

            <div class="col-md-3">
                <label class="form-label mb-1">Estado</label>
                <select name="estado" class="form-select">
                    <option value="">-- Todos --</option>
                    <option value="activo" {{ request('estado')=='activo' ? 'selected' : '' }}>Activo</option>
                    <option value="cerrado" {{ request('estado')=='cerrado' ? 'selected' : '' }}>Cerrado</option>
                    <option value="pausado" {{ request('estado')=='pausado' ? 'selected' : '' }}>Pausado</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label mb-1">Ordenar por</label>
                <select name="sort" class="form-select">
                    <option value="">Recientes</option>
                    <option value="codigo" {{ request('sort')=='codigo' ? 'selected' : '' }}>Código</option>
                    <option value="paciente" {{ request('sort')=='paciente' ? 'selected' : '' }}>Paciente</option>
                    <option value="proxima_cita" {{ request('sort')=='proxima_cita' ? 'selected' : '' }}>Próxima cita</option>
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-outline-secondary w-100">
                    <i class="fas fa-search me-1"></i> Filtrar
                </button>
            </div>
        </div>
    </form>

    {{-- Tabla de casos --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:120px;">Código</th>
                        <th>Paciente</th>
                        <th style="width:140px;">Estado</th>
                        <th style="width:150px;">Apertura</th>
                        <th style="width:170px;">Última sesión</th>
                        <th style="width:170px;">Próxima cita</th>
                        <th style="width:160px;" class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($casos as $caso)
                        <tr>
                            <td>
                                <span class="fw-semibold">{{ $caso->codigo ?? '—' }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">{{ $caso->paciente ?? 'Sin nombre' }}</span>
                                    @if(!empty($caso->telefono) || !empty($caso->correo))
                                        <small class="text-muted">
                                            {{ $caso->telefono ? '📞 '.$caso->telefono : '' }}
                                            {{ $caso->correo ? ' · ✉️ '.$caso->correo : '' }}
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @php
                                    $estado = strtolower($caso->estado ?? 'activo');
                                    $badge = [
                                        'activo'  => 'bg-success',
                                        'cerrado' => 'bg-secondary',
                                        'pausado' => 'bg-warning',
                                    ][$estado] ?? 'bg-success';
                                @endphp
                                <span class="badge {{ $badge }}">{{ ucfirst($estado) }}</span>
                            </td>
                            <td>
                                {{ optional($caso->fecha_apertura)->format('d/m/Y') ?? '—' }}
                            </td>
                            <td>
                                {{ optional($caso->ultima_sesion)->format('d/m/Y H:i') ?? '—' }}
                            </td>
                            <td>
                                {{ optional($caso->proxima_cita)->format('d/m/Y H:i') ?? '—' }}
                            </td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-primary"
                                   href="{{ route('psicologa.casos.show', $caso) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-outline-secondary"
                                   href="{{ route('psicologa.casos.edit', $caso) }}">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('psicologa.casos.destroy', $caso) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este caso?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <p class="mb-2">No hay casos registrados.</p>
                                <a href="{{ route('psicologa.casos.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-1"></i> Crear primer caso
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if(method_exists($casos, 'links'))
            <div class="card-footer">
                {{ $casos->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
