<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed de la aplicación.
     * Ejecuta todos los seeders en el orden correcto.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProyectoSeeder::class,
            CasoSeeder::class,
            FormularioSeeder::class,
        ]);
    }
}