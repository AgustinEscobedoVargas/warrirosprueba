<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $fillable = ['nombre', 'apellidos', 'edad', 'email', 'telefono', 'id_grupo'];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo');
    }
}
