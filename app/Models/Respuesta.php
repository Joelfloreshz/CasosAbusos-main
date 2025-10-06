<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'sesion_id',
        'pregunta_id',
        'respuesta',
    ];

    // Relaciones
    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }

    // =====================================================
    // HELPERS - Métodos auxiliares para el desarrollo
    // =====================================================

    /**
     * Verifica si la respuesta tiene contenido.
     * 
     * Ejemplo de uso:
     * if ($respuesta->tieneRespuesta()) {
     *     // Mostrar respuesta
     * } else {
     *     echo "Pregunta sin contestar";
     * }
     *
     * @return bool True si hay respuesta, false si está vacía o null
     */
    public function tieneRespuesta(): bool
    {
        return !empty($this->respuesta);
    }

    /**
     * Verifica si la respuesta corresponde a una pregunta de tipo Sí/No.
     * 
     * Ejemplo de uso:
     * if ($respuesta->esRespuestaSiNo()) {
     *     // Mostrar como checkbox o badge
     * }
     *
     * @return bool True si es respuesta de Sí/No, false en caso contrario
     */
    public function isRespuestaSiNo(): bool
    {
        return $this->pregunta->tipo_respuesta === 'si_no';
    }

    /**
     * Verifica si la respuesta corresponde a una pregunta numérica.
     * 
     * Ejemplo de uso:
     * if ($respuesta->isRespuestaNumero()) {
     *     // Aplicar formato numérico
     *     echo number_format($respuesta->respuesta);
     * }
     *
     * @return bool True si es respuesta numérica, false en caso contrario
     */
    public function isRespuestaNumero(): bool
    {
        return $this->pregunta->tipo_respuesta === 'numero';
    }

    /**
     * Obtiene la respuesta formateada para mostrar al usuario.
     * - Si es Sí/No, convierte 1/0 a "Sí"/"No"
     * - Si está vacía, retorna "Sin respuesta"
     * - Para otros tipos, retorna el valor tal cual
     * 
     * Ejemplo de uso:
     * echo $respuesta->getRespuestaFormateada();
     * // Salida: "Sí", "No", "Sin respuesta", o el texto de la respuesta
     *
     * @return string La respuesta formateada para visualización
     */
    public function getRespuestaFormateada(): string
    {
        if (empty($this->respuesta)) {
            return 'Sin respuesta';
        }

        // Si es sí/no, traducir
        if ($this->esRespuestaSiNo()) {
            return $this->respuesta === '1' || $this->respuesta === 'si' ? 'Sí' : 'No';
        }

        return $this->respuesta;
    }
}