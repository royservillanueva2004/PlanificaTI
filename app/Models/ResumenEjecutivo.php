<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumenEjecutivo extends Model
{
    use HasFactory;

    protected $table = 'resumenes_ejecutivos'; // <-- AÑADE ESTO
    protected $fillable = ['plan_id', 'promotores'];

    public function plan()
    {
        return $this->belongsTo(PlanEstrategico::class, 'plan_id');
    }
}
