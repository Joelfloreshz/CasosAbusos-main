<?php

namespace App\Http\Controllers\Psicologa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CasoPsicologico;
use App\Models\SeguimientoPsicologico;

class PsicologaSeguimientoController extends Controller
{
    /**
     * Guarda un nuevo seguimiento asociado a un caso psicológico.
     */
    public function store(Request $request, $casoId)
    {
        $request->validate([
            'fecha_sesion' => 'required|date',
            'modalidad' => 'required|string|max:100',
            'descripcion' => 'required|string|max:1000',
            'resultado' => 'nullable|string|max:1000',
            'proxima_cita' => 'nullable|date',
        ]);

        $caso = CasoPsicologico::findOrFail($casoId);

        $seguimiento = new SeguimientoPsicologico();
        $seguimiento->caso_psicologico_id = $caso->id;
        $seguimiento->fecha_sesion = $request->fecha_sesion;
        $seguimiento->modalidad = $request->modalidad;
        $seguimiento->descripcion = $request->descripcion;
        $seguimiento->resultado = $request->resultado;
        $seguimiento->proxima_cita = $request->proxima_cita;
        $seguimiento->save();

        return redirect()
            ->route('psicologa.casos.show', $caso->id)
            ->with('success', 'Seguimiento registrado correctamente.');
    }

    /**
     * Elimina un seguimiento psicológico.
     */
    public function destroy($id)
    {
        $seguimiento = SeguimientoPsicologico::findOrFail($id);
        $seguimiento->delete();

        return back()->with('success', 'Seguimiento eliminado correctamente.');
    }
}
