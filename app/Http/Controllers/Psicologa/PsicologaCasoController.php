<?php

namespace App\Http\Controllers\Psicologa;

use App\Http\Controllers\Controller;
use App\Models\CasoPsicologico;
use App\Models\SeguimientoPsicologico;

class PsicologaCasoController extends Controller
{
    public function index()
    {
        // Próximas citas (hoy en adelante), ordenadas ascendente
        $proximasCitas = SeguimientoPsicologico::whereNotNull('proxima_cita')
            ->where('proxima_cita', '>=', now()->startOfDay())
            ->whereHas('caso', function ($q) {
                // Si manejas "estado" en el caso, puedes filtrar activos aquí si quieres:
                // $q->where('estado', 'activo');
            })
            ->with('caso')
            ->orderBy('proxima_cita', 'asc')
            ->take(5)
            ->get();

        // Contadores de casos psicológicos
        $casosActivosCount  = CasoPsicologico::where('estado', 'activo')->count();
        $casosCerradosCount = CasoPsicologico::where('estado', 'cerrado')->count();

        return view('psicologa.casos.index', compact(
            'proximasCitas',
            'casosActivosCount',
            'casosCerradosCount'
        ));
    }
}
