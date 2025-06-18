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
        Schema::create('matrices_estrategicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id')->unique();
            $table->json('fo')->nullable(); // Fortalezas - Oportunidades
            $table->json('fa')->nullable(); // Fortalezas - Amenazas
            $table->json('do')->nullable(); // Debilidades - Oportunidades
            $table->json('da')->nullable(); // Debilidades - Amenazas
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('plan_estrategicos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matrices_estrategicas');
    }
};
