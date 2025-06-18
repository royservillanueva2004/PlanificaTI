<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pest extends Model
{
    protected $table = 'pests'; 

    protected $fillable = [
        'plan_id',
        'respuestas',     
        'social',
        'ambiental',
        'politico',
        'economico',
        'tecnologico',
        'conclusion',
        'reflexion'
    ];

    protected $casts = [
        'respuestas' => 'array', 
    ];
}
