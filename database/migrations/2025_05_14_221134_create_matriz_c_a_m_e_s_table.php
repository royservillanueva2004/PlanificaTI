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
        Schema::create('matriz_c_a_m_e_s', function (Blueprint $table) {
            $table->id();

            // Tipo de acción: C, A, M, E
            $table->enum('tipo', ['C', 'A', 'M', 'E'])->comment('C: Corregir debilidades, A: Afrontar amenazas, M: Mantener fortalezas, E: Explotar oportunidades');

            // Descripción de la acción
            $table->text('accion');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriz_c_a_m_e_s');
    }
};
