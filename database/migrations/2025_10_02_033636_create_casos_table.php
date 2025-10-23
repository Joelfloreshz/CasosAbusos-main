<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('casos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_caso', 30)->unique();
            $table->enum('tipo', ['psicologico', 'juridico'])->nullable(); 

            // Datos de la afectada
            $table->string('nombre_afectada', 150);
            $table->string('dui', 10)->nullable();
            $table->integer('edad')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('departamento', 50)->nullable();
            $table->string('municipio', 50)->nullable();
            $table->enum('zona', ['urbana', 'rural'])->nullable(); 

            // Información básica
            $table->date('fecha_ingreso');
            $table->text('motivo')->nullable();
            $table->enum('estado', ['activo', 'cerrado', 'En Juicio'])->default('activo'); 

            // Datos del agresor 
            $table->string('nombre_agresor', 150)->nullable();
            $table->string('parentesco_agresor', 100)->nullable();
            $table->string('estado_civil_agresor', 100)->nullable(); 
            $table->string('ocupacion_agresor', 255)->nullable(); 

            // Relaciones 
            $table->foreignId('usuario_id')->constrained('users')->onDelete('restrict'); 
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->onDelete('set null'); 

            // Timestamps estándar de Laravel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casos');
    }
};