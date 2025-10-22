@php
// Determinar la ruta correcta del dashboard según el rol
$dashboardRoute = match(Auth::user()->rol ?? null) {
    'abogada' => route('abogada.dashboard'),
    'psicologa' => route('psicologa.dashboard'),
    default => route('dashboard') // Ruta genérica por defecto
};

// Determinar si la ruta activa es la correcta para el rol
$isDashboardActive = match(Auth::user()->rol ?? null) {
    'abogada' => request()->routeIs('abogada.dashboard'),
    'psicologa' => request()->routeIs('psicologa.dashboard'),
    default => request()->routeIs('dashboard')
};
@endphp

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{--
                // SECCIÓN COMENTADA: Logo
                <div class="shrink-0 flex items-center">
                    <a href="{{ $dashboardRoute }}">
                        <svg class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M25,3C12.85,3,3,12.85,3,25c0,12.15,9.85,22,22,22c12.15,0,22-9.85,22-22C47,12.85,37.15,3,25,3z M25,43 c-9.925,0-18-8.075-18-18S15.075,7,25,7s18,8.075,18,18S34.925,43,25,43z M31.543,23.543l-8.086,8.086l-4.043-4.043 c-0.781-0.781-2.047-0.781-2.828,0c-0.781,0.781-0.781,2.047,0,2.828l5.457,5.457c0.391,0.391,0.902,0.586,1.414,0.586 s1.023-0.195,1.414-0.586l9.5-9.5c0.781-0.781,0.781-2.047,0-2.828C33.59,22.762,32.324,22.762,31.543,23.543z"/></svg>
                    </a>
                </div>
                --}}

                {{--
                // SECCIÓN COMENTADA: Navigation Links (Dashboard)
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="$dashboardRoute" :active="$isDashboardActive">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                --}}
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 ml-auto"> {{-- Añadido ml-auto para empujar a la derecha --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->nombre }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Mi Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        {{--
        // SECCIÓN COMENTADA: Enlace Dashboard Responsivo
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="$dashboardRoute" :active="$isDashboardActive">
                 {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
        --}}

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->nombre }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>