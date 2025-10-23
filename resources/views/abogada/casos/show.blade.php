@extends('layouts.abogada')

@section('title', 'Detalle del Caso ' . $caso->codigo_caso)

@section('content')

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100"><i class="fas fa-briefcase mr-2"></i> {{ $caso->codigo_caso }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $caso->nombre_afectada }}</p>
                <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400 mt-1">
                    <i class="fas fa-project-diagram fa-fw mr-1"></i>
                    {{ $caso->proyecto->nombre ?? 'Sin proyecto asignado' }}
                </p>
            </div>
            <div class="flex-shrink-0 flex gap-2">
                <a href="{{ route('abogada.casos.edit', $caso) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-edit mr-1.5"></i> Editar
                </a>
                @if($caso->estado == 'activo')
                    <a href="{{ route('abogada.formularios.index', $caso) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-file-alt mr-1.5"></i> Iniciar Formulario
                    </a>
                @endif
            </div>
        </div>
        <div class="px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Datos de la Afectada</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold text-gray-800 dark:text-gray-100">DUI:</strong> {{ $caso->dui ?? 'No especificado' }}</p>
                <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold text-gray-800 dark:text-gray-100">Ubicación:</strong> {{ $caso->municipio ?? 'N/A' }}, {{ $caso->departamento ?? 'N/A' }}</p>
                <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold text-gray-800 dark:text-gray-100">Edad:</strong> {{ $caso->edad ?? 'No especificada' }}</p>
                <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold text-gray-800 dark:text-gray-100">Fecha de Ingreso:</strong> {{ $caso->fecha_ingreso->format('d/m/Y') }}</p>
                <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold text-gray-800 dark:text-gray-100">Teléfono:</strong> {{ $caso->telefono ?? 'No especificado' }}</p>
                <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold text-gray-800 dark:text-gray-100">Estado:</strong>
                    <span @class([
                        'ml-1 px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full',
                        'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200' => $caso->estado == 'activo',
                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-200' => $caso->estado == 'En Juicio',
                        'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' => $caso->estado == 'cerrado',
                    ])>
                         {{ match($caso->estado) {'activo' => 'Activo', 'cerrado' => 'Cerrado', 'En Juicio' => 'En Juicio', default => ucfirst($caso->estado)} }}
                    </span>
                </p>
                <p class="md:col-span-2 text-gray-700 dark:text-gray-300"><strong class="font-semibold text-gray-800 dark:text-gray-100">Motivo de Consulta:</strong> {{ $caso->motivo }}</p>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                 <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Datos del Agresor</h3>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold text-gray-800 dark:text-gray-100">Nombre:</strong> {{ $caso->nombre_agresor ?? 'No especificado' }}</p>
                    <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold text-gray-800 dark:text-gray-100">Parentesco:</strong> {{ $caso->parentesco_agresor ?? 'No especificado' }}</p>
                    <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold text-gray-800 dark:text-gray-100">Estado Civil:</strong> {{ $caso->estado_civil_agresor ?? 'No especificado' }}</p>
                    <p class="text-gray-700 dark:text-gray-300"><strong class="font-semibold text-gray-800 dark:text-gray-100">Ocupación:</strong> {{ $caso->ocupacion_agresor ?? 'No especificado' }}</p>
                 </div>
            </div>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center">
                <i class="fas fa-history mr-3"></i> Bitácora / Historial de Seguimiento
            </h3>
            @if($caso->estado == 'activo' || $caso->estado == 'En Juicio')
                <button id="toggle-seguimiento-form" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus"></i> Añadir Actuación
                </button>
            @endif
        </div>

        {{-- Formulario para añadir seguimiento --}}
        <div id="form-seguimiento-container" style="display: none;" class="px-6 py-4 border-b border-dashed border-gray-300 dark:border-gray-600">
            @if($caso->estado == 'activo' || $caso->estado == 'En Juicio')
                <form action="{{ route('abogada.seguimientos.store', $caso) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="fecha" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha</label>
                            <input type="date" id="fecha" name="fecha" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div>
                             <label for="tipo_actuacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo Actuación</label>
                             <select id="tipo_actuacion" name="tipo_actuacion" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                                 <option value="">Seleccione...</option>
                                 <option value="Llamada">Llamada</option>
                                 <option value="Reunión">Reunión</option>
                                 <option value="Asesoría">Asesoría</option>
                                 <option value="Presentación Escrito">Presentación Escrito</option>
                                 <option value="Audiencia">Audiencia</option>
                                 <option value="Investigación">Investigación</option>
                                 <option value="Notificación">Notificación</option>
                                 <option value="Trámite Administrativo">Trámite Administrativo</option>
                                 <option value="Otro">Otro</option>
                             </select>
                        </div>
                        <div>
                            <label for="proxima_cita" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Próxima Cita (Opcional)</label>
                            <input type="date" id="proxima_cita" name="proxima_cita" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción Detallada</label>
                        <textarea id="descripcion" name="descripcion" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" required placeholder="Describe aquí los detalles de la actuación..."></textarea>
                    </div>
                    <div class="text-right mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Guardar Seguimiento
                        </button>
                    </div>
                </form>
             @else
                <p class="text-sm text-center text-gray-500 dark:text-gray-400">Este caso está cerrado y no se pueden añadir nuevos seguimientos.</p>
            @endif
        </div>
        <div class="p-6 space-y-6">
            @forelse($caso->seguimientos->sortByDesc('fecha') as $seguimiento)
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow border border-gray-200 dark:border-gray-600 relative group">
                    {{-- Botón Eliminar --}}
                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <form action="{{ route('abogada.seguimientos.destroy', $seguimiento) }}" method="POST" onsubmit="return confirm('¿Confirmas que quieres eliminar este seguimiento?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center h-6 w-6 rounded-full text-xs text-white bg-red-500 hover:bg-red-700 focus:outline-none">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 pb-2 border-b border-gray-300 dark:border-gray-500">
                        <h4 class="text-base font-semibold text-gray-800 dark:text-gray-100 flex items-center">
                            @php
                                $icon = match($seguimiento->tipo_actuacion) {
                                    'Llamada' => 'fa-phone-alt',
                                    'Reunión' => 'fa-users',
                                    'Asesoría' => 'fa-chalkboard-teacher',
                                    'Presentación Escrito' => 'fa-file-signature',
                                    'Audiencia' => 'fa-gavel',
                                    'Investigación' => 'fa-search',
                                    'Notificación' => 'fa-envelope-open-text',
                                    'Trámite Administrativo' => 'fa-building',
                                    default => 'fa-clipboard-list'
                                };
                            @endphp
                            <i class="fas {{ $icon }} fa-fw mr-2 text-indigo-500 dark:text-indigo-400"></i>
                            {{ $seguimiento->tipo_actuacion ?? 'Actuación' }}
                        </h4>
                        <span class="text-sm text-gray-600 dark:text-gray-400 mt-1 sm:mt-0">
                            {{ $seguimiento->fecha->isoFormat('dddd, D [de] MMMM, YYYY') }}
                        </span>
                    </div>

                    {{-- Descripción --}}
                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap mb-2">{{ $seguimiento->descripcion }}</p>

                    {{-- Próxima Cita --}}
                    @if($seguimiento->proxima_cita)
                        <p class="text-sm font-semibold text-green-600 dark:text-green-400 border-t border-gray-300 dark:border-gray-500 pt-2 mt-2">
                            <i class="fas fa-calendar-check fa-fw mr-1.5"></i> Próxima Cita: {{ $seguimiento->proxima_cita->isoFormat('dddd, D [de] MMMM') }}
                        </p>
                    @endif

                    {{-- Registrado por --}}
                     <p class="text-xs text-gray-500 dark:text-gray-400 text-right mt-2">Registrado por: {{ $seguimiento->usuario->nombre }}</p>

                </div>
            @empty
                <p class="text-sm text-center text-gray-500 dark:text-gray-400 py-4">No hay seguimientos registrados para este caso.</p>
            @endforelse
        </div>
        {{-- Fin Nuevo Diseño Lista --}}
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center">
                <i class="fas fa-tasks mr-3"></i> Sesiones de Formularios Completadas
            </h3>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($caso->sesiones->where('completado', true) as $sesion)
                <div class="px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <div>
                        <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $sesion->formulario->nombre }}</span>
                        <span class="text-sm text-gray-600 dark:text-gray-400">- Completado el {{ $sesion->updated_at->format('d/m/Y') }}</span>
                    </div>
                    <a href="{{ route('abogada.sesiones.show', $sesion) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Ver Respuestas
                    </a>
                </div>
            @empty
                <p class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">No se ha completado ninguna sesión de formulario para este caso.</p>
            @endforelse
        </div>
    </div>

@endsection

@push('scripts')
{{-- Script para mostrar/ocultar formulario de seguimiento --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('toggle-seguimiento-form');
        const formContainer = document.getElementById('form-seguimiento-container');

        if (toggleButton) {
            toggleButton.addEventListener('click', function() {
                if (formContainer.style.display === 'none' || formContainer.style.display === '') {
                    formContainer.style.display = 'block';
                    toggleButton.innerHTML = '<i class="fas fa-minus"></i>';
                } else {
                    formContainer.style.display = 'none';
                    toggleButton.innerHTML = '<i class="fas fa-plus"></i>';
                }
            });
        }
    });
</script>
@endpush