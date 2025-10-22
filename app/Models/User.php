<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'usuario',
        'email',
        'password',
        'nombre',
        'rol',
        'activo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
            'fecha_creacion' => 'datetime',
        ];
    }

    // Relaciones según el esquema de la base de datos
    public function casos()
    {
        return $this->hasMany(\App\Models\Caso::class, 'usuario_id');
    }

    public function seguimientos()
    {
        return $this->hasMany(\App\Models\Seguimiento::class, 'usuario_id');
    }

    public function formularios()
    {
        return $this->hasMany(\App\Models\Formulario::class, 'creado_por');
    }

    public function sesiones()
    {
        return $this->hasMany(\App\Models\Sesion::class, 'usuario_id');
    }

    // =====================================================
    // HELPERS - Métodos auxiliares para el desarrollo
    // =====================================================

    /**
     * Verifica si el usuario tiene el rol de directora.
     * 
     * Ejemplo de uso:
     * if ($user->isDirectora()) {
     *     // Mostrar panel de administración completo
     * }
     *
     * @return bool True si el usuario es directora, false en caso contrario
     */
    public function isDirectora(): bool
    {
        return $this->rol === 'directora';
    }

    /**
     * Verifica si el usuario tiene el rol de administrador.
     * 
     * Ejemplo de uso:
     * if ($user->isAdmin()) {
     *     // Permitir gestionar usuarios
     * }
     *
     * @return bool True si el usuario es admin, false en caso contrario
     */
    public function isAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    /**
     * Verifica si el usuario tiene el rol de psicóloga.
     * 
     * Ejemplo de uso:
     * if ($user->isPsicologa()) {
     *     // Mostrar solo casos psicológicos
     * }
     *
     * @return bool True si el usuario es psicóloga, false en caso contrario
     */
    public function isPsicologa(): bool
    {
        return $this->rol === 'psicologa';
    }

    /**
     * Verifica si el usuario tiene el rol de abogada.
     * 
     * Ejemplo de uso:
     * if ($user->isAbogada()) {
     *     // Mostrar solo casos jurídicos
     * }
     *
     * @return bool True si el usuario es abogada, false en caso contrario
     */
    public function isAbogada(): bool
    {
        return $this->rol === 'abogada';
    }
}
