<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesion_id')->constrained('sesions')->onDelete('cascade');
            $table->foreignId('pregunta_id')->constrained('preguntas')->onDelete('restrict');
            $table->text('respuesta')->nullable();
            $table->timestamps();
            
            // Índice único compuesto
            $table->unique(['sesion_id', 'pregunta_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};