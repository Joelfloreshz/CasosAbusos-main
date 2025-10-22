<?php
namespace Database\Seeders;

use App\Models\Proyecto;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProyectoSeeder extends Seeder
{
    /**
     * Seed de proyectos.
     * Crea proyectos activos, finalizados y futuros.
     */
    public function run(): void
    {
        // Proyecto activo
        Proyecto::create([
            'nombre' => 'Apoyo Integral a Mujeres 2025',
            'donante' => 'Fundación Internacional de Derechos Humanos',
            'fecha_inicio' => Carbon::create(2025, 1, 1),
            'fecha_fin' => Carbon::create(2025, 12, 31),
            'activo' => true,
        ]);

        // Proyecto activo con otro donante
        Proyecto::create([
            'nombre' => 'Prevención de Violencia de Género',
            'donante' => 'UNICEF El Salvador',
            'fecha_inicio' => Carbon::create(2025, 3, 1),
            'fecha_fin' => Carbon::create(2026, 2, 28),
            'activo' => true,
        ]);

        // Proyecto sin donante específico
        Proyecto::create([
            'nombre' => 'Atención Psicológica Comunitaria',
            'donante' => null,
            'fecha_inicio' => Carbon::create(2025, 6, 1),
            'fecha_fin' => Carbon::create(2025, 11, 30),
            'activo' => true,
        ]);

        // Proyecto finalizado
        Proyecto::create([
            'nombre' => 'Empoderamiento Femenino 2024',
            'donante' => 'ONU Mujeres',
            'fecha_inicio' => Carbon::create(2024, 1, 1),
            'fecha_fin' => Carbon::create(2024, 12, 31),
            'activo' => false,
        ]);

        // Proyecto futuro
        Proyecto::create([
            'nombre' => 'Educación y Prevención 2026',
            'donante' => 'Cooperación Española',
            'fecha_inicio' => Carbon::create(2026, 1, 1),
            'fecha_fin' => Carbon::create(2026, 12, 31),
            'activo' => true,
        ]);
    }
}