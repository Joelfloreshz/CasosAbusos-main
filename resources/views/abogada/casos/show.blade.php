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
                @if($caso->isActive())
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
                    <span class="ml-1 px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $caso->estado == 'activo' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                        {{ ucfirst($caso->estado) }}
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
                <i class="fas fa-history mr-3"></i> Historial de Seguimientos
            </h3>
            @if($caso->isActive())
                <button id="toggle-seguimiento-form" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus"></i>
                </button>
            @endif
        </div>
        
        <div id="form-seguimiento-container" style="display: none;" class="px-6 py-4 border-b border-dashed border-gray-300 dark:border-gray-600">
            @if($caso->isActive())
                <form action="{{ route('abogada.seguimientos.store', $caso) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="fecha" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha del Seguimiento</label>
                            <input type="date" id="fecha" name="fecha" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div>
                            <label for="proxima_cita" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Próxima Cita (Opcional)</label>
                            <input type="date" id="proxima_cita" name="proxima_cita" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción (Avances, notas, nuevos hechos)</label>
                        <textarea id="descripcion" name="descripcion" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" required placeholder="Describe aquí los avances del caso..."></textarea>
                    </div>
                    <div class="text-right mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Guardar Seguimiento
                        </button>
                    </div>
                </form>
            @endif
        </div>

        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($caso->seguimientos->sortByDesc('fecha') as $seguimiento)
                <div class="px-6 py-4 relative group hover:bg-gray-50 dark:hover:bg-gray-700">
                    <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <form action="{{ route('abogada.seguimientos.destroy', $seguimiento) }}" method="POST" onsubmit="return confirm('¿Confirmas que quieres eliminar este seguimiento?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center h-6 w-6 rounded-full text-xs text-white bg-red-500 hover:bg-red-700 focus:outline-none">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>

                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $seguimiento->fecha->isoFormat('dddd, D [de] MMMM, YYYY') }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Registrado por: {{ $seguimiento->usuario->nombre }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $seguimiento->descripcion }}</p>
                    @if($seguimiento->proxima_cita)
                        <p class="mt-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                            <i class="fas fa-calendar-check mr-1.5"></i> Próxima Cita: {{ $seguimiento->proxima_cita->isoFormat('dddd, D [de] MMMM') }}
                        </p>
                    @endif
                </div>
            @empty
                <p class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">No hay seguimientos registrados para este caso.</p>
            @endforelse
        </div>
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