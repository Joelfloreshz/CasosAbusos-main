<?php

namespace App\Http\Controllers\Abogada;

use App\Http\Controllers\Controller;
use App\Models\Caso; 
use Illuminate\Http\Request;

class CasoController extends Controller
{
    /**
     * Aquí muestro una lista de todos los casos jurídicos.
     */
    public function index()
    {
        // Pido a la base de datos todos los casos donde el 'tipo' sea 'juridico'.
        // Además, uso `with('usuario')` para traer también la información del usuario responsable (la abogada).
        // `latest()` los ordena del más reciente al más antiguo.
        $casos = Caso::where('tipo', 'juridico')->with('usuario')->latest()->get();

        // Devuelvo la vista 'index' y le paso la variable $casos para que pueda mostrar los datos.
        return view('abogada.casos.index', compact('casos'));
    }

    /**
     * Aquí muestro el formulario para crear un nuevo caso.
     */
    public function create()
    {
        // Simplemente muestro el formulario de creación.
        return view('abogada.casos.form');
    }

    /**
     * Aquí guardo un nuevo caso en la base de datos.
     */
    public function store(Request $request)
    {
        // Valido los datos que vienen del formulario. Si algo falla, Laravel regresa al formulario con los errores.
        $request->validate([
            'codigo_caso' => 'required|string|max:30|unique:casos',
            'nombre_afectada' => 'required|string|max:150',
            'fecha_ingreso' => 'required|date',
            // Agrego más validaciones según el modelo
        ]);

        // Si la validación pasa, creo el nuevo caso.
        Caso::create(array_merge($request->all(), [
            'tipo' => 'juridico', // Como estoy en el controlador de la abogada, el tipo siempre será 'juridico'.
            'usuario_id' => 4, // !!! OJO: He puesto el ID 4 (abogada@melidas.org) temporalmente.
                               
        ]));

        // Redirijo al usuario a la lista de casos con un mensaje de éxito.
        return redirect()->route('abogada.casos.index')->with('success', 'Caso creado exitosamente.');
    }

    /**
     * Aquí muestro los detalles de un caso específico, incluyendo sus seguimientos.
     */
    public function show(Caso $caso)
    {
        // Laravel automáticamente encuentra el caso por su ID.
        // Cargo la relación con 'seguimientos' y el 'usuario' de cada seguimiento.
        $caso->load('seguimientos.usuario');
        
        // Muestro la vista de detalles y le paso el caso que encontré.
        return view('abogada.casos.show', compact('caso'));
    }

    /**
     * Aquí muestro el formulario para editar un caso existente.
     */
    public function edit(Caso $caso)
    {
        // Reutilizo el mismo formulario de 'crear', pero le paso los datos del caso para que se llenen los campos.
        return view('abogada.casos.form', compact('caso'));
    }

    /**
     * Aquí actualizo la información de un caso en la base de datos.
     */
    public function update(Request $request, Caso $caso)
    {
        // Valido los datos. Ignoro la regla 'unique' para el código del caso actual.
        $request->validate([
            'codigo_caso' => 'required|string|max:30|unique:casos,codigo_caso,' . $caso->id,
            'nombre_afectada' => 'required|string|max:150',
            'fecha_ingreso' => 'required|date',
        ]);

        // Actualizo el caso con los nuevos datos del formulario.
        $caso->update($request->all());

        // Redirijo a la lista de casos con un mensaje de éxito.
        return redirect()->route('abogada.casos.index')->with('success', 'Caso actualizado exitosamente.');
    }

    /**
     * Aquí elimino un caso de la base de datos.
     */
    public function destroy(Caso $caso)
    {
        // Encuentro el caso y lo borro.
        $caso->delete();

        // Redirijo a la lista de casos con un mensaje de éxito.
        return redirect()->route('abogada.casos.index')->with('success', 'Caso eliminado exitosamente.');
    }
}