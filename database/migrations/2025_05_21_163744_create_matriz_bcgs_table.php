<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('matriz_bcgs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->json('productos'); // ["Producto A", "Producto B", ...]
            $table->json('ventas'); // [1200, 800, ...]
            $table->json('tcm'); // tasas de crecimiento por producto
            $table->json('demanda_global'); // evolución de demanda
            $table->json('competidores'); // competidores y ventas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matriz_bcgs');
    }
};
