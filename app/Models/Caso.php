<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caso extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_caso',
        'tipo',
        'nombre_afectada',
        'dui',
        'edad',
        'telefono',
        'departamento',
        'municipio',
        'zona',
        'nombre_agresor',
        'parentesco_agresor',
        'fecha_ingreso',
        'motivo',
        'estado',
        'usuario_id',
        'proyecto_id',
    ];

    protected function casts(): array
    {
        return [
            'fecha_ingreso' => 'date',
            'fecha_creacion' => 'datetime',
            'edad' => 'integer',
        ];
    }

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class);
    }

    public function sesiones()
    {
        return $this->hasMany(Sesion::class);
    }

    // =====================================================
    // HELPERS - Métodos auxiliares para el desarrollo
    // =====================================================

    /**
     * Verifica si el caso está en estado activo.
     * 
     * Ejemplo de uso:
     * if ($caso->isActive()) {
     *     // Permitir agregar seguimientos
     * }
     *
     * @return bool True si el caso está activo, false en caso contrario
     */
    public function isActive(): bool
    {
        return $this->estado === 'activo';
    }

    /**
     * Verifica si el caso está cerrado.
     * 
     * Ejemplo de uso:
     * if ($caso->isClosed()) {
     *     // Mostrar mensaje "Caso archivado"
     * }
     *
     * @return bool True si el caso está cerrado, false en caso contrario
     */
    public function isClosed(): bool
    {
        return $this->estado === 'cerrado';
    }

    /**
     * Verifica si el caso es de tipo psicológico.
     * 
     * Ejemplo de uso:
     * if ($caso->isPsicologico()) {
     *     // Asignar a psicóloga disponible
     * }
     *
     * @return bool True si es caso psicológico, false en caso contrario
     */
    public function isPsicologico(): bool
    {
        return $this->tipo === 'psicologico';
    }

    /**
     * Verifica si el caso es de tipo jurídico.
     * 
     * Ejemplo de uso:
     * if ($caso->isJuridico()) {
     *     // Asignar a abogada disponible
     * }
     *
     * @return bool True si es caso jurídico, false en caso contrario
     */
    public function isJuridico(): bool
    {
        return $this->tipo === 'juridico';
    }

    /**
     * Cierra el caso cambiando su estado a 'cerrado'.
     * Persiste automáticamente el cambio en la base de datos.
     * 
     * Ejemplo de uso:
     * $caso->cerrarCaso();
     * // El caso ahora está marcado como cerrado
     *
     * @return void
     */
    public function cerrarCaso(): void
    {
        $this->update(['estado' => 'cerrado']);
    }

    /**
     * Reabre el caso cambiando su estado a 'activo'.
     * Útil cuando se necesita volver a trabajar un caso que fue cerrado.
     * 
     * Ejemplo de uso:
     * $caso->reabrirCaso();
     * // El caso ahora está activo nuevamente
     *
     * @return void
     */
    public function reabrirCaso(): void
    {
        $this->update(['estado' => 'activo']);
    }
}