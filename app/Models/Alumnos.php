<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumnos extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';  
    
    protected $table = 'alumnos';

    public function alumnoRelaciones()
    {
        return $this->belongsTo(Alumno_relaciones::class,'Id','Alumno_id');
    }
}
