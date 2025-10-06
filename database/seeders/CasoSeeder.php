<?php
namespace Database\Seeders;

use App\Models\Caso;
use App\Models\User;
use App\Models\Proyecto;
use App\Models\Seguimiento;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CasoSeeder extends Seeder
{
    /**
     * Seed de casos.
     * Crea casos psicológicos y jurídicos con seguimientos.
     */
    public function run(): void
    {
        $psicologa = User::where('usuario', 'psicologa')->first();
        $abogada = User::where('usuario', 'abogada')->first();
        
        $proyecto1 = Proyecto::where('nombre', 'Apoyo Integral a Mujeres 2025')->first();
        $proyecto2 = Proyecto::where('nombre', 'Prevención de Violencia de Género')->first();

        // Caso psicológico activo 1
        $caso1 = Caso::create([
            'codigo_caso' => 'PSI-2025-001',
            'tipo' => 'psicologico',
            'nombre_afectada' => 'María Elena Pérez',
            'dui' => '01234567-8',
            'edad' => 32,
            'telefono' => '7123-4567',
            'departamento' => 'San Salvador',
            'municipio' => 'San Salvador',
            'zona' => 'urbana',
            'nombre_agresor' => 'Juan Carlos Gómez',
            'parentesco_agresor' => 'Esposo',
            'fecha_ingreso' => Carbon::create(2025, 2, 15),
            'motivo' => 'Violencia psicológica y verbal constante. Amenazas de muerte. Control económico.',
            'estado' => 'activo',
            'usuario_id' => $psicologa->id,
            'proyecto_id' => $proyecto1->id,
        ]);

        // Seguimiento para caso 1
        Seguimiento::create([
            'caso_id' => $caso1->id,
            'fecha' => Carbon::create(2025, 2, 20),
            'descripcion' => 'Primera sesión. La paciente muestra signos de ansiedad y miedo. Se establece plan de intervención.',
            'proxima_cita' => Carbon::create(2025, 2, 27),
            'usuario_id' => $psicologa->id,
        ]);

        Seguimiento::create([
            'caso_id' => $caso1->id,
            'fecha' => Carbon::create(2025, 2, 27),
            'descripcion' => 'Segunda sesión. Paciente más tranquila. Se trabaja en fortalecer autoestima.',
            'proxima_cita' => Carbon::create(2025, 3, 6),
            'usuario_id' => $psicologa->id,
        ]);

        // Caso psicológico activo 2
        $caso2 = Caso::create([
            'codigo_caso' => 'PSI-2025-002',
            'tipo' => 'psicologico',
            'nombre_afectada' => 'Ana Lucía Martínez',
            'dui' => '98765432-1',
            'edad' => 28,
            'telefono' => '7234-5678',
            'departamento' => 'La Libertad',
            'municipio' => 'Santa Tecla',
            'zona' => 'urbana',
            'nombre_agresor' => 'Roberto Silva',
            'parentesco_agresor' => 'Expareja',
            'fecha_ingreso' => Carbon::create(2025, 3, 10),
            'motivo' => 'Acoso constante después de terminar la relación. Amenazas vía mensajes.',
            'estado' => 'activo',
            'usuario_id' => $psicologa->id,
            'proyecto_id' => $proyecto2->id,
        ]);

        // Caso jurídico activo
        $caso3 = Caso::create([
            'codigo_caso' => 'JUR-2025-001',
            'tipo' => 'juridico',
            'nombre_afectada' => 'Carmen Rosa López',
            'dui' => '45678901-2',
            'edad' => 35,
            'telefono' => '7345-6789',
            'departamento' => 'San Miguel',
            'municipio' => 'San Miguel',
            'zona' => 'rural',
            'nombre_agresor' => 'José Antonio Ramos',
            'parentesco_agresor' => 'Conviviente',
            'fecha_ingreso' => Carbon::create(2025, 1, 20),
            'motivo' => 'Violencia física severa. Lesiones documentadas. Denuncia presentada ante FGR.',
            'estado' => 'activo',
            'usuario_id' => $abogada->id,
            'proyecto_id' => $proyecto1->id,
        ]);

        Seguimiento::create([
            'caso_id' => $caso3->id,
            'fecha' => Carbon::create(2025, 1, 25),
            'descripcion' => 'Se acompañó a audiencia preliminar. Medidas de protección otorgadas.',
            'proxima_cita' => Carbon::create(2025, 2, 15),
            'usuario_id' => $abogada->id,
        ]);

        Seguimiento::create([
            'caso_id' => $caso3->id,
            'fecha' => Carbon::create(2025, 2, 15),
            'descripcion' => 'Audiencia de juicio. Agresor fue condenado a 3 años de prisión.',
            'proxima_cita' => null,
            'usuario_id' => $abogada->id,
        ]);

        // Caso jurídico activo 2
        $caso4 = Caso::create([
            'codigo_caso' => 'JUR-2025-002',
            'tipo' => 'juridico',
            'nombre_afectada' => 'Gabriela Hernández',
            'dui' => null, // Sin DUI
            'edad' => 22,
            'telefono' => '7456-7890',
            'departamento' => 'Sonsonate',
            'municipio' => 'Sonsonate',
            'zona' => 'urbana',
            'nombre_agresor' => 'Luis Fernando Castro',
            'parentesco_agresor' => 'Exnovio',
            'fecha_ingreso' => Carbon::create(2025, 3, 5),
            'motivo' => 'Violación sexual. Denuncia presentada. Se solicita acompañamiento legal.',
            'estado' => 'activo',
            'usuario_id' => $abogada->id,
            'proyecto_id' => $proyecto2->id,
        ]);

        // Caso cerrado (ejemplo)
        $caso5 = Caso::create([
            'codigo_caso' => 'PSI-2024-050',
            'tipo' => 'psicologico',
            'nombre_afectada' => 'Patricia Ramírez',
            'dui' => '11223344-5',
            'edad' => 40,
            'telefono' => '7567-8901',
            'departamento' => 'San Salvador',
            'municipio' => 'Mejicanos',
            'zona' => 'urbana',
            'nombre_agresor' => 'Miguel Ángel Torres',
            'parentesco_agresor' => 'Esposo',
            'fecha_ingreso' => Carbon::create(2024, 8, 10),
            'motivo' => 'Violencia psicológica. Proceso de terapia finalizado exitosamente.',
            'estado' => 'cerrado',
            'usuario_id' => $psicologa->id,
            'proyecto_id' => null,
        ]);

        Seguimiento::create([
            'caso_id' => $caso5->id,
            'fecha' => Carbon::create(2024, 12, 15),
            'descripcion' => 'Sesión final. Paciente ha recuperado su autoestima y cuenta con red de apoyo. Caso cerrado exitosamente.',
            'proxima_cita' => null,
            'usuario_id' => $psicologa->id,
        ]);

        // Caso sin datos completos ejemplo realista
        Caso::create([
            'codigo_caso' => 'PSI-2025-003',
            'tipo' => 'psicologico',
            'nombre_afectada' => 'Sandra López',
            'dui' => null,
            'edad' => null,
            'telefono' => null,
            'departamento' => null,
            'municipio' => null,
            'zona' => null,
            'nombre_agresor' => null,
            'parentesco_agresor' => null,
            'fecha_ingreso' => Carbon::now(),
            'motivo' => 'Primera consulta telefónica. Se agendará entrevista presencial.',
            'estado' => 'activo',
            'usuario_id' => $psicologa->id,
            'proyecto_id' => null,
        ]);
    }
}