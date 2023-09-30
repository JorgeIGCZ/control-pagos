<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumnos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use URL;

class DashboardController extends Controller
{
    function indexAction(){
        if(!is_array(@session()->get('user_roles'))){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }

        $fechaInicio = Carbon::parse('first day of this month')->startOfDay();
        $fechaFinal  = Carbon::parse('last day of this month')->endOfDay();

        $queryWhere = '';
        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $queryWhere .= ' AND AR.Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.') ';
        }

        $recaudacionBancariaQuery = ''.
                                          'SELECT SUM(P.Cantidad_pago) AS result      '.
                                          'FROM pagos                   P                                 '.
                                          'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = P.Alumno_id   '.
                                          'LEFT JOIN conceptos          C ON C.Id         = P.Descripcion '.
                                          'WHERE P.Tipo_pago = "Cuenta bancaria" AND C.Tipo IN ("colegiatura","pagos") AND P.created_at BETWEEN "'.$fechaInicio.'" AND "'.$fechaFinal.'" '.$queryWhere;

        $recaudacionEfectivoQuery = ''.
                                          'SELECT SUM(P.Cantidad_pago) AS result    '.
                                          'FROM pagos                   P                                 '.
                                          'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = P.Alumno_id   '.
                                          'LEFT JOIN conceptos          C ON C.Id         = P.Descripcion '.
                                          'WHERE P.Tipo_pago = "Efectivo" AND C.Tipo IN ("colegiatura","pagos") AND P.created_at BETWEEN "'.$fechaInicio.'" AND "'.$fechaFinal.'" '.$queryWhere;



        $alumnos                     = DB::select('SELECT COUNT(A.Id) AS Alumnos FROM alumnos A LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id WHERE 1=1 AND A.Estatus IN (0,1) '.$queryWhere);
        $alumnosActivos              = DB::select('SELECT COUNT(A.Id) AS Alumnos FROM alumnos A LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id  WHERE A.Estatus = 1 '.$queryWhere);
        $alumnosInactivos            = DB::select('SELECT COUNT(A.Id) AS Alumnos FROM alumnos A LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id  WHERE A.Estatus = 0 '.$queryWhere);
        $recaudaconMensualBancaria   = DB::select($recaudacionBancariaQuery);
        $recaudaconMensualEfectivo = DB::select($recaudacionEfectivoQuery);

        $recaudaconMensualBancaria   = (count($recaudaconMensualBancaria)   > 0 ? $recaudaconMensualBancaria[0]->result   : 0 );
        $recaudaconMensualEfectivo = (count($recaudaconMensualEfectivo) > 0 ? $recaudaconMensualEfectivo[0]->result : 0 );
        $recaudaconMensualTotal      = ($recaudaconMensualBancaria + $recaudaconMensualEfectivo);
        
        return view('dashboard.index',[
            'alumnos'                      => $alumnos,
            'alumnosActivos'               => $alumnosActivos,
            'alumnosInactivos'             => $alumnosInactivos,
            'recaudacionMensualTotal'      => $recaudaconMensualTotal,
            'recaudacionMensualBancaria'   => $recaudaconMensualBancaria,
            'recaudacionMensualEfectivo'   => $recaudaconMensualEfectivo
        ]);
    }
}
