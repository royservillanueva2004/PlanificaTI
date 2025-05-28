<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuerzaPorter extends Model
{
    protected $table = 'fuerza_porters';

    protected $fillable = [
        'plan_id',
        // Rivalidad
        'crecimiento',
        'naturaleza_competidores',
        'exceso_capacidad_productiva',
        'rentabilidad_media_sector',
        'diferenciacion_producto',
        'barreras_salida',

        // Barreras de entrada
        'economias_escala',
        'necesidad_capital',
        'acceso_tecnologia',
        'reglamentos_leyes',
        'tramites_burocraticos',

        // Clientes
        'numero_clientes',
        'integracion_ascendente',
        'rentabilidad_clientes',
        'coste_cambio',

        // Sustitutos
        'disponibilidad_sustitutivos',

        // Evaluación final
        'conclusion',
        'oportunidades',
        'amenazas',
    ];
}
