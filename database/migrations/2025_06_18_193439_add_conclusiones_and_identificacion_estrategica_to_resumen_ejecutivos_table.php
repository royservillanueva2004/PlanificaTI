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
        Schema::table('resumenes_ejecutivos', function (Blueprint $table) {
            $table->text('conclusiones')->nullable()->after('promotores');
            $table->longText('identificacion_estrategica')->nullable()->after('conclusiones');
        });
    }

    public function down(): void
    {
        Schema::table('resumenes_ejecutivos', function (Blueprint $table) {
            $table->dropColumn('conclusiones');
            $table->dropColumn('identificacion_estrategica');
        });
    }
};
