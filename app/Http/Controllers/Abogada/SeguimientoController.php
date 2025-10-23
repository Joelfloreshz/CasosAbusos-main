<?php

namespace App\Http\Controllers\Abogada;

use App\Http\Controllers\Controller;
use App\Models\Caso;
use App\Models\Seguimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

class SeguimientoController extends Controller
{
    use AuthorizesRequests; 
    public function store(Request $request, Caso $caso)
    {
        $this->authorize('update', $caso); 
        $validated = $request->validate([
            'fecha' => ['required', 'date'],
            'tipo_actuacion' => ['nullable', 'string', 'max:100'],
            'descripcion' => ['required', 'string', 'max:5000'],
            'proxima_cita' => ['nullable', 'date', 'after_or_equal:fecha'],
        ]);
        $seguimiento = new Seguimiento($validated);
        $seguimiento->caso_id = $caso->id;
        $seguimiento->usuario_id = Auth::id();
        $seguimiento->save();
        return redirect()->route('abogada.casos.show', $caso)
                         ->with('success', 'Seguimiento registrado exitosamente.');
    }

    public function destroy(Seguimiento $seguimiento)
    {
        $caso = $seguimiento->caso;
        $this->authorize('update', $caso); 
        $seguimiento->delete();
        return redirect()->route('abogada.casos.show', $caso)
                         ->with('success', 'Seguimiento eliminado exitosamente.');
    }
}