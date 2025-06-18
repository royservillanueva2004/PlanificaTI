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
            $table->json('respuestas')->nullable();
            $table->unsignedInteger('social')->nullable();
            $table->unsignedInteger('ambiental')->nullable();
            $table->unsignedInteger('politico')->nullable();
            $table->unsignedInteger('economico')->nullable();
            $table->unsignedInteger('tecnologico')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('reflexion')->nullable();    
            $table->timestamps();
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