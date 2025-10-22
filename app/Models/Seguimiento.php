<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Seguimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'caso_id',
        'fecha',
        'descripcion',
        'proxima_cita',
        'usuario_id',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime', 
            'proxima_cita' => 'datetime',
            'fecha_creacion' => 'datetime',
        ];
    }

    // Relaciones
    public function caso()
    {
        return $this->belongsTo(Caso::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    // =====================================================
    // HELPERS - Métodos auxiliares para el desarrollo
    // =====================================================

    /**
     * Verifica si el seguimiento tiene programada una próxima cita.
     * 
     * Ejemplo de uso:
     * if ($seguimiento->tieneProximaCita()) {
     *     echo "Próxima cita: " . $seguimiento->proxima_cita->format('d/m/Y');
     * }
     *
     * @return bool True si hay próxima cita programada, false en caso contrario
     */
    public function tieneProximaCita(): bool
    {
        return $this->proxima_cita !== null;
    }

    /**
     * Verifica si la próxima cita ya pasó (está vencida).
     * 
     * Ejemplo de uso:
     * if ($seguimiento->proximaCitaVencida()) {
     *     // Mostrar alerta "Cita vencida"
     *     echo '<span class="badge badge-danger">Cita vencida</span>';
     * }
     *
     * @return bool True si la cita está vencida, false si no hay cita o aún no ha pasado
     */
    public function proximaCitaVencida(): bool
    {
        if (!$this->proxima_cita) {
            return false;
        }
        
        return $this->proxima_cita->lt(now()->startOfDay());
    }

    /**
     * Verifica si la próxima cita es hoy.
     * 
     * Ejemplo de uso:
     * if ($seguimiento->proximaCitaHoy()) {
     *     // Mostrar notificación "Tiene cita hoy"
     *     echo '<span class="badge badge-warning">Cita hoy</span>';
     * }
     *
     * @return bool True si la cita es hoy, false en caso contrario
     */
    public function proximaCitaHoy(): bool
    {
        return $this->proxima_cita?->isToday() ?? false;
    }
}