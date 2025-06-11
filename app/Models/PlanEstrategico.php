<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanEstrategico extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre_plan',
        'mision',
        'vision',
        'valores',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function resumenEjecutivo()
    {
        return $this->hasOne(ResumenEjecutivo::class, 'plan_id');
    }
}
