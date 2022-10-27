<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Niveles;
use App\Models\Planteles;
use App\Models\Licenciaturas;
use App\Models\Sistemas;
use App\Http\Controllers\GeneralFilterController;
use Illuminate\Support\Facades\DB;

class GeneralFilterController extends Controller
{
    function getDinamicFilterOptions($item,$selection){
        try{
	        $descuentoAlumno = DB::select('SELECT * FROM '.$item.' WHERE ');
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
}
