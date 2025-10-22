<?php

namespace App\Http\Controllers\Abogada;

use App\Http\Controllers\Controller;
use App\Models\Respuesta;
use App\Models\Sesion;
use Illuminate\Http\Request;

class RespuestaController extends Controller
{
    /**
     * Aquí guardo todas las respuestas de un formulario.
     */
    public function store(Request $request, Sesion $sesion)
    {
        // El request traerá un array de respuestas, con el ID de la pregunta como clave.
        $respuestas = $request->input('respuestas', []);

        // Recorro cada respuesta enviada desde el formulario.
        foreach ($respuestas as $preguntaId => $respuestaTexto) {
            // Uso `updateOrCreate` para crear la respuesta si no existe, o actualizarla si ya se había guardado algo.
            // Esto es útil si el usuario guarda un borrador y luego continúa.
            Respuesta::updateOrCreate(
                ['sesion_id' => $sesion->id, 'pregunta_id' => $preguntaId],
                ['respuesta' => $respuestaTexto]
            );
        }

        // Una vez guardadas todas las respuestas, marco la sesión como completada.
        $sesion->update(['completado' => true]);

        // Redirijo al detalle del caso con un mensaje de éxito.
        return redirect()->route('abogada.casos.show', $sesion->caso_id)
            ->with('success', 'Formulario guardado y sesión completada.');
    }
}