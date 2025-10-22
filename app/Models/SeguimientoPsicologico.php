<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SeguimientoPsicologico extends Model
{
    use HasFactory;

    /** Tabla **/
    protected $table = 'seguimientos_psicologicos';

    /** Asignación masiva **/
    protected $fillable = [
        'caso_psicologico_id',
        'fecha_sesion',
        'modalidad',       // presencial | virtual | telefónica ...
        'descripcion',
        'resultado',
        'proxima_cita',
    ];

    /** Conversión de tipos **/
    protected $casts = [
        'fecha_sesion' => 'datetime',
        'proxima_cita' => 'datetime',
    ];

    /** Relaciones **/
    public function caso()
    {
        // clave foránea y clave local explícitas por claridad
        return $this->belongsTo(CasoPsicologico::class, 'caso_psicologico_id', 'id');
    }

    /** ---------- Scopes de consulta útiles ---------- */

    /** Próximas citas (>= hoy, orden ascendente) */
    public function scopeUpcoming(Builder $q): Builder
    {
        return $q->whereNotNull('proxima_cita')
                 ->where('proxima_cita', '>=', now()->startOfDay())
                 ->orderBy('proxima_cita', 'asc');
    }

    /** Por caso */
    public function scopeForCase(Builder $q, int|string $casoId): Builder
    {
        return $q->where('caso_psicologico_id', $casoId);
    }

    /** Entre fechas de sesión (incluyentes) */
    public function scopeBetween(Builder $q, $from, $to): Builder
    {
        return $q->whereBetween('fecha_sesion', [
            \Illuminate\Support\Carbon::parse($from)->startOfDay(),
            \Illuminate\Support\Carbon::parse($to)->endOfDay(),
        ]);
    }

    /** ---------- Mutators / Normalización ---------- */

    /** Normaliza modalidad (minúsculas y sin espacios extra) */
    protected function modalidad(): Attribute
    {
        return Attribute::make(
            set: fn ($v) => $v ? strtolower(trim($v)) : null,
        );
    }

    /** Limpia descripción */
    protected function descripcion(): Attribute
    {
        return Attribute::make(
            set: fn ($v) => $v ? trim($v) : null,
        );
    }

    /** Limpia resultado */
    protected function resultado(): Attribute
    {
        return Attribute::make(
            set: fn ($v) => $v ? trim($v) : null,
        );
    }
}

