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
        Schema::create('objetivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plan_estrategicos'); // Relación con plan_estrategicos
            $table->string('tipo')->default('general'); // Para determinar si es general o específico
            $table->unsignedBigInteger('parent_id')->nullable(); // Relación con el objetivo general
            $table->text('descripcion'); // Descripción del objetivo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('objetivos');
    }
};
