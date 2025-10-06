<<<<<<< HEAD
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
=======
{{-- Ruta: resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Casos - @yield('title')</title>
    
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-landmark" style="font-size: 2rem;"></i>
        </div>
        <ul class="sidebar-menu">
            {{-- Aquí defino los enlaces del menú lateral con sus iconos. --}}
            <li>
                <a href="{{ route('abogada.dashboard') }}">
                    <i class="fas fa-tachometer-alt fa-fw"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('abogada.casos.index') }}">
                    <i class="fas fa-balance-scale fa-fw"></i>
                    <span class="menu-text">Gestionar Casos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('abogada.casos.create') }}">
                    <i class="fas fa-plus-circle fa-fw"></i>
                    <span class="menu-text">Nuevo Caso</span>
                </a>
            </li>
            <li>
        <a href="{{ route('abogada.gestion-formularios.index') }}">
            <i class="fas fa-clipboard-list fa-fw"></i>
            <span class="menu-text">Mis Formularios</span>
        </a>
    </li>
        </ul>
    </div>

    <div class="main-content">
        <header class="top-header">
            {{-- El título de la página se mostrará en una barra superior dentro del área de contenido. --}}
            <h2>@yield('title', 'Portal de la Abogada')</h2>
        </header>
        
        <main class="content-wrapper">
             {{-- El contenido específico de cada página se cargará aquí. --}}
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
>>>>>>> 2db7b9b3c58367576d586ab5834e47ec5be16048
