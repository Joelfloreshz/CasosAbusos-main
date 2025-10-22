<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Caso extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_caso',
        'fecha_ingreso',
        'nombre_afectada',
        'dui',
        'edad',
        'telefono',
        'departamento',
        'municipio',
        'motivo',
        'estado',
        'usuario_id',
        'proyecto_id',
        'nombre_agresor',
        'parentesco_agresor',
        'estado_civil_agresor',
        'ocupacion_agresor',
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
    ];

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

    public function isActive()
    {
        return $this->estado === 'activo';
    }

    public function getFechaIngresoAttribute($value)
    {
        return Carbon::parse($value);
    }
}