<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conceptos;
use App\Models\Planteles;
use App\Models\Concepto_relaciones;
use Illuminate\Support\Facades\DB;
use URL;

class ConceptoController extends Controller
{
    function indexAction(){
        if (session()->get('user_roles')['Conceptos']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE P.Id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }
        $planteles      = DB::select('SELECT * FROM planteles P '.$whereQuery);
        return view('conceptos.index',[
            'planteles' => $planteles
        ]);
    }
    function newAction(){
        if (session()->get('user_roles')['Conceptos']->Crear != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }

        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE P.Id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }
        $planteles      = DB::select('SELECT * FROM planteles P '.$whereQuery);

        return view('conceptos.new',['planteles' => $planteles]);
    }
    function viewAction(){
        if (session()->get('user_roles')['Conceptos']->Modificar != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        $conceptoId     = $_GET['concepto'];
        $conceptos      = DB::select('SELECT * FROM conceptos WHERE Id = :Id', ['Id' => $conceptoId]);
        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE P.Id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }
        $planteles      = DB::select('SELECT * FROM planteles P '.$whereQuery);

        return view('conceptos.view',['conceptos' => $conceptos,'planteles' => $planteles]);
    }
    
    


    function getConceptos(){
        $whereQuery = '';
        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE C.Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }
        $conceptos = DB::select('select C.Id,C.Nombre,C.Precio,C.Tipo,C.Estatus,P.Nombre AS Plantel,(SELECT COUNT(AR.Id) FROM  alumnos A LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id  WHERE A.Estatus = 1 AND (AR.Concepto_id = C.Id  OR AR.Concepto_titulacion_id = C.Id OR AR.Concepto_inscripcion_id = C.Id)) AS Alumnos  from conceptos C  LEFT JOIN planteles P ON P.Id = C.Plantel_id '.$whereQuery);
        
        return ['data'=>$conceptos];
    }
    function createConcepto($concepto){
        $result = '';
        try{
            $id = DB::table('conceptos')->insertGetId(
                        [
                            'Nombre'     => $concepto['nombre'],
                            'Precio'     => $concepto['precio'],
                            'Tipo'       => $concepto['tipo'],
                            'Plantel_id' => $concepto['plantel']
                        ]
                    );
            
            $result = ['success','¡Concepto creado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $result = ['warning','¡El concepto ya ha sido previamente agregado!'];
            }else{
                print_r($e->errorInfo);
                $result = ['error','¡Error al guardar concepto!'];
            }
        }
        return $result;
    }
    function updateConcepto($concepto){
        $result = '';
        try{
            $conceptos         = conceptos::where('Id', $concepto['id'])->update(['Nombre' => $concepto['nombre'],'Precio' => $concepto['precio'],'tipo' => $concepto['tipo'],'Estatus' => $concepto['estatus'],'Plantel_id' => $concepto['plantel']]);
            $result = ['success','¡Concepto editado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error al editar concepto!'];
        }
        return $result;
    }
}