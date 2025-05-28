<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatrizBCG extends Model
{
    protected $table = 'matriz_bcgs'; // nombre exacto de tu tabla

    protected $fillable = ['plan_id', 'productos', 'ventas', 'tcm', 'demanda_global', 'competidores'];

    protected $casts = [
        'productos' => 'array',
        'ventas' => 'array',
        'tcm' => 'array',
        'demanda_global' => 'array',
        'competidores' => 'array',
    ];
}