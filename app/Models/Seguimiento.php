<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Seguimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'caso_id',
        'usuario_id',
        'fecha',
        'tipo_actuacion',
        'descripcion',
        'proxima_cita',
    ];

    protected $casts = [
        'fecha' => 'date',
        'proxima_cita' => 'date',
    ];

    public function caso()
    {
        return $this->belongsTo(Caso::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    public function getFechaAttribute($value)
    {
        return Carbon::parse($value);
    }
    public function getProximaCitaAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }
}