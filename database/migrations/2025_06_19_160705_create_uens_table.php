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
        Schema::create('uens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->text('descripcion');
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('planes_estrategicos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uens');
    }
};
