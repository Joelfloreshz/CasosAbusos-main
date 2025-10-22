{{-- Layout: Psicóloga --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Gestión de Casos') }} - @yield('title')</title>

    {{-- Estilos principales --}}
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-brain" style="font-size: 2rem;"></i>
        </div>

        <ul class="sidebar-menu">
            <li class="{{ request()->routeIs('psicologa.dashboard') ? 'active' : '' }}">
                <a href="{{ route('psicologa.dashboard') }}">
                    <i class="fas fa-tachometer-alt fa-fw"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <li class="{{ request()->is('psicologa/casos') || request()->is('psicologa/casos/*') ? 'active' : '' }}">
                <a href="{{ route('psicologa.casos.index') }}">
                    <i class="fas fa-folder-open fa-fw"></i>
                    <span class="menu-text">Casos Psicológicos</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('psicologa.casos.create') ? 'active' : '' }}">
                <a href="{{ route('psicologa.casos.create') }}">
                    <i class="fas fa-user-plus fa-fw"></i>
                    <span class="menu-text">Nuevo Caso</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- Contenido principal --}}
    <div class="main-content">
        <header class="top-header">
            <h2>@yield('title', 'Portal de la Psicóloga')</h2>

            <div class="user-menu">
                <button class="user-button">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ Auth::user()->nombre }}</span>
                    <small style="opacity:.7;margin-left:.5rem;">(Psicóloga)</small>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-pen fa-fw"></i> Mi Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fas fa-right-from-bracket fa-fw"></i> Cerrar Sesión
                        </a>
                    </form>
                </div>
            </div>
        </header>

        <main class="content-wrapper">
            @yield('content')
        </main>
    </div>

    {{-- SweetAlert2 global --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Inyecta los flashes en JSON puro (el editor no lo interpreta como JS) --}}
    <script id="flash-data" type="application/json">
    @json([
        'success' => session('success'),
        'error'   => session('error'),
    ])
    </script>

    {{-- Lee el JSON y dispara los popups --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
    let flash = {};
    const el = document.getElementById('flash-data');
    if (el) {
        try { flash = JSON.parse(el.textContent || '{}'); } catch (e) { flash = {}; }
    }

    if (flash.success) {
        Swal.fire({ icon: 'success', title: 'Listo', text: flash.success });
    }
    if (flash.error) {
        Swal.fire({ icon: 'error', title: 'Error', text: flash.error });
    }
    });
    </script>

    @stack('scripts')
</body>
</html>
