<?php

namespace App\Http\Controllers\Abogada;

use App\Http\Controllers\Controller;
use App\Models\Caso;
use App\Models\Seguimiento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    // Busco los seguimientos con próximas citas que aún no han pasado.
    $proximasCitas = Seguimiento::whereNotNull('proxima_cita')
        // La condición correcta es buscar fechas mayores o iguales a hoy.
        ->where('proxima_cita', '>=', now()->startOfDay())
        ->whereHas('caso', function ($query) {
            $query->where('tipo', 'juridico');
        })
        ->orderBy('proxima_cita', 'asc')
        ->with('caso')
        ->take(5)
        ->get();
        
    // Cuento cuántos casos jurídicos están activos.
    $casosActivosCount = Caso::where('tipo', 'juridico')->where('estado', 'activo')->count();

    // Cuento los casos cerrados.
    $casosCerradosCount = Caso::where('tipo', 'juridico')->where('estado', 'cerrado')->count();

    // Envío los datos, incluyendo el nuevo contador, a la vista del dashboard.
    return view('abogada.dashboard', compact('proximasCitas', 'casosActivosCount', 'casosCerradosCount'));
}
}