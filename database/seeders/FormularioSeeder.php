<?php
namespace Database\Seeders;

use App\Models\Formulario;
use App\Models\Pregunta;
use App\Models\User;
use Illuminate\Database\Seeder;

class FormularioSeeder extends Seeder
{
    /**
     * Seed de formularios dinámicos.
     * Crea formularios con sus preguntas para área psicológica y jurídica.
     */
    public function run(): void
    {
        $admin = User::where('usuario', 'admin')->first();
        $directora = User::where('usuario', 'directora')->first();

        // ============================================
        // FORMULARIO 1: Ficha de Ingreso Psicológica
        // ============================================
        $formulario1 = Formulario::create([
            'nombre' => 'Ficha de Ingreso Psicológica',
            'tipo' => 'ingreso',
            'area' => 'psicologica',
            'activo' => true,
            'creado_por' => $admin->id,
        ]);

        // Preguntas del formulario 1
        Pregunta::create([
            'formulario_id' => $formulario1->id,
            'numero' => 1,
            'pregunta' => '¿Cómo se enteró de nuestros servicios?',
            'tipo_respuesta' => 'multiple',
            'opciones' => 'Redes sociales,Referencia de amiga/familiar,Institución gubernamental,Otro',
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario1->id,
            'numero' => 2,
            'pregunta' => '¿Ha recibido atención psicológica anteriormente?',
            'tipo_respuesta' => 'si_no',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario1->id,
            'numero' => 3,
            'pregunta' => 'Si respondió sí, ¿dónde recibió la atención?',
            'tipo_respuesta' => 'texto',
            'opciones' => null,
            'requerida' => false,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario1->id,
            'numero' => 4,
            'pregunta' => '¿Desde hace cuánto tiempo experimenta esta situación? (en meses)',
            'tipo_respuesta' => 'numero',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario1->id,
            'numero' => 5,
            'pregunta' => 'Describa brevemente la situación que la motiva a buscar apoyo',
            'tipo_respuesta' => 'texto',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario1->id,
            'numero' => 6,
            'pregunta' => '¿Ha presentado síntomas de ansiedad o depresión?',
            'tipo_respuesta' => 'si_no',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario1->id,
            'numero' => 7,
            'pregunta' => '¿Cuenta con red de apoyo familiar o social?',
            'tipo_respuesta' => 'si_no',
            'opciones' => null,
            'requerida' => true,
        ]);

        // ============================================
        // FORMULARIO 2: Ficha de Ingreso Jurídica
        // ============================================
        $formulario2 = Formulario::create([
            'nombre' => 'Ficha de Ingreso Jurídica',
            'tipo' => 'ingreso',
            'area' => 'juridica',
            'activo' => true,
            'creado_por' => $admin->id,
        ]);

        // Preguntas del formulario 2
        Pregunta::create([
            'formulario_id' => $formulario2->id,
            'numero' => 1,
            'pregunta' => '¿Ha presentado denuncia ante alguna autoridad?',
            'tipo_respuesta' => 'si_no',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario2->id,
            'numero' => 2,
            'pregunta' => 'Si respondió sí, ¿ante qué institución?',
            'tipo_respuesta' => 'multiple',
            'opciones' => 'Fiscalía General de la República (FGR),Policía Nacional Civil (PNC),Procuraduría General de la República (PGR),Juzgado de Familia,Otro',
            'requerida' => false,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario2->id,
            'numero' => 3,
            'pregunta' => 'Número de referencia de la denuncia (si aplica)',
            'tipo_respuesta' => 'texto',
            'opciones' => null,
            'requerida' => false,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario2->id,
            'numero' => 4,
            'pregunta' => 'Tipo de violencia experimentada',
            'tipo_respuesta' => 'multiple',
            'opciones' => 'Física,Psicológica,Sexual,Económica,Patrimonial',
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario2->id,
            'numero' => 5,
            'pregunta' => '¿Ha recibido atención médica por lesiones?',
            'tipo_respuesta' => 'si_no',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario2->id,
            'numero' => 6,
            'pregunta' => '¿Cuenta con certificado médico legal?',
            'tipo_respuesta' => 'si_no',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario2->id,
            'numero' => 7,
            'pregunta' => 'Describa los hechos que motivan la denuncia',
            'tipo_respuesta' => 'texto',
            'opciones' => null,
            'requerida' => true,
        ]);

        // ============================================
        // FORMULARIO 3: Seguimiento Psicológico
        // ============================================
        $formulario3 = Formulario::create([
            'nombre' => 'Seguimiento Psicológico Mensual',
            'tipo' => 'seguimiento',
            'area' => 'psicologica',
            'activo' => true,
            'creado_por' => $directora->id,
        ]);

        // Preguntas del formulario 3
        Pregunta::create([
            'formulario_id' => $formulario3->id,
            'numero' => 1,
            'pregunta' => '¿Cómo calificaría su estado emocional actual? (1-10)',
            'tipo_respuesta' => 'numero',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario3->id,
            'numero' => 2,
            'pregunta' => '¿Ha experimentado mejoras desde la última sesión?',
            'tipo_respuesta' => 'si_no',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario3->id,
            'numero' => 3,
            'pregunta' => 'Describa las mejoras o cambios observados',
            'tipo_respuesta' => 'texto',
            'opciones' => null,
            'requerida' => false,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario3->id,
            'numero' => 4,
            'pregunta' => '¿Ha tenido contacto con el agresor?',
            'tipo_respuesta' => 'si_no',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario3->id,
            'numero' => 5,
            'pregunta' => '¿Se siente segura en su entorno actual?',
            'tipo_respuesta' => 'si_no',
            'opciones' => null,
            'requerida' => true,
        ]);

        // ============================================
        // FORMULARIO 4: Evaluación Final Psicológica
        // ============================================
        $formulario4 = Formulario::create([
            'nombre' => 'Evaluación de Cierre Psicológica',
            'tipo' => 'evaluacion',
            'area' => 'psicologica',
            'activo' => true,
            'creado_por' => $directora->id,
        ]);

        // Preguntas del formulario 4
        Pregunta::create([
            'formulario_id' => $formulario4->id,
            'numero' => 1,
            'pregunta' => '¿Se alcanzaron los objetivos terapéuticos?',
            'tipo_respuesta' => 'si_no',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario4->id,
            'numero' => 2,
            'pregunta' => 'Número total de sesiones realizadas',
            'tipo_respuesta' => 'numero',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario4->id,
            'numero' => 3,
            'pregunta' => '¿La usuaria cuenta ahora con herramientas de afrontamiento?',
            'tipo_respuesta' => 'si_no',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario4->id,
            'numero' => 4,
            'pregunta' => 'Observaciones finales y recomendaciones',
            'tipo_respuesta' => 'texto',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario4->id,
            'numero' => 5,
            'pregunta' => 'Motivo de cierre del caso',
            'tipo_respuesta' => 'multiple',
            'opciones' => 'Objetivos alcanzados,Abandono voluntario,Referencia a otra institución,Cambio de residencia,Otro',
            'requerida' => true,
        ]);

        // ============================================
        // FORMULARIO 5: Formulario Universal (Ambas áreas)
        // ============================================
        $formulario5 = Formulario::create([
            'nombre' => 'Evaluación de Satisfacción del Servicio',
            'tipo' => 'evaluacion',
            'area' => 'ambas',
            'activo' => true,
            'creado_por' => $admin->id,
        ]);

        // Preguntas del formulario 5
        Pregunta::create([
            'formulario_id' => $formulario5->id,
            'numero' => 1,
            'pregunta' => '¿Cómo calificaría la atención recibida? (1-10)',
            'tipo_respuesta' => 'numero',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario5->id,
            'numero' => 2,
            'pregunta' => '¿El personal fue respetuoso y empático?',
            'tipo_respuesta' => 'si_no',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario5->id,
            'numero' => 3,
            'pregunta' => '¿Recomendaría nuestros servicios a otras personas?',
            'tipo_respuesta' => 'si_no',
            'opciones' => null,
            'requerida' => true,
        ]);

        Pregunta::create([
            'formulario_id' => $formulario5->id,
            'numero' => 4,
            'pregunta' => 'Comentarios o sugerencias adicionales',
            'tipo_respuesta' => 'texto',
            'opciones' => null,
            'requerida' => false,
        ]);
    }
}