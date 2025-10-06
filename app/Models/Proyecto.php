<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'donante',
        'fecha_inicio',
        'fecha_fin',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'activo' => 'boolean',
        ];
    }

    // Relaciones
    public function casos()
    {
        return $this->hasMany(Caso::class);
    }

    // =====================================================
    // HELPERS - Métodos auxiliares para el desarrollo
    // =====================================================

    /**
     * Verifica si el proyecto está marcado como activo.
     * 
     * Ejemplo de uso:
     * if ($proyecto->isActive()) {
     *     // Mostrar proyecto en lista de activos
     * }
     *
     * @return bool True si el proyecto está activo, false en caso contrario
     */
    public function isActive(): bool
    {
        return $this->activo;
    }

    /**
     * Verifica si el proyecto está vigente según sus fechas.
     * Un proyecto es vigente si la fecha actual está entre fecha_inicio y fecha_fin.
     * 
     * Ejemplo de uso:
     * if ($proyecto->isVigente()) {
     *     // Permitir agregar nuevos casos al proyecto
     * }
     *
     * @return bool True si el proyecto está vigente, false si ya finalizó o no ha iniciado
     */
    public function isVigente(): bool
    {
        $hoy = now()->startOfDay();
        return $hoy->between($this->fecha_inicio, $this->fecha_fin);
    }
}