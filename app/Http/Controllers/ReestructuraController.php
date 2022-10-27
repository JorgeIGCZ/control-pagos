<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumnos;
use App\Models\Ordenes;
use App\Models\Alumno_relaciones;
use App\Http\Controllers\ReestructuraController;
use Illuminate\Support\Facades\DB;
use URL;


class ReestructuraController extends Controller 
{
    function indexAction(){
        if (session()->get('user_roles')['Alumnos']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }

        $conceptos = DB::select('SELECT * FROM conceptos WHERE Tipo ="colegiatura" ');

        return view('reestructura.index',['conceptos' => $conceptos]);
    }

    function getAlumnoConceptos($alumno){
    	$alumnoId = $alumno['id'];
    	$conceptosQuery = ''.
    		'SELECT C.Id,C.Nombre,C.Precio                                  '.
    		'FROM conceptos C                                               '.
    		'LEFT JOIN alumno_relaciones AR ON AR.Plantel_id = C.Plantel_id '.
    		'WHERE Tipo = "colegiatura" AND AR.Alumno_id = '.$alumnoId;
        $conceptos = DB::select($conceptosQuery);

        $conceptosInscripcionQuery = ''.
    		'SELECT C.Id,C.Nombre,C.Precio                                  '.
    		'FROM conceptos C                                               '.
    		'LEFT JOIN alumno_relaciones AR ON AR.Plantel_id = C.Plantel_id '.
    		'WHERE Tipo = "inscripcion" AND AR.Alumno_id = '.$alumnoId;

        $conceptosInscripcion = DB::select($conceptosInscripcionQuery);

        return ['conceptos'=>$conceptos,'conceptosInscripcion'=>$conceptosInscripcion];
    }
    function reestructurarAlumno($alumnoId,$detalles){
    	$now                   = date('Y-m-d');
    	$tipo                  = $detalles['tipo'];
    	$conceptoId            = $detalles['conceptoId'];
		$conceptoInscripcionId = $detalles['conceptoInscripcionId'];
		try{
			Alumno_relaciones::where('Alumno_id', $alumnoId)->update([
	                'Concepto_id' => $conceptoId,
	                'Concepto_inscripcion_id' => $conceptoInscripcionId
	            ]); 

			$concepto = DB::select('SELECT * FROM conceptos WHERE Id = '.$conceptoId)[0];
			$conceptoInscripcion = DB::select('SELECT * FROM conceptos WHERE Id = '.$conceptoInscripcionId)[0];
			
    		if($tipo == 'Futura'){
	            Ordenes::where('Alumno_id', $alumnoId)
			      	->where('Fecha_creacion','>=', $now)
			      	->where('Descripcion','LIKE', '%Colegiatura%')
			      	->update(['Concepto_id' => $conceptoId,'Precio' => $concepto->Precio]);

			    Ordenes::where('Alumno_id', $alumnoId)
			      	->where('Fecha_creacion','>=', $now)
			      	->where('Descripcion','LIKE', '%Inscripcion%')
			      	->update(['Concepto_id' => $conceptoInscripcionId,'Precio' => $conceptoInscripcion->Precio]);

			}else{
				Ordenes::where('Alumno_id', $alumnoId)
			      	->where('Descripcion','LIKE', '%Colegiatura%')
			      	->update(['Concepto_id' => $conceptoId,'Precio' => $concepto->Precio]);

			    Ordenes::where('Alumno_id', $alumnoId)
			      	->where('Descripcion','LIKE', '%Inscripcion%')
			      	->update(['Concepto_id' => $conceptoInscripcionId,'Precio' => $conceptoInscripcion->Precio]);
			}

			$result = ['success','¡Alumno reestructurado exitosamente!'];
	    }catch(\Illuminate\Database\QueryException $e){
	        print_r($e->errorInfo);
	        $errorCode = $e->errorInfo[1];
	        $result = ['error','¡Error al reestructurar alumno! '.$errorCode];
	    }
	    return $result;
    }

}