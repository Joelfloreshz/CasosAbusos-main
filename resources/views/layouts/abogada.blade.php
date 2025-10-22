<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.png') }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false" class="flex h-screen bg-gray-100 dark:bg-gray-900">
        
        <div x-show="sidebarOpen" class="fixed inset-0 z-30 bg-black bg-opacity-50 transition-opacity lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        <aside
            x-cloak
            class="fixed inset-y-0 left-0 z-40 w-64 overflow-y-auto transition-transform duration-300 transform bg-gray-900 dark:bg-gray-800 lg:translate-x-0 lg:static lg:inset-0"
            :class="{ 'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen }"
        >
            <div class="flex items-center justify-center mt-8">
                <div class="flex items-center">
                    <span class="text-white dark:text-gray-200 text-2xl font-semibold"><i class="fas fa-landmark mr-2"></i>Las Mélidas</span>
                </div>
            </div>

            <nav class="mt-10">
                <a
                    class="flex items-center mt-4 py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ request()->routeIs('abogada.dashboard') ? 'bg-gray-700 bg-opacity-25 text-gray-100' : '' }}"
                    href="{{ route('abogada.dashboard') }}"
                >
                    <i class="fas fa-tachometer-alt fa-fw w-6 text-center"></i>
                    <span class="mx-3">Dashboard</span>
                </a>

                <a
                    class="flex items-center mt-4 py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ request()->routeIs('abogada.casos.*') ? 'bg-gray-700 bg-opacity-25 text-gray-100' : '' }}"
                    href="{{ route('abogada.casos.index') }}"
                >
                    <i class="fas fa-balance-scale fa-fw w-6 text-center"></i>
                    <span class="mx-3">Gestionar Casos</span>
                </a>

                 <a
                    class="flex items-center mt-4 py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 {{ request()->routeIs('abogada.gestion-formularios.*') ? 'bg-gray-700 bg-opacity-25 text-gray-100' : '' }}"
                    href="{{ route('abogada.gestion-formularios.index') }}"
                >
                    <i class="fas fa-clipboard-list fa-fw w-6 text-center"></i>
                    <span class="mx-3">Mis Formularios</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center py-4 px-6 bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 dark:text-gray-300 focus:outline-none lg:hidden">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                     <h2 class="ml-4 text-xl font-semibold text-gray-800 dark:text-gray-200 hidden sm:block">
                        @yield('title')
                    </h2>
                </div>

                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" class="relative block h-8 w-8 rounded-full overflow-hidden shadow focus:outline-none">
                         <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-500 text-white font-semibold">
                           {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}
                        </span>
                    </button>

                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md overflow-hidden shadow-xl z-20" x-transition x-cloak>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-600 hover:text-white">
                            <i class="fas fa-user-edit fa-fw mr-2"></i>Mi Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-600 hover:text-white">
                                <i class="fas fa-sign-out-alt fa-fw mr-2"></i>Cerrar Sesión
                            </a>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900">
                <div class="container mx-auto px-6 py-8">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 sm:hidden">
                       @yield('title')
                    </h2>
                    @if(session('success'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
                             class="mb-4 px-4 py-3 leading-normal text-green-700 bg-green-100 dark:bg-green-800 dark:text-green-100 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                     @if(session('error'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
                             class="mb-4 px-4 py-3 leading-normal text-red-700 bg-red-100 dark:bg-red-800 dark:text-red-100 rounded-lg" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>