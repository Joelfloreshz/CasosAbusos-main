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

        // Contamos casos en juicio SOLO para esta abogada
        $casosEnJuicioCount = Caso::where('usuario_id', $abogadaId)
                                  ->where('estado', 'En Juicio') // Usamos 'En Juicio'
                                  ->count(); // <-- ESTA LÍNEA ESTABA FALTANDO

        // Contamos casos cerrados SOLO para esta abogada
        $casosCerradosCount = Caso::where('usuario_id', $abogadaId)
                                  ->where('estado', 'cerrado')
                                  ->count();

        // Obtenemos próximas citas de seguimientos SOLO de los casos de esta abogada (Activos o En Juicio)
        $proximasCitas = Seguimiento::whereHas('caso', function ($query) use ($abogadaId) {
                                        $query->where('usuario_id', $abogadaId)
                                              ->whereIn('estado', ['activo', 'En Juicio']); // <-- Usamos 'En Juicio'
                                    })
                                    ->whereNotNull('proxima_cita')
                                    ->where('proxima_cita', '>=', Carbon::today())
                                    ->orderBy('proxima_cita', 'asc')
                                    ->with('caso') 
                                    ->take(5) 
                                    ->get();

        // Pasamos la nueva variable a la vista
        return view('abogada.dashboard', compact(
            'casosActivosCount',
            'casosEnJuicioCount', 
            'casosCerradosCount',
            'proximasCitas'
        ));
    }
}