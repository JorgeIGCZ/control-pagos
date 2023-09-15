<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno_relaciones extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';  
    
    protected $table = 'alumno_relaciones';

    public function plantel()
    {
        return $this->belongsTo(Planteles::class, 'Plantel_id', 'Id');
    }

    public function nivel()
    {
        return $this->belongsTo(Niveles::class, 'Nivel_id', 'Id');
    }

    public function licenciatura()
    {
        return $this->belongsTo(Licenciaturas::class, 'Licenciatura_id', 'Id');
    }

    public function sistema()
    {
        return $this->belongsTo(Sistemas::class, 'Sistema_id', 'Id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupos::class, 'Grupo_id', 'Id');
    }

    public function generacion()
    {
        return $this->belongsTo(Generaciones::class, 'Generacion_id', 'Id');
    }
}
