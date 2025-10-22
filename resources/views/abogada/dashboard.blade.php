@extends('layouts.abogada')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-welcome">
    <h1 class="dashboard-title">Las Mélidas</h1>
    <p>Bienvenida, Abogada. Aquí tienes un resumen de tu actividad y tareas pendientes.</p>
</div>

<div class="dashboard-grid mb-20">
    <div class="card stat-card">
        <div class="icon" style="color: var(--success-color);"><i class="fas fa-balance-scale"></i></div>
        <div class="info">
            <h4>Casos Activos</h4>
            <p>{{ $casosActivosCount }}</p>
        </div>
    </div>
    <div class="card stat-card">
        <div class="icon" style="color: #95a5a6;"><i class="fas fa-archive"></i></div>
        <div class="info">
            <h4>Casos Cerrados</h4>
            <p>{{ $casosCerradosCount }}</p>
        </div>
    </div>
    <div class="card stat-card">
        <div class="icon" style="color: var(--accent-color);"><i class="fas fa-calendar-check"></i></div>
        <div class="info">
            <h4>Próximas Citas</h4>
            <p>{{ $proximasCitas->count() }}</p>
        </div>
    </div>
</div>

<div class="card citas-list">
    <div class="card-header">
        <h3><i class="fas fa-calendar-alt"></i> Detalle de Próximas Citas</h3>
    </div>
    <div class="card-body">
        <ul>
            @forelse($proximasCitas as $cita)
                <li>
                    <div>
                        <span class="fecha">{{ $cita->proxima_cita->format('d \d\e F, Y') }}</span>
                        <div class="caso-info">
                            Caso 
                            <a href="{{ route('abogada.casos.show', $cita->caso) }}">
                                {{ $cita->caso->codigo_caso }}
                            </a> - {{ $cita->caso->nombre_afectada }}
                        </div>
                    </div>
                    <a href="{{ route('abogada.casos.show', $cita->caso) }}" class="btn btn-primary">Ver Caso</a>
                </li>
            @empty
                <p>No tienes próximas citas programadas.</p>
            @endforelse
        </ul>
    </div>
</div>
@endsection