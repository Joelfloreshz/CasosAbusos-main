<?php

namespace App\Http\Controllers\Abogada;

use App\Http\Controllers\Controller;
use App\Models\Caso;
use App\Models\Seguimiento;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $abogadaId = Auth::id(); // Obtenemos el ID de la abogada autenticada

        // Contamos casos activos SOLO para esta abogada
        $casosActivosCount = Caso::where('usuario_id', $abogadaId)
                                 ->where('estado', 'activo')
                                 ->count();

        // Contamos casos cerrados SOLO para esta abogada
        $casosCerradosCount = Caso::where('usuario_id', $abogadaId)
                                  ->where('estado', 'cerrado')
                                  ->count();

        // Obtenemos próximas citas de seguimientos SOLO de los casos de esta abogada
        $proximasCitas = Seguimiento::whereHas('caso', function ($query) use ($abogadaId) {
                                        $query->where('usuario_id', $abogadaId)
                                              ->where('estado', 'activo'); // Solo de casos activos
                                    })
                                    ->whereNotNull('proxima_cita')
                                    ->where('proxima_cita', '>=', Carbon::today())
                                    ->orderBy('proxima_cita', 'asc')
                                    ->with('caso') // Cargamos la relación con el caso para mostrar detalles
                                    ->take(5) // Limitamos a las 5 más próximas, por ejemplo
                                    ->get();

        return view('abogada.dashboard', compact(
            'casosActivosCount',
            'casosCerradosCount',
            'proximasCitas'
        ));
    }
}