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
        Schema::create('resumenes_ejecutivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id')->unique(); // Relación 1:1 con planes_estrategicos
            $table->string('promotores')->nullable();        // Campo editable
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('plan_estrategicos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumenes_ejecutivos');
    }
};
