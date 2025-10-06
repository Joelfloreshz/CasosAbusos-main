<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed de usuarios del sistema.
     * Crea usuarios de prueba para cada rol.
     */
    public function run(): void
    {
        // Directora
        User::create([
            'usuario' => 'directora',
            'email' => 'directora@melidas.org',
            'password' => 'password123', // Se hashea automáticamente
            'nombre' => 'María Directora García',
            'rol' => 'directora',
            'activo' => true,
        ]);

        // Admin
        User::create([
            'usuario' => 'admin',
            'email' => 'admin@melidas.org',
            'password' => 'password123',
            'nombre' => 'Ana Administradora López',
            'rol' => 'admin',
            'activo' => true,
        ]);

        // Psicóloga
        User::create([
            'usuario' => 'psicologa',
            'email' => 'psicologa@melidas.org',
            'password' => 'password123',
            'nombre' => 'Laura Psicóloga Martínez',
            'rol' => 'psicologa',
            'activo' => true,
        ]);

        // Abogada
        User::create([
            'usuario' => 'abogada',
            'email' => 'abogada@melidas.org',
            'password' => 'password123',
            'nombre' => 'Patricia Abogada Ramírez',
            'rol' => 'abogada',
            'activo' => true,
        ]);

        // Usuario inactivo (ejemplo)
        User::create([
            'usuario' => 'psicologa_inactiva',
            'email' => 'inactiva@melidas.org',
            'password' => 'password123',
            'nombre' => 'Sofía Psicóloga Inactiva',
            'rol' => 'psicologa',
            'activo' => false,
        ]);
    }
}