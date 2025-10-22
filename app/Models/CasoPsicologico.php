<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasoPsicologico extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla en la base de datos.
     */
    protected $table = 'casos_psicologicos';

    /**
     * Campos que pueden asignarse masivamente (fillable).
     */
    protected $fillable = [
        'codigo_caso',
        'fecha_ingreso',
        'estado',
        'codigo_beneficiaria',
        'edad',
        'departamento',
        'municipio',
        'nivel_educativo',
        'tipo_violencia',
        'institucion_remite',
        'modalidad_atencion',
        'motivo_consulta',
        'observaciones_iniciales',
        'proyecto_codigo',
    ];

    /**
     * Atributos convertidos a tipos nativos de PHP.
     */
    protected $casts = [
        'fecha_ingreso' => 'date',
    ];

    /**
     * Relación uno a muchos con SeguimientoPsicologico.
     * Un caso psicológico puede tener varios seguimientos.
     */
    public function seguimientos()
    {
        return $this->hasMany(SeguimientoPsicologico::class, 'caso_psicologico_id', 'id');
    }

    /**
     * (Opcional) Scope para filtrar casos activos.
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * (Opcional) Scope para filtrar casos cerrados.
     */
    public function scopeCerrados($query)
    {
        return $query->where('estado', 'cerrado');
    }
}
