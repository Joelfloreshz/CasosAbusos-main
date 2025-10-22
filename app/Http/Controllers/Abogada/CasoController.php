<?php

namespace App\Http\Controllers\Abogada;

use App\Http\Controllers\Controller;
use App\Models\Caso; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class CasoController extends Controller
{
    /**
     * Muestro una lista de todos los casos jurídicos.
     */
    public function index()
    {
        // Obtengo de la base de datos solo los casos de tipo 'juridico'.
        // Con 'with('usuario')' traigo también los datos de quien lo registró.
        // 'latest()' los ordena del más nuevo al más viejo.
        $casos = Caso::where('tipo', 'juridico')->with('usuario')->latest()->get();

        // Envío los datos a la vista para que se muestren en la tabla.
        return view('abogada.casos.index', compact('casos'));
    }

    /**
     * Muestro el formulario para crear un nuevo caso.
     */
    public function create()
    {
        // Solo muestro el formulario vacío.
        return view('abogada.casos.form');
    }

    /**
     * Guardo un nuevo caso en la base de datos.
     */
    public function store(Request $request)
    {
        // Verifico que los datos del formulario sean correctos.
        $request->validate([
            'codigo_caso' => 'required|string|max:30|unique:casos',
            'nombre_afectada' => 'required|string|max:150',
            'fecha_ingreso' => 'required|date',
        ]);

        // Creo el caso con todos los datos del formulario y añado los que son fijos.
        Caso::create($request->all() + [
            'tipo' => 'juridico', // Defino el tipo como 'juridico' por defecto.
            'usuario_id' => Auth::id(), // Asigno el ID del usuario que ha iniciado sesión.
        ]);

        // Redirijo a la lista de casos con un mensaje de confirmación.
        return redirect()->route('abogada.casos.index')->with('success', 'Caso creado exitosamente.');
    }

    /**
     * Muestro los detalles de un caso específico y sus seguimientos.
     */
    public function show(Caso $caso)
    {
        // Cargo la relación con 'seguimientos' y también el 'usuario' que registró cada seguimiento.
        $caso->load('seguimientos.usuario');
        
        // Muestro la vista de detalles del caso.
        return view('abogada.casos.show', compact('caso'));
    }

    /**
     * Muestro el formulario para editar un caso que ya existe.
     */
    public function edit(Caso $caso)
    {
        // Reutilizo el mismo formulario de creación, pero le envío los datos del caso para rellenarlo.
        return view('abogada.casos.form', compact('caso'));
    }

    /**
     * Actualizo la información de un caso en la base de datos.
     */
    public function update(Request $request, Caso $caso)
    {
        // Verifico los datos. La regla 'unique' se ajusta para ignorar el caso actual.
        $request->validate([
            'codigo_caso' => 'required|string|max:30|unique:casos,codigo_caso,' . $caso->id,
            'nombre_afectada' => 'required|string|max:150',
            'fecha_ingreso' => 'required|date',
        ]);

        // Actualizo el caso con los datos del formulario.
        $caso->update($request->all());

        // Redirijo a la lista de casos con un mensaje de confirmación.
        return redirect()->route('abogada.casos.index')->with('success', 'Caso actualizado exitosamente.');
    }

    /**
     * Elimino un caso de la base de datos.
     */
    public function destroy(Caso $caso)
    {
        // Borro el caso.
        $caso->delete();

        // Redirijo a la lista de casos con un mensaje de confirmación.
        return redirect()->route('abogada.casos.index')->with('success', 'Caso eliminado exitosamente.');
    }
}