@extends('layouts.abogada')

@section('title', 'Dashboard Abogada')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Bienvenida, {{ Auth::user()->nombre }}</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Resumen de tu actividad y tareas pendientes.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex items-center space-x-4">
            <div class="p-3 rounded-full bg-green-100 dark:bg-green-800 text-green-600 dark:text-green-300">
                <i class="fas fa-balance-scale fa-lg"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Casos Activos</p>
                <p class="text-2xl font-semibold text-gray-800 dark:text-gray-100">{{ $casosActivosCount }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex items-center space-x-4">
             <div class="p-3 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                <i class="fas fa-archive fa-lg"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Casos Cerrados</p>
                <p class="text-2xl font-semibold text-gray-800 dark:text-gray-100">{{ $casosCerradosCount }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex items-center space-x-4">
            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-300">
                 <i class="fas fa-calendar-check fa-lg"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Próximas Citas</D>
                <p class="text-2xl font-semibold text-gray-800 dark:text-gray-100">{{ $proximasCitas->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center">
                <i class="fas fa-calendar-alt mr-3"></i> Detalle de Próximas Citas
            </h3>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($proximasCitas as $cita)
                <div class="px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                    <div>
                        <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ optional($cita->proxima_cita)->isoFormat('dddd, D [de] MMMM, YYYY') }}</span>
                         @if(optional($cita->proxima_cita)->isToday())
                             <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-200">
                                Hoy
                             </span>
                        @elseif(optional($cita->proxima_cita)->isTomorrow())
                             <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-200">
                                Mañana
                             </span>
                        @endif
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Caso
                            <a href="{{ route('abogada.casos.show', $cita->caso) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                                {{ $cita->caso->codigo_caso }}
                            </a> - {{ $cita->caso->nombre_afectada }}
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-300 mt-1 italic">{{ Str::limit($cita->descripcion, 80) }}</p>
                    </div>
                    <div class="mt-2 sm:mt-0">
                        <a href="{{ route('abogada.casos.show', $cita->caso) }}"
                           class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-offset-gray-900">
                            Ver Caso
                        </a>
                    </div>
                </div>
            @empty
                <div class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    No tienes próximas citas programadas.
                </div>
            @endforelse
        </div>
    </div>
@endsection