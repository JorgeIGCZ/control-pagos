<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumnos;
use App\Models\Alumno_relaciones;
// use App\Http\Controllers\TitulacionController;
use Illuminate\Support\Facades\DB;
use URL;

class TitulacionController extends Controller 
{
    function indexAction(){
        if (session()->get('user_roles')['Alumnos']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        $whereQuery = '';
        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }
        
        $plantel        = DB::select('SELECT * FROM planteles WHERE Id = '.@$_GET['Id'].' ');
        $planteles      = DB::select('SELECT * FROM planteles WHERE Id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.') ');
        $licenciaturas  = DB::select('SELECT * FROM licenciaturas');
        $niveles        = DB::select('SELECT * FROM niveles');
        $sistemas       = DB::select('SELECT * FROM sistemas');
        $grupos         = DB::select('SELECT * FROM grupos');
        $conceptos      = DB::select('SELECT * FROM conceptos WHERE Tipo IN ("colegiatura","inscripcion") ');
        $titulacion     = DB::select('SELECT * FROM conceptos WHERE Tipo ="titulacion" ');
        $prontoPago     = DB::select('SELECT * FROM conceptos WHERE Tipo = "pronto-pago" ');
        $generaciones   = DB::select('SELECT * FROM generaciones '.$whereQuery);
        
        return view('titulaciones.index',['plantel' => $plantel[0]->Nombre,'planteles' => $planteles,'licenciaturas' => $licenciaturas,'sistemas' => $sistemas,'grupos' => $grupos,'niveles' => $niveles,'conceptos' => $conceptos,'titulacion' => $titulacion,'prontoPago' => $prontoPago,'generaciones' => $generaciones]);
    }
    function getAlumnosTitulaciones($datos){
        $datos      = json_decode($datos);
        $queryWhere = '';
        if(is_object($datos)){
            foreach($datos as $key => $value){
                if($value <> 0){
                    switch ($key) {
                        case 'plantel':
                            $queryWhere .= ' AND AR.Plantel_id IN ('.$value.') ';
                            break;
                        case 'nivel':
                            $queryWhere .= ' AND AR.Nivel_id = '.$value.' ';
                            break;
                        case 'licenciatura':
                            $queryWhere .= ' AND AR.Licenciatura_id = '.$value.' ';
                            break;
                        case 'sistema':
                            $queryWhere .= ' AND AR.Sistema_id = '.$value.' ';
                            break;
                        case 'grupo':
                            $queryWhere .= ' AND AR.Grupo_id = '.$value.' ';
                            break;
                        case 'generacion':
                            $queryWhere .= ' AND AR.Generacion_id = '.$value.' ';
                            break;
                    }
                }
            }
        }

        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $queryWhere .= ' AND AR.Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.') ';
        }
        // $alumnosQuery = 'SELECT A.Id AS Alumno_id,@total := @total + 1 AS provId,CONCAT(A.Nombre," ",A.Apellido_paterno," ",A.Apellido_materno) AS Nombre,A.Email,A.Telefono,Estatus,Nombre_tutor,Telefono_tutor,'.
        //                 '( SELECT O.Estatus FROM ordenes O LEFT JOIN conceptos C ON C.Id = O.Concepto_id WHERE O.Alumno_id = A.Id AND C.Tipo = "titulacion")  AS Estatus_pago, '.
        //                 '( SELECT IF(SUM(P.Cantidad_pago) IS NULL,0,SUM(P.Cantidad_pago)) FROM pagos P LEFT JOIN conceptos C ON C.Id = P.Concepto_id WHERE P.Alumno_id = A.Id  AND C.Tipo = "titulacion")  AS Cantidad_pago,   '.
        //                 '( SELECT C.Precio FROM conceptos C WHERE C.Id = AR.Concepto_titulacion_id)  AS Costo_titulacion '.
        //                 'FROM alumnos A                                        '.
        //                 'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id '.
        //                 'WHERE 1 = 1 '.$queryWhere;

        $alumnosQuery = 'SELECT                                                                                                                                                                                  '.
                        '    A.Id AS Alumno_id,                                                                                                                                                                  '.
                        '    @total := @total + 1 AS provId,    '.
                        '    CONCAT(A.Nombre, " ", A.Apellido_paterno, " ", A.Apellido_materno) AS Nombre,                                                                                                       '.
                        '    A.Email,                                                                                                                                                                            '.
                        '    A.Telefono,                                                                                                                                                                         '.
                        '    A.Estatus,                                                                                                                                                                          '.
                        '    Nombre_tutor,                                                                                                                                                                       '.
                        '    Telefono_tutor,                                                                                                                                                                     '.
                        '    IFNULL(O.Estatus, 0) AS Estatus_pago,                                                                                                                                               '.
                        '    IFNULL(SUM(P.Cantidad_pago), 0) AS Cantidad_pago,                                                                                                                                   '.
                        '    C.Precio AS Costo_titulacion                                                                                                                                                        '.
                        'FROM                                                                                                                                                                                    '.
                        '    alumnos A                                                                                                                                                                           '.
                        'LEFT JOIN                                                                                                                                                                               '.
                        '    alumno_relaciones AR ON AR.Alumno_id = A.Id                                                                                                                                         '.
                        'LEFT JOIN                                                                                                                                                                               '.
                        '    (SELECT Alumno_id, O.Estatus FROM ordenes O LEFT JOIN conceptos ON conceptos.Id = O.Concepto_id WHERE conceptos.Tipo = "titulacion") O                                            '.
                        '    ON O.Alumno_id = A.Id                                                                                                                                                               '.
                        'LEFT JOIN                                                                                                                                                                               '.
                        '    (SELECT Alumno_id, SUM(Cantidad_pago) AS Cantidad_pago FROM pagos LEFT JOIN conceptos ON conceptos.Id = pagos.Concepto_id WHERE conceptos.Tipo = "titulacion" GROUP BY Alumno_id) P '.
                        '    ON P.Alumno_id = A.Id                                                                                                                                                               '.
                        'LEFT JOIN                                                                                                                                                                               '.
                        '    conceptos C ON C.Id = AR.Concepto_titulacion_id                                                                                                                                     '.
                        'WHERE 1 = 1 '.$queryWhere.'                                                                                                                                                              '.
                        'GROUP BY                                                                                                                                                                                '.
                        '    A.Id,                                                                                                                                                                               '.
                        '    A.Nombre,                                                                                                                                                                           '.
                        '    A.Apellido_paterno,                                                                                                                                                                 '.
                        '    A.Apellido_materno,                                                                                                                                                                 '.
                        '    A.Email,                                                                                                                                                                            '.
                        '    A.Telefono,                                                                                                                                                                         '.
                        '    A.Estatus,                                                                                                                                                                          '.
                        '    Nombre_tutor,                                                                                                                                                                       '.
                        '    Telefono_tutor,                                                                                                                                                                     '.
                        '    Costo_titulacion                                                                                                                                                                    ';
        DB::statement( DB::raw( 'SET @total := 0'));
        $alumnos = DB::select($alumnosQuery);
        
        return ['data'=>$alumnos];
    }
}