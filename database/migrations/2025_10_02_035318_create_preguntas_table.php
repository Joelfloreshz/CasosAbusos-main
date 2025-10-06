<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulario_id')->constrained('formularios')->onDelete('cascade');
            $table->integer('numero');
            $table->text('pregunta');
            $table->enum('tipo_respuesta', ['texto', 'numero', 'si_no', 'multiple']);
            $table->text('opciones')->nullable()->comment('Opciones separadas por comas si aplica');
            $table->boolean('requerida')->default(false);
            $table->timestamps();
            
            // Índice único compuesto
            $table->unique(['formulario_id', 'numero']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};