<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('casos_psicologicos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_caso')->unique();
            $table->date('fecha_ingreso');
            $table->string('estado')->default('activo');
            $table->string('codigo_beneficiaria')->nullable();
            $table->integer('edad')->nullable();
            $table->string('departamento')->nullable();
            $table->string('municipio')->nullable();
            $table->string('nivel_educativo')->nullable();
            $table->string('tipo_violencia');
            $table->string('institucion_remite')->nullable();
            $table->string('modalidad_atencion')->nullable();
            $table->text('motivo_consulta')->nullable();
            $table->text('observaciones_iniciales')->nullable();
            $table->string('proyecto_codigo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('casos_psicologicos');
    }
};
