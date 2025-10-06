<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formularios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->enum('tipo', ['ingreso', 'seguimiento', 'evaluacion']);
            $table->enum('area', ['psicologica', 'juridica', 'ambas']);
            $table->boolean('activo')->default(true);
            $table->foreignId('creado_por')->constrained('users')->onDelete('restrict');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formularios');
    }
};