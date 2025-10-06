<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('casos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_caso', 30)->unique();
            $table->enum('tipo', ['psicologico', 'juridico']);
            
            // Datos de la afectada
            $table->string('nombre_afectada', 150);
            $table->string('dui', 10)->nullable();
            $table->integer('edad')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('departamento', 50)->nullable();
            $table->string('municipio', 50)->nullable();
            $table->enum('zona', ['urbana', 'rural'])->nullable();
            
            // Datos del agresor
            $table->string('nombre_agresor', 150)->nullable();
            $table->string('parentesco_agresor', 100)->nullable();
            
            // Información básica
            $table->date('fecha_ingreso');
            $table->text('motivo')->nullable();
            $table->enum('estado', ['activo', 'cerrado'])->default('activo');
            
            // Relaciones
            $table->foreignId('usuario_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->onDelete('set null');
            
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('casos');
    }
};