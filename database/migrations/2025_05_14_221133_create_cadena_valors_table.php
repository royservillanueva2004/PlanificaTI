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
        Schema::create('cadena_valors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plan_estrategicos')->onDelete('cascade');
            $table->json('respuestas')->nullable();
            $table->text('reflexion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadena_valors');
    }
};
