<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plan_estrategicos')->onDelete('cascade');
            
            // Factores PESTEL
            $table->text('politicos')->nullable()->comment('Factores políticos que afectan al negocio');
            $table->text('economicos')->nullable()->comment('Factores económicos del entorno');
            $table->text('sociales')->nullable()->comment('Factores sociales y demográficos');
            $table->text('tecnologicos')->nullable()->comment('Factores tecnológicos relevantes');
            $table->text('ambientales')->nullable()->comment('Factores medioambientales');
            $table->text('legales')->nullable()->comment('Factores legales y regulatorios');
            
            // Resultados del análisis
            $table->json('oportunidades')->nullable()->comment('Oportunidades identificadas');
            $table->json('amenazas')->nullable()->comment('Amenazas identificadas');
            $table->text('conclusion')->nullable()->comment('Conclusión del análisis');
            
            $table->timestamps();
            
            // Índices
            $table->index('plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('pests');
    }
};