<?php

namespace App\Providers;

use App\Models\Caso; // Asegúrate de importar el modelo Caso
use App\Policies\CasoPolicy; // Asegúrate de importar la CasoPolicy
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy', // Ejemplo de Breeze
        Caso::class => CasoPolicy::class, // <-- AÑADE O VERIFICA ESTA LÍNEA
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}