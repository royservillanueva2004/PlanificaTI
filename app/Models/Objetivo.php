<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model
{
    protected $fillable = [
        'plan_id',
        'tipo',
        'descripcion',
        'parent_id',
    ];

    /**
     * Relación: un objetivo pertenece a un plan estratégico
     */
    public function plan()
    {
        return $this->belongsTo(PlanEstrategico::class);
    }

    /**
     * Relación: un objetivo general puede tener muchos objetivos específicos
     */
    public function especificos()
    {
        return $this->hasMany(Objetivo::class, 'parent_id');
    }

    /**
     * Relación: un objetivo específico pertenece a un objetivo general
     */
    public function general()
    {
        return $this->belongsTo(Objetivo::class, 'parent_id');
    }
}