<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Becas;
use App\Models\Beca_alumnos;
use Illuminate\Support\Facades\DB;
use URL;

class BecaController extends Controller
{
    function indexAction(){
        if (session()->get('user_roles')['Becas']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        return view('becas.index');
    }
    function newAction(){
        if (session()->get('user_roles')['Becas']->Crear != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        return view('becas.new');
    }
    function viewAction(){
        if (session()->get('user_roles')['Becas']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        $becaId         = $_GET['beca'];
        $becas          = DB::select('SELECT * FROM becas WHERE Id = :Id', ['Id' => $becaId]);
        
        $planteles      = DB::select('SELECT * FROM planteles');
        $licenciaturas  = DB::select('SELECT * FROM licenciaturas');
        $niveles        = DB::select('SELECT * FROM niveles');
        $sistemas       = DB::select('SELECT * FROM sistemas');
        $grupos         = DB::select('SELECT * FROM grupos');
        $generaciones         = DB::select('SELECT * FROM generaciones');

        return view('becas.view',['becas' => $becas,'planteles' => $planteles,'licenciaturas' => $licenciaturas,'sistemas' => $sistemas,'grupos' => $grupos,'niveles' => $niveles,'generaciones' => $generaciones]);
    }

    function getAlumnoAllBe($alumno,$becaAlumnoId){
        $alumnoId     = $alumno['id'];
        $becaAlumnoId = $becaAlumnoId['id'];
        $alumno   = DB::select('SELECT * FROM alumnos WHERE Id ='.$alumnoId);
        $concepto = DB::select('select * FROM alumno_relaciones AR LEFT JOIN conceptos C ON C.Id = AR.Concepto_id WHERE AR.Alumno_id = '.$alumnoId);
        $periodos = DB::select('select CP.Periodo_numero,CP.Generacion_id,CP.Id,CONCAT(CP.Fecha_inicio," - ",CP.Fecha_finalizacion) AS fecha FROM alumno_relaciones AR LEFT JOIN generacion_periodos CP ON CP.Generacion_id = AR.Generacion_id WHERE AR.Alumno_id = '.$alumnoId);
        
        $becaAlumnos = DB::select('SELECT * FROM beca_alumnos BA WHERE BA.Id = '.$becaAlumnoId);
        
        return ['alumno'=>$alumno,'concepto'=>$concepto,'periodos'=>$periodos,'becaAlumno'=>$becaAlumnos];
    }
    function suspBecaAlumno($becaAlumno){
        $becaAlumnoId = $becaAlumno['id'];
        $estatus      = ($becaAlumno['estatus'] == 0 ? 1 : 0);
        $result = '';
        try{
            $becas = beca_alumnos::where('Id', $becaAlumnoId)->update(['Estatus' => $estatus]);
            $result = ['success','¡Beca suspendida exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            $result = ['error','¡Error al suspender beca!'];
        }
        return $result;
    }
    function deleteBecaAlumno($becaAlumnoId){
        $becaAlumnoId = $becaAlumnoId['id'];
        $result = '';
        try{
            $becas = beca_alumnos::where('Id', $becaAlumnoId)->delete();
            $result = ['success','¡Beca eliminada exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            $result = ['error','¡Error al eliminar beca!'];
        }
        return $result;
    }
    function getBecas(){
        $becas = DB::select('select * from becas');
        return ['data'=>$becas];
    }
    function createBeca($beca){
        $result = '';
        try{
            $id = DB::table('becas')->insertGetId(
                [
                    'Nombre'              => $beca['nombre'],
                    'Estatus'             => 1
                ]
            );
            $result = ['success','¡Beca creada exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $result = ['warning','¡La beca ya ha sido previamente agregado!'];
            }else{
                $result = ['error','¡Error al guardar beca! '];
            }
        }
        return $result;
    }
    function updateBeca($beca){
        $result = '';
        try{
            $becas = becas::where('Id', $beca['id'])->update(['Nombre' => $beca['nombre'],'Estatus' => $beca['estatus']]);
            




            $result = ['success','¡Beca editada exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            $result = ['error','¡Error al editar beca!'];
        }
        return $result;
    }
    function newBecaAlumno($datos){
        $result = '';
        try{
            $id = DB::table('beca_alumnos')->insertGetId(
                [
                    'Beca_id'        => $datos['becaId'],
                    'Alumno_id'      => $datos['alumnoId'],
                    'Generacion_id'       => $datos['generacionId'],
                    'Periodo_id'     => $datos['periodoId'],
                    'Cantidad_beca'  => $datos['cantidadBeca'],
                    'Notas'          => $datos['notas'],
                    'Estatus'        => 1
                ]
            );
            $result = ['success','¡Beca asignada exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $errorCode = $e->errorInfo[1];
            $result = ['error','¡Error al guardar beca! '];
        }
        return $result;
    }
    function getBecaAlumnos($becaId,$datos){
        $result = '';

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
                        case 'mes':
                            $queryWhere .= ' AND MONTH(P.created_at) = MONTH("'.$value.'-00 00:00:00") AND YEAR(P.created_at) = YEAR("'.$value.'-00 00:00:00") ';
                            break;
                    }
                }
            }
        }
        

        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $queryWhere .= ' AND AR.Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.') ';
        }


        $alumnosQuery = ''.
                        'SELECT BA.Estatus,BA.Id AS BecaAlumnoId, A.Id,CONCAT(A.Nombre," ",A.Apellido_paterno," ",A.Apellido_materno) AS Nombre,A.Email,BA.Cantidad_beca,CONCAT(CP.Fecha_inicio," - ",CP.Fecha_finalizacion) AS Periodo '.
                        'FROM beca_alumnos BA                                             '.
                        'LEFT JOIN alumnos  A ON A.Id = BA.Alumno_id                      '.
                        'LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id            '.
                        'LEFT JOIN generacion_periodos CP ON CP.Id = BA.Periodo_id             '.
                        'WHERE BA.Beca_id = '.$becaId.' AND CP.Fecha_finalizacion > NOW() '.$queryWhere;
        
        $alumnos = DB::select($alumnosQuery);
        return ['data'=>$alumnos];
    }

    function updateBecaAlumno($becaAlumno){
        $becaAlumnoId = $becaAlumno['id'];
        $result = '';
        try{
            $becas = beca_alumnos::where('Id', $becaAlumno['id'])->update(
                [
                    'Generacion_id'       => $becaAlumno['generacionId'],
                    'Periodo_id'     => $becaAlumno['periodoId'],
                    'Cantidad_beca'  => $becaAlumno['cantidadBeca'],
                    'Notas'          => $becaAlumno['notas']
                ]
            );
            $result = ['success','¡Beca asignada exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $errorCode = $e->errorInfo[1];
            $result = ['error','¡Error al guardar beca! '];
        }
        return $result;
    }
}
