{{-- resources/views/psicologa/casos/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detalle del Caso Psicológico')

@section('content')
<div class="container py-4">

    {{-- Migas de pan --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('psicologa.dashboard') }}">Módulo Psicóloga</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('psicologa.casos.index') }}">Casos</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Caso #{{ $caso->id }}
            </li>
        </ol>
    </nav>

    {{-- Encabezado + acciones --}}
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <div>
            <h1 class="h3 mb-0">
                {{ $caso->titulo ?? 'Detalle del Caso' }}
            </h1>
            <small class="text-muted">
                Creado: {{ optional($caso->created_at)->format('d/m/Y H:i') }}
                @if(!empty($caso->codigo))
                    • Folio: <span class="fw-semibold">{{ $caso->codigo }}</span>
                @endif
            </small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('psicologa.casos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <a href="{{ route('psicologa.casos.edit', $caso) }}" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Editar
            </a>
            {{-- Si deseas permitir borrar el caso, descomenta:
            <form action="{{ route('psicologa.casos.destroy', $caso) }}" method="POST" onsubmit="return confirm('¿Eliminar definitivamente este caso?');">
                @csrf @method('DELETE')
                <button class="btn btn-danger"><i class="bi bi-trash"></i> Eliminar</button>
            </form>
            --}}
        </div>
    </div>

    {{-- Mensajes de estado --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! session('success') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {!! session('error') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Detalle del caso --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Información del caso</strong>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Estado</dt>
                        <dd class="col-sm-7">
                            <span class="badge text-bg-{{ ($caso->estado ?? '') === 'Cerrado' ? 'secondary' : 'success' }}">
                                {{ $caso->estado ?? 'Abierto' }}
                            </span>
                        </dd>

                        <dt class="col-sm-5">Fecha de apertura</dt>
                        <dd class="col-sm-7">{{ optional($caso->fecha_apertura)->format('d/m/Y') ?? '-' }}</dd>

                        @if(!empty($caso->fecha_cierre))
                            <dt class="col-sm-5">Fecha de cierre</dt>
                            <dd class="col-sm-7">{{ optional($caso->fecha_cierre)->format('d/m/Y') }}</dd>
                        @endif

                        @if(!empty($caso->profesional))
                            <dt class="col-sm-5">Profesional asignada</dt>
                            <dd class="col-sm-7">{{ $caso->profesional }}</dd>
                        @endif

                        @if(!empty($caso->proyecto))
                            <dt class="col-sm-5">Proyecto</dt>
                            <dd class="col-sm-7">{{ is_string($caso->proyecto) ? $caso->proyecto : ($caso->proyecto->nombre ?? '-') }}</dd>
                        @endif
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl class="row mb-0">
                        @if(!empty($caso->paciente_nombre))
                            <dt class="col-sm-5">Persona atendida</dt>
                            <dd class="col-sm-7">{{ $caso->paciente_nombre }}</dd>
                        @endif

                        @if(!empty($caso->paciente_edad))
                            <dt class="col-sm-5">Edad</dt>
                            <dd class="col-sm-7">{{ $caso->paciente_edad }}</dd>
                        @endif

                        @if(!empty($caso->paciente_sexo))
                            <dt class="col-sm-5">Sexo</dt>
                            <dd class="col-sm-7">{{ $caso->paciente_sexo }}</dd>
                        @endif

                        @if(!empty($caso->canal_referencia))
                            <dt class="col-sm-5">Canal de referencia</dt>
                            <dd class="col-sm-7">{{ $caso->canal_referencia }}</dd>
                        @endif
                    </dl>
                </div>

                @if(!empty($caso->resumen) || !empty($caso->descripcion))
                    <div class="col-12">
                        <hr>
                        <h6 class="mb-2">Resumen / Descripción</h6>
                        <p class="mb-0">{{ $caso->resumen ?? $caso->descripcion }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Formulario: nuevo seguimiento --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Agregar seguimiento</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('psicologa.seguimientos.store', $caso) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf

                <div class="col-12">
                    <label for="descripcion" class="form-label">Descripción del seguimiento <span class="text-danger">*</span></label>
                    <textarea
                        name="descripcion"
                        id="descripcion"
                        rows="4"
                        class="form-control @error('descripcion') is-invalid @enderror"
                        placeholder="Escribe aquí el avance, intervención realizada, observaciones, acuerdos, etc."
                        required>{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="fecha" class="form-label">Fecha del seguimiento</label>
                    <input
                        type="date"
                        name="fecha"
                        id="fecha"
                        value="{{ old('fecha', now()->format('Y-m-d')) }}"
                        class="form-control @error('fecha') is-invalid @enderror">
                    @error('fecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="adjunto" class="form-label">Adjunto (opcional)</label>
                    <input
                        type="file"
                        name="adjunto"
                        id="adjunto"
                        class="form-control @error('adjunto') is-invalid @enderror"
                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                    @error('adjunto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Acepta PDF, imágenes o documentos (tamaño máx. según configuración).</div>
                </div>

                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Guardar seguimiento
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Lista de seguimientos --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Seguimientos</strong>
            <span class="badge text-bg-primary">{{ isset($caso->seguimientos) ? $caso->seguimientos->count() : 0 }}</span>
        </div>

        <div class="list-group list-group-flush">
            @forelse(($caso->seguimientos ?? collect())->sortByDesc('fecha')->values() as $seg)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="mb-0">Seguimiento #{{ $seg->id }}</h6>
                                <small class="text-muted">
                                    {{ optional($seg->fecha)->format('d/m/Y') ?? optional($seg->created_at)->format('d/m/Y H:i') }}
                                    @if(!empty($seg->creado_por_nombre))
                                        • por {{ $seg->creado_por_nombre }}
                                    @elseif(!empty($seg->user) && !empty($seg->user->name))
                                        • por {{ $seg->user->name }}
                                    @endif
                                </small>
                            </div>
                            @if(!empty($seg->descripcion))
                                <p class="mb-1 mt-2">{{ $seg->descripcion }}</p>
                            @endif

                            @if(!empty($seg->adjunto_path))
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($seg->adjunto_path) }}"
                                   target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-paperclip"></i> Ver adjunto
                                </a>
                            @endif
                        </div>

                        <form action="{{ route('psicologa.seguimientos.destroy', $seg) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar este seguimiento?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="list-group-item">
                    <div class="text-center text-muted py-3">
                        No hay seguimientos registrados aún.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
