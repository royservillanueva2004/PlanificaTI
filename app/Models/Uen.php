<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uen extends Model
{
    protected $fillable = ['plan_id', 'descripcion'];

    public function plan()
    {
        return $this->belongsTo(PlanEstrategico::class, 'plan_id');
    }
}