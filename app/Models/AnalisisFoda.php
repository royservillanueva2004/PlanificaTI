<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalisisFoda extends Model
{
    protected $table = 'analisis_fodas';

    protected $fillable = [
        'plan_id',
        'fortalezas',
        'debilidades',
        'oportunidades',
        'amenazas',
    ];

    protected $casts = [
        'fortalezas' => 'array',
        'debilidades' => 'array',
        'oportunidades' => 'array',
        'amenazas' => 'array',
    ];

    public function plan()
    {
        return $this->belongsTo(PlanEstrategico::class, 'plan_id');
    }
}
