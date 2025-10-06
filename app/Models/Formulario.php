<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'area',
        'activo',
        'creado_por',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'fecha_creacion' => 'datetime',
        ];
    }

    // Relaciones
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class)->orderBy('numero');
    }

    public function sesiones()
    {
        return $this->hasMany(Sesion::class);
    }

    // =====================================================
    // HELPERS - Métodos auxiliares para el desarrollo
    // =====================================================

    /**
     * Verifica si el formulario está activo.
     * 
     * Ejemplo de uso:
     * if ($formulario->isActive()) {
     *     // Mostrar en lista de formularios disponibles
     * }
     *
     * @return bool True si el formulario está activo, false en caso contrario
     */
    public function isActive(): bool
    {
        return $this->activo;
    }

    /**
     * Verifica si el formulario puede usarse para casos del área psicológica.
     * 
     * Ejemplo de uso:
     * if ($formulario->isParaPsicologica()) {
     *     // Mostrar en lista de formularios de psicología
     * }
     *
     * @return bool True si el formulario aplica para área psicológica, false en caso contrario
     */
    public function isParaPsicologica(): bool
    {
        return in_array($this->area, ['psicologica', 'ambas']);
    }

    /**
     * Verifica si el formulario puede usarse para casos del área jurídica.
     * 
     * Ejemplo de uso:
     * if ($formulario->isParaJuridica()) {
     *     // Mostrar en lista de formularios legales
     * }
     *
     * @return bool True si el formulario aplica para área jurídica, false en caso contrario
     */
    public function isParaJuridica(): bool
    {
        return in_array($this->area, ['juridica', 'ambas']);
    }

    /**
     * Verifica si este formulario puede aplicarse a un caso específico.
     * Compara el área del formulario con el tipo del caso.
     * 
     * Ejemplo de uso:
     * if ($formulario->aplicaParaCaso($caso)) {
     *     // Permitir usar este formulario para el caso
     * }
     *
     * @param Caso $caso El caso a evaluar
     * @return bool True si el formulario aplica para el caso, false en caso contrario
     */
    public function aplicaParaCaso(Caso $caso): bool
    {
        if ($this->area === 'ambas') {
            return true;
        }
        
        // Convertir tipo de caso a área
        $areaDelCaso = $caso->tipo === 'psicologico' ? 'psicologica' : 'juridica';
        return $this->area === $areaDelCaso;
    }

    /**
     * Obtiene el número total de preguntas que tiene el formulario.
     * 
     * Ejemplo de uso:
     * $total = $formulario->totalPreguntas();
     * echo "Este formulario tiene {$total} preguntas";
     *
     * @return int Cantidad de preguntas del formulario
     */
    public function totalPreguntas(): int
    {
        return $this->preguntas()->count();
    }
}