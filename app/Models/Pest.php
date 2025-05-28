<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pest extends Model
{
    // Nombre de la tabla (opcional si sigue la convención plural en inglés)
    protected $table = 'pests';

    // Campos que pueden asignarse masivamente
    protected $fillable = [
        'plan_id',
        // Factores PESTEL
        'politicos',
        'economicos',
        'sociales',
        'tecnologicos',
        'ambientales',
        'legales',
        // Resultados del análisis
        'oportunidades',
        'amenazas',
        'conclusion',
    ];

    // Casts para atributos que deben ser tratados como arrays
    protected $casts = [
        'oportunidades' => 'array',
        'amenazas' => 'array',
    ];

    // Relación con el Plan Estratégico
    public function plan()
    {
        return $this->belongsTo(PlanEstrategico::class, 'plan_id');
    }
}