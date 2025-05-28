<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fuerza_porters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');

            // 1. Rivalidad
            $table->tinyInteger('crecimiento');
            $table->tinyInteger('naturaleza_competidores');
            $table->tinyInteger('exceso_capacidad_productiva');
            $table->tinyInteger('rentabilidad_media_sector');
            $table->tinyInteger('diferenciacion_producto');
            $table->tinyInteger('barreras_salida');

            // 2. Barreras de entrada
            $table->tinyInteger('economias_escala');
            $table->tinyInteger('necesidad_capital');
            $table->tinyInteger('acceso_tecnologia');
            $table->tinyInteger('reglamentos_leyes');
            $table->tinyInteger('tramites_burocraticos');

            // 3. Clientes
            $table->tinyInteger('numero_clientes');
            $table->tinyInteger('integracion_ascendente');
            $table->tinyInteger('rentabilidad_clientes');
            $table->tinyInteger('coste_cambio');

            // 4. Sustitutos
            $table->tinyInteger('disponibilidad_sustitutivos');

            // 5. Reflexión automática
            $table->text('conclusion')->nullable();

            // Timestamps y relaciones
            $table->timestamps();
            $table->foreign('plan_id')->references('id')->on('plan_estrategicos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuerza_porters');
    }
};
