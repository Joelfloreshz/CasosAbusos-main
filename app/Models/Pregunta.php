<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'formulario_id',
        'numero',
        'pregunta',
        'tipo_respuesta',
        'opciones',
        'requerida',
    ];

    protected function casts(): array
    {
        return [
            'requerida' => 'boolean',
            'numero' => 'integer',
        ];
    }

    // Relaciones
    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }

    // =====================================================
    // HELPERS - Métodos auxiliares para el desarrollo
    // =====================================================

    /**
     * Verifica si la pregunta es obligatoria.
     * 
     * Ejemplo de uso:
     * if ($pregunta->isRequired()) {
     *     // Marcar campo como obligatorio en el formulario
     *     echo '<span class="required">*</span>';
     * }
     *
     * @return bool True si la pregunta es requerida, false en caso contrario
     */
    public function isRequired(): bool
    {
        return $this->requerida;
    }

    /**
     * Verifica si la pregunta tiene opciones de selección múltiple.
     * 
     * Ejemplo de uso:
     * if ($pregunta->tieneOpciones()) {
     *     // Mostrar select/radio buttons con las opciones
     * }
     *
     * @return bool True si es pregunta múltiple con opciones, false en caso contrario
     */
    public function tieneOpciones(): bool
    {
        return $this->tipo_respuesta === 'multiple' && !empty($this->opciones);
    }

    /**
     * Obtiene las opciones de la pregunta como un array.
     * Las opciones están almacenadas como texto separado por comas.
     * 
     * Ejemplo de uso:
     * $opciones = $pregunta->getOpcionesArray();
     * foreach ($opciones as $opcion) {
     *     echo "<option>{$opcion}</option>";
     * }
     *
     * @return array Array de opciones, o array vacío si no hay opciones
     */
    public function getOpcionesArray(): array
    {
        if (empty($this->opciones)) {
            return [];
        }
        
        return array_map('trim', explode(',', $this->opciones));
    }

    /**
     * Verifica si la pregunta espera una respuesta de tipo texto.
     * 
     * Ejemplo de uso:
     * if ($pregunta->isText()) {
     *     // Mostrar textarea o input text
     * }
     *
     * @return bool True si es pregunta de texto, false en caso contrario
     */
    public function isText(): bool
    {
        return $this->tipo_respuesta === 'texto';
    }

    /**
     * Verifica si la pregunta espera una respuesta numérica.
     * 
     * Ejemplo de uso:
     * if ($pregunta->isNumber()) {
     *     // Mostrar input type="number"
     * }
     *
     * @return bool True si es pregunta numérica, false en caso contrario
     */
    public function isNumber(): bool
    {
        return $this->tipo_respuesta === 'numero';
    }

    /**
     * Verifica si la pregunta espera una respuesta de Sí/No.
     * 
     * Ejemplo de uso:
     * if ($pregunta->isSiNo()) {
     *     // Mostrar radio buttons Sí/No o checkbox
     * }
     *
     * @return bool True si es pregunta de Sí/No, false en caso contrario
     */
    public function isSiNo(): bool
    {
        return $this->tipo_respuesta === 'si_no';
    }

    /**
     * Verifica si la pregunta es de selección múltiple.
     * 
     * Ejemplo de uso:
     * if ($pregunta->isMultiple()) {
     *     // Mostrar select o radio buttons con opciones
     * }
     *
     * @return bool True si es pregunta múltiple, false en caso contrario
     */
    public function isMultiple(): bool
    {
        return $this->tipo_respuesta === 'multiple';
    }
}