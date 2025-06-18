<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatrizEstrategica extends Model
{
    protected $table = 'matrices_estrategicas';
    protected $fillable = ['plan_id', 'fo', 'fa', 'do', 'da'];

    protected $casts = [
        'fo' => 'array',
        'fa' => 'array',
        'do' => 'array',
        'da' => 'array',
    ];

    public function plan()
    {
        return $this->belongsTo(PlanEstrategico::class);
    }
}