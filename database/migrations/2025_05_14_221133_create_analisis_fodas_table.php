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
        Schema::create('analisis_fodas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id')->unique(); // relación 1 a 1 con cada plan estratégico
            $table->json('fortalezas')->nullable();
            $table->json('debilidades')->nullable();
            $table->json('oportunidades')->nullable();
            $table->json('amenazas')->nullable();
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('plan_estrategicos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisis_fodas');
    }
};
