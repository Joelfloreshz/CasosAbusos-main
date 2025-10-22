<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory;

    protected $fillable = [
        'caso_id',
        'formulario_id',
        'usuario_id',
        'fecha',
        'completado',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
            'completado' => 'boolean',
        ];
    }

    // Relaciones
    public function caso()
    {
        return $this->belongsTo(Caso::class);
    }

    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }

    // =====================================================
    // HELPERS - Métodos auxiliares para el desarrollo
    // =====================================================

    /**
     * Verifica si la sesión está marcada como completada.
     * 
     * Ejemplo de uso:
     * if ($sesion->isCompleted()) {
     *     // Mostrar badge "Completado"
     * }
     *
     * @return bool True si la sesión está completada, false en caso contrario
     */
    public function isCompleted(): bool
    {
        return $this->completado;
    }

    /**
     * Marca la sesión como completada.
     * Persiste automáticamente el cambio en la base de datos.
     * 
     * Ejemplo de uso:
     * $sesion->marcarComoCompletado();
     * // La sesión ahora aparecerá como completada
     *
     * @return void
     */
    public function marcarComoCompletado(): void
    {
        $this->update(['completado' => true]);
    }

    /**
     * Calcula el porcentaje de preguntas contestadas en la sesión.
     * 
     * Ejemplo de uso:
     * $porcentaje = $sesion->porcentajeCompletado();
     * echo "Progreso: {$porcentaje}%";
     * 
     * // Mostrar barra de progreso
     * <div class="progress-bar" style="width: {{ $sesion->porcentajeCompletado() }}%"></div>
     *
     * @return float Porcentaje de completado (0.00 a 100.00)
     */
    public function porcentajeCompletado(): float
    {
        $totalPreguntas = $this->formulario->preguntas()->count();
        
        if ($totalPreguntas === 0) {
            return 0;
        }
        
        $respuestasContestadas = $this->respuestas()->whereNotNull('respuesta')->count();
        
        return round(($respuestasContestadas / $totalPreguntas) * 100, 2);
    }

    /**
     * Verifica si faltan respuestas a preguntas obligatorias.
     * Útil para validar antes de marcar la sesión como completada.
     * 
     * Ejemplo de uso:
     * if ($sesion->faltanPreguntasRequeridas()) {
     *     // Mostrar error "Debe completar todas las preguntas obligatorias"
     *     return back()->withErrors('Faltan preguntas obligatorias');
     * }
     * $sesion->marcarComoCompletado();
     *
     * @return bool True si faltan preguntas requeridas por contestar, false si todas están contestadas
     */
    public function faltanPreguntasRequeridas(): bool
    {
        $preguntasRequeridas = $this->formulario->preguntas()
            ->where('requerida', true)
            ->pluck('id');
        
        $respuestasRequeridas = $this->respuestas()
            ->whereIn('pregunta_id', $preguntasRequeridas)
            ->whereNotNull('respuesta')
            ->pluck('pregunta_id');
        
        return $preguntasRequeridas->count() !== $respuestasRequeridas->count();
    }
}