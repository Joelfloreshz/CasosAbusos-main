@extends('layouts.abogada')

@section('title', 'Gestionar Casos Jurídicos')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Casos Jurídicos</h1>
    <a href="{{ route('abogada.casos.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 flex-shrink-0">
        <i class="fas fa-plus mr-2"></i>
        Nuevo Caso
    </a>
</div>

{{-- Formulario de Filtros --}}
<div class="mb-6 bg-white dark:bg-gray-800 shadow rounded-lg p-4">
    <form action="{{ route('abogada.casos.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
        <div>
            <label for="codigo_caso" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código Caso</label>
            <input type="text" name="codigo_caso" id="codigo_caso" value="{{ $filtros['codigo_caso'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" placeholder="Buscar por código...">
        </div>
        <div>
            <label for="nombre_afectada" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre Afectada</label>
            <input type="text" name="nombre_afectada" id="nombre_afectada" value="{{ $filtros['nombre_afectada'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm" placeholder="Buscar por nombre...">
        </div>
        <div>
            <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
            <select name="estado" id="estado" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                <option value="">Todos</option>
                <option value="activo" @selected(($filtros['estado'] ?? '') == 'activo')>Activo</option>
                <option value="cerrado" @selected(($filtros['estado'] ?? '') == 'cerrado')>Cerrado</option>
            </select>
        </div>
         <div>
            <label for="proyecto_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proyecto</label>
            <select name="proyecto_id" id="proyecto_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100 sm:text-sm">
                <option value="">Todos</option>
                @foreach($proyectos as $proyecto)
                    <option value="{{ $proyecto->id }}" @selected(($filtros['proyecto_id'] ?? '') == $proyecto->id)>
                        {{ $proyecto->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="sm:col-span-2 lg:col-span-4 flex justify-end space-x-2">
             <a href="{{ route('abogada.casos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-100 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150">
                Limpiar
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                Filtrar
            </button>
        </div>
    </form>
</div>
{{-- Fin Formulario de Filtros --}}


<div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Código
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Afectada
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Fecha Ing. / Proyecto
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Estado
                </th>
                {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Responsable
                </th> --}}
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse ($casos as $caso)
                <tr
                    x-data="{ link: '{{ route('abogada.casos.show', $caso) }}' }"
                    @click="window.location.href = link"
                    class="hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition duration-150 ease-in-out"
                >
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600 dark:text-indigo-400">
                         {{ $caso->codigo_caso }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                        {{ $caso->nombre_afectada }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                       <div>{{ $caso->fecha_ingreso->format('d/m/Y') }}</div>
                       <div class="text-xs text-gray-500">{{ $caso->proyecto->nombre ?? 'Sin proyecto' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $caso->estado == 'activo' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                            {{ ucfirst($caso->estado) }}
                        </span>
                    </td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                        {{ $caso->usuario->nombre }}
                    </td> --}}
                   <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end items-center space-x-2">
                            <form
                                x-data
                                @click.stop=""
                                action="{{ route('abogada.casos.destroy', $caso) }}"
                                method="POST"
                                onsubmit="return confirm('¿Estás segura de que quieres eliminar este caso? Esta acción no se puede deshacer.');"
                                class="inline-block m-0 p-0"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 p-1 rounded-md transition duration-150 ease-in-out" title="Eliminar Caso">
                                    <i class="fas fa-trash fa-fw"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center"> {{-- Ajustar colspan a 5 --}}
                        No hay casos jurídicos que coincidan con los filtros aplicados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación --}}
    @if ($casos->hasPages())
        <div class="px-6 py-4 border-t dark:border-gray-700">
            {{-- Los enlaces ya incluyen los filtros gracias a ->appends() en el controlador --}}
            {{ $casos->links() }}
        </div>
    @endif
</div>
@endsection