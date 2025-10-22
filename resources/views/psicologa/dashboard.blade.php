@extends('layouts.psicologa')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-welcome">
    <h1 class="dashboard-title">Las Mélidas</h1>
    <p>Bienvenida, Psicóloga. Aquí tienes un resumen de tu actividad y citas.</p>
</div>

<div class="dashboard-grid mb-20">
    <!-- Casos Activos -->
    <div class="card stat-card">
        <div class="icon" style="color: var(--success-color);">
            <i class="fas fa-brain"></i>
        </div>
        <div class="info">
            <h4>Casos Activos</h4>
            <p>{{ $casosActivosCount }}</p>
        </div>
    </div>

    <!-- Casos Cerrados -->
    <div class="card stat-card">
        <div class="icon" style="color: #95a5a6;">
            <i class="fas fa-archive"></i>
        </div>
        <div class="info">
            <h4>Casos Cerrados</h4>
            <p>{{ $casosCerradosCount }}</p>
        </div>
    </div>

    <!-- Próximas Citas -->
    <div class="card stat-card">
        <div class="icon" style="color: var(--primary-color);">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="info">
            <h4>Próximas Citas</h4>
            <p>{{ $proximasCitas->count() }}</p>
        </div>
    </div>
</div>

<!-- Detalle de Próximas Citas -->
<div class="card mt-4">
    <div class="card-header">
        <i class="fas fa-calendar-day"></i> Detalle de Próximas Citas
    </div>

    <div class="card-body">
        @if($proximasCitas->isEmpty())
            <p>No tienes próximas citas programadas.</p>
        @else
            <ul class="list-group list-group-flush">
                @foreach($proximasCitas as $cita)
                    @php
                        $caso = optional($cita)->caso;
                    @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fecha d-block mb-1">
                                {{ optional($cita->proxima_cita)->translatedFormat('d \d\e F, Y') }}
                            </span>
                            <div class="caso-info">
                                Caso:
                                @if($caso)
                                    <a href="{{ route('psicologa.casos.show', $caso->id) }}">
                                        {{ $caso->codigo_caso ?? 'Sin código' }}
                                    </a>
                                    — Beneficiaria:
                                    {{ $caso->codigo_beneficiaria ?? 'No registrada' }}
                                @else
                                    <em>Sin caso asociado</em>
                                @endif
                            </div>
                        </div>

                        @if($caso)
                            <a href="{{ route('psicologa.casos.show', $caso->id) }}" class="btn btn-primary">
                                Ver Caso
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
