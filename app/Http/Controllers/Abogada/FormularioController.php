<?php

namespace App\Http\Controllers\Abogada;

use App\Http\Controllers\Controller;
use App\Models\Caso;
use App\Models\Formulario;
use App\Models\Sesion;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    /**
     * Aquí muestro los formularios que la abogada puede aplicar a un caso específico.
     */
    public function index(Caso $caso)
    {
        // Obtengo todos los formularios activos que sean del área jurídica o de ambas áreas.
        $formularios = Formulario::where('activo', true)
            ->where(function ($query) {
                $query->where('area', 'juridica')->orWhere('area', 'ambas');
            })->get();
        
        return view('abogada.formularios.index', compact('caso', 'formularios'));
    }

    /**
     * Aquí preparo e inicio una nueva "sesión" para llenar un formulario.
     */
    public function show(Caso $caso, Formulario $formulario)
    {
        // Creo un nuevo registro de sesión para este caso y formulario.
        $sesion = Sesion::create([
            'caso_id' => $caso->id,
            'formulario_id' => $formulario->id,
            'usuario_id' => 4, // !!! OJO: ID temporal, reemplazar con auth()->id()
            'completado' => false,
        ]);

        // Cargo las preguntas del formulario para mostrarlas.
        $formulario->load('preguntas');

        return view('abogada.formularios.show', compact('caso', 'formulario', 'sesion'));
    }
    
    /**
     * Aquí muestro una sesión que ya ha sido completada.
     */
    public function verSesion(Sesion $sesion)
    {
        // Cargo toda la información relacionada: caso, formulario, preguntas y las respuestas guardadas.
        $sesion->load('caso', 'formulario.preguntas', 'respuestas.pregunta');

        return view('abogada.sesiones.show', compact('sesion'));
    }
}