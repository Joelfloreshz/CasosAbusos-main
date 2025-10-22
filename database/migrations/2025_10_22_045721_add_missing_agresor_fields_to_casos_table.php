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
        Schema::table('casos', function (Blueprint $table) {
            // Asumimos que 'parentesco_agresor' SÍ existe y añadimos las nuevas después
            $table->string('estado_civil_agresor')->nullable()->after('parentesco_agresor');
            $table->string('ocupacion_agresor')->nullable()->after('estado_civil_agresor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('casos', function (Blueprint $table) {
            $table->dropColumn([
                'estado_civil_agresor',
                'ocupacion_agresor'
            ]);
        });
    }
};