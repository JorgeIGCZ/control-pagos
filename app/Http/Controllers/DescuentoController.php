<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Descuentos;
use App\Models\Alumnos;
use Illuminate\Support\Facades\DB;

class DescuentoController extends Controller
{
    function createDescuento($alumno,$descuento){
        try{
        	$Id = DB::table('descuentos')->insertGetId(
	            [
	            	'Alumno_id'          => $alumno,
	                'Nombre'             => $descuento['nombre'], 
	                'Concepto_id'        => $descuento['conceptoId'], 
	                'Pronto_pago'        => $descuento['prontoPago'], 
	                'Cantidad_descuento' => $descuento['cantidadDescuento']
	            ]
	        );

	        if($Id > 0){
	        	$result = ['success','¡Descuento liberado exitosamente por 24 Hrs!'];
	        }else{
	            $result = ['error','¡Error al liberar el descuento!'];
	        }
        }catch(\Illuminate\Database\QueryException $e){
            $result = ['error','¡Error al liberar el descuento! '.$e->getMessage()];
        }
        return $result;
    }

    function getDescuento($alumno){
        try{
	        $descuentoAlumno = DB::select('SELECT * FROM descuentos WHERE Pronto_pago = 1 AND Estatus = 1 AND Alumno_id = '.$alumno['id']);
	        if(count($descuentoAlumno)>0){
	        	$result = ['success',$descuentoAlumno];
	        }else{
	            $result = ['error','¡Descuento no encontrado!'];
	        }
        }catch(\Illuminate\Database\QueryException $e){
            $result = ['error','¡Error al liberar el descuento! '.$e->getMessage()];
        }
        return $result;
    }

    function clearDescuentos(){
    	descuentos::where('Estatus', 1)->update(['Estatus' => 0]);
    }
}
