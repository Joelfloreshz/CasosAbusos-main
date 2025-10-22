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
            {{-- Título de la página a la izquierda --}}
            <h2>@yield('title', 'Portal de la Abogada')</h2>

            {{-- Menú de usuario a la derecha --}}
            <div class="user-menu">
                <button class="user-button">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ Auth::user()->nombre }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-edit fa-fw"></i> Mi Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt fa-fw"></i> Cerrar Sesión
                        </a>
                    </form>
                </div>
            </div>
        </header>
        
        <main class="content-wrapper">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>