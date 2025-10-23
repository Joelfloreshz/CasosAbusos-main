<?php

namespace App\Http\Controllers\Abogada;

use App\Http\Controllers\Controller;
use App\Models\Caso;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CasoController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $abogadaId = Auth::id();
        $proyectos = Proyecto::orderBy('nombre')->get(); 


        $filtros = $request->only(['estado', 'nombre_afectada', 'codigo_caso', 'proyecto_id']);
        $query = Caso::where('usuario_id', $abogadaId)
                     ->with(['usuario', 'proyecto']) 
                     ->orderBy('fecha_ingreso', 'desc');
        $query->when($filtros['estado'] ?? null, function ($q, $estado) {
            return $q->where('estado', $estado);
        });

        $query->when($filtros['nombre_afectada'] ?? null, function ($q, $nombre) {
            return $q->where('nombre_afectada', 'like', '%' . $nombre . '%');
        });

        $query->when($filtros['codigo_caso'] ?? null, function ($q, $codigo) {
            return $q->where('codigo_caso', 'like', '%' . $codigo . '%');
        });

        $query->when($filtros['proyecto_id'] ?? null, function ($q, $proyectoId) {
            return $q->where('proyecto_id', $proyectoId);
        });
        $casos = $query->paginate(10)->appends($filtros);
        return view('abogada.casos.index', compact('casos', 'proyectos', 'filtros'));
    }
    public function create()
    {
        $proyectos = Proyecto::orderBy('nombre')->get();
        return view('abogada.casos.form', compact('proyectos'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_caso' => ['required', 'string', 'max:255', Rule::unique('casos')],
            'fecha_ingreso' => ['required', 'date'],
            'estado' => ['required', 'string', Rule::in(['activo', 'cerrado', 'En Juicio'])], // <-- CAMBIADO AQUÍ
            'proyecto_id' => ['nullable', 'integer', 'exists:proyectos,id'],
            'nombre_afectada' => ['required', 'string', 'max:255'],
            'dui' => ['nullable', 'string', 'max:20'],
            'edad' => ['nullable', 'integer', 'min:0'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'departamento' => ['nullable', 'string', 'max:100'],
            'municipio' => ['nullable', 'string', 'max:100'],
            'motivo' => ['nullable', 'string', 'max:5000'],
            'nombre_agresor' => ['nullable', 'string', 'max:255'],
            'parentesco_agresor' => ['nullable', 'string', 'max:100'],
            'estado_civil_agresor' => ['nullable', 'string', 'max:100'],
            'ocupacion_agresor' => ['nullable', 'string', 'max:255'],
        ]);

        $caso = new Caso($validated);
        $caso->usuario_id = Auth::id();
        $caso->save();
        if ($request->input('action') == 'save_and_form') {
            return redirect()->route('abogada.formularios.index', $caso)
                             ->with('success', 'Caso registrado. Por favor, llene el formulario de ingreso.');
        }
        return redirect()->route('abogada.casos.show', $caso)
                         ->with('success', 'Caso registrado exitosamente.');
    }
    public function show(Caso $caso)
    {
        $this->authorize('view', $caso);
        $caso->load('proyecto');
        return view('abogada.casos.show', compact('caso'));
    }
    public function edit(Caso $caso)
    {
        $this->authorize('update', $caso);
        $proyectos = Proyecto::orderBy('nombre')->get();
        return view('abogada.casos.form', compact('caso', 'proyectos'));
    }
    public function update(Request $request, Caso $caso)
    {
        $this->authorize('update', $caso);

        $validated = $request->validate([
            'codigo_caso' => ['required', 'string', 'max:255', Rule::unique('casos')->ignore($caso->id)],
            'fecha_ingreso' => ['required', 'date'],
            'estado' => ['required', 'string', Rule::in(['activo', 'cerrado', 'En Juicio'])], // <-- CAMBIADO AQUÍ
            'proyecto_id' => ['nullable', 'integer', 'exists:proyectos,id'],
            'nombre_afectada' => ['required', 'string', 'max:255'],
            'dui' => ['nullable', 'string', 'max:20'],
            'edad' => ['nullable', 'integer', 'min:0'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'departamento' => ['nullable', 'string', 'max:100'],
            'municipio' => ['nullable', 'string', 'max:100'],
            'motivo' => ['nullable', 'string', 'max:5000'],
            'nombre_agresor' => ['nullable', 'string', 'max:255'],
            'parentesco_agresor' => ['nullable', 'string', 'max:100'],
            'estado_civil_agresor' => ['nullable', 'string', 'max:100'],
            'ocupacion_agresor' => ['nullable', 'string', 'max:255'],
        ]);

        $caso->update($validated);

        return redirect()->route('abogada.casos.show', $caso)->with('success', 'Caso actualizado exitosamente.');
    }

    public function destroy(Caso $caso)
    {
        $this->authorize('delete', $caso);
        $caso->delete();
        return redirect()->route('abogada.casos.index')->with('success', 'Caso eliminado exitosamente.');
    }
}