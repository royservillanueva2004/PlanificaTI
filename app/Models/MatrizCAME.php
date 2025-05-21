<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatrizCAME extends Model
{
    // Nombre de la tabla (opcional si el modelo coincide con el nombre de la tabla en plural)
    protected $table = 'matriz_c_a_m_e_s';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'tipo',
        'accion',
    ];
}
