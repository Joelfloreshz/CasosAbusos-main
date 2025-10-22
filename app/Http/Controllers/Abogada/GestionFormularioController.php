<?php

namespace App\Http\Controllers\Abogada;

use App\Http\Controllers\Controller;
use App\Models\Formulario;
use App\Models\Pregunta;
use Illuminate\Http\Request;

class GestionFormularioController extends Controller
{
    // Muestra la lista de todos los formularios
    public function index()
    {
        $formularios = Formulario::latest()->get();
        return view('abogada.gestion-formularios.index', compact('formularios'));
    }

    // Muestra el formulario para crear un nuevo formulario
    public function create()
    {
        return view('abogada.gestion-formularios.create');
    }

    // Guarda el nuevo formulario en la BD
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:200',
            'tipo' => 'required|in:ingreso,seguimiento,evaluacion',
            'area' => 'required|in:psicologica,juridica,ambas',
        ]);

        Formulario::create($request->all() + ['creado_por' => 4]); // OJO: ID Temporal

        return redirect()->route('abogada.gestion-formularios.index')->with('success', 'Formulario creado con éxito.');
    }

    // Muestra la página para editar un formulario y sus preguntas
    public function edit(Formulario $gestion_formulario)
    {
        $formulario = $gestion_formulario->load('preguntas');
        return view('abogada.gestion-formularios.edit', compact('formulario'));
    }

    // Actualiza el formulario en la BD
    public function update(Request $request, Formulario $gestion_formulario)
    {
        $request->validate([
            'nombre' => 'required|string|max:200',
            'tipo' => 'required|in:ingreso,seguimiento,evaluacion',
            'area' => 'required|in:psicologica,juridica,ambas',
        ]);

        $gestion_formulario->update($request->all());

        return redirect()->route('abogada.gestion-formularios.edit', $gestion_formulario)->with('success', 'Formulario actualizado con éxito.');
    }

    // Elimina un formulario
    public function destroy(Formulario $gestion_formulario)
    {
        $gestion_formulario->delete();
        return redirect()->route('abogada.gestion-formularios.index')->with('success', 'Formulario eliminado con éxito.');
    }
}