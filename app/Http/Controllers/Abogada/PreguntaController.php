<?php

namespace App\Http\Controllers\Abogada;

use App\Http\Controllers\Controller;
use App\Models\Formulario;
use App\Models\Pregunta;
use Illuminate\Http\Request;

class PreguntaController extends Controller
{
    // Guarda una nueva pregunta para un formulario
    public function store(Request $request, Formulario $gestion_formulario)
    {
        $request->validate([
            'pregunta' => 'required|string',
            'tipo_respuesta' => 'required|in:texto,numero,si_no,multiple',
            'numero' => 'required|integer',
            'opciones' => 'nullable|string',
            'requerida' => 'boolean',
        ]);

        $gestion_formulario->preguntas()->create($request->all());

        return back()->with('success', 'Pregunta agregada con éxito.');
    }

    // Actualiza una pregunta existente
    public function update(Request $request, Formulario $gestion_formulario, Pregunta $pregunta)
    {
        $request->validate([
            'pregunta' => 'required|string',
            'tipo_respuesta' => 'required|in:texto,numero,si_no,multiple',
            'numero' => 'required|integer',
        ]);

        $pregunta->update($request->all());

        return redirect()->route('abogada.gestion-formularios.edit', $gestion_formulario)->with('success', 'Pregunta actualizada.');
    }

    // Elimina una pregunta
    public function destroy(Formulario $gestion_formulario, Pregunta $pregunta)
    {
        $pregunta->delete();
        return back()->with('success', 'Pregunta eliminada.');
    }
}