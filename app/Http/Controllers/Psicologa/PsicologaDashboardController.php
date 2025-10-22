<?php

namespace App\Http\Controllers\Psicologa;

use App\Http\Controllers\Controller;
use App\Models\CasoPsicologico;
use App\Models\SeguimientoPsicologico;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PsicologaDashboardController extends Controller
{
    public function index()
    {
        // ⚙️ Si aún no existen las tablas, usamos datos de prueba (mock)
        if (! Schema::hasTable('casos_psicologicos') || ! Schema::hasTable('seguimientos_psicologicos')) {
            $casosActivosCount  = 8;
            $casosCerradosCount = 12;

            $proximasCitas = collect([
                (object)[
                    'proxima_cita' => Carbon::now()->addDays(1)->setTime(9, 30),
                    'descripcion'  => 'Evaluación inicial',
                    'caso'         => (object)[
                        'id'                  => 1,
                        'codigo_caso'         => 'PSI-0001',
                        'codigo_beneficiaria' => 'BEN-001',
                    ],
                ],
                (object)[
                    'proxima_cita' => Carbon::now()->addDays(2)->setTime(11, 0),
                    'descripcion'  => 'Sesión de seguimiento',
                    'caso'         => (object)[
                        'id'                  => 2,
                        'codigo_caso'         => 'PSI-0002',
                        'codigo_beneficiaria' => 'BEN-014',
                    ],
                ],
                (object)[
                    'proxima_cita' => Carbon::now()->addDays(3)->setTime(15, 15),
                    'descripcion'  => 'Terapia grupal',
                    'caso'         => (object)[
                        'id'                  => 3,
                        'codigo_caso'         => 'PSI-0003',
                        'codigo_beneficiaria' => 'BEN-032',
                    ],
                ],
            ]);

            Log::warning('⚠️ Dashboard Psicóloga: usando datos mock (no existen tablas reales todavía).');

            return view('psicologa.dashboard', compact(
                'proximasCitas',
                'casosActivosCount',
                'casosCerradosCount'
            ));
        }

        // ✅ Cuando ya existan las tablas, usa datos reales
        $proximasCitas = SeguimientoPsicologico::with('caso')
            ->whereNotNull('proxima_cita')
            ->where('proxima_cita', '>=', now()->startOfDay())
            ->orderBy('proxima_cita', 'asc')
            ->take(5)
            ->get();

        $casosActivosCount  = CasoPsicologico::where('estado', 'activo')->count();
        $casosCerradosCount = CasoPsicologico::where('estado', 'cerrado')->count();

        return view('psicologa.dashboard', compact(
            'proximasCitas',
            'casosActivosCount',
            'casosCerradosCount'
        ));
    }
}
