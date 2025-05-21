<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CadenaValor extends Model
{
    protected $fillable = ['plan_id', 'respuestas', 'reflexion'];

    protected $casts = [
        'respuestas' => 'array',
    ];

    public function plan()
    {
        return $this->belongsTo(PlanEstrategico::class);
    }
}