<?php

namespace App\Http\Controllers\Abogada;

use App\Http\Controllers\Controller;
use App\Models\Caso; 
use App\Models\Seguimiento; 
use Illuminate\Http\Request;

class SeguimientoController extends Controller
{
    /**
     * Aquí guardo un nuevo seguimiento asociado a un caso.
     */
    public function store(Request $request, Caso $caso)
    {
        // Valido que la descripción y la fecha no estén vacías.
        $request->validate([
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'proxima_cita' => 'nullable|date|after_or_equal:fecha',
        ]);

        // Creo el nuevo seguimiento y lo asocio directamente con el caso.
        $caso->seguimientos()->create([
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'proxima_cita' => $request->proxima_cita,
            'usuario_id' => 4, // !!! OJO: De nuevo, ID temporal. Debe ser reemplazado por `auth()->id()`.
        ]);

        // Redirijo de vuelta a la página del caso con un mensaje de éxito.
        return back()->with('success', 'Seguimiento agregado exitosamente.');
    }

    /**
     * Aquí elimino un seguimiento.
     */
    public function destroy(Seguimiento $seguimiento)
    {
        // Borro el seguimiento.
        $seguimiento->delete();
        
        // Redirijo de vuelta a la página anterior con un mensaje.
        return back()->with('success', 'Seguimiento eliminado exitosamente.');
    }
}