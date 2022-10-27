<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Generaciones;
use App\Models\Generacion_periodos;
use App\Http\Controllers\GeneracionController;
use Illuminate\Support\Facades\DB;
use URL;

class GeneracionController extends Controller
{
    function indexAction(){
        if (session()->get('user_roles')['Generaciones']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        return view('generaciones.index');
    }
    function newAction(){
        if (session()->get('user_roles')['Generaciones']->Crear != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        
        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE P.Id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }
        $planteles      = DB::select('SELECT * FROM planteles P '.$whereQuery);
        return view('generaciones.new',['planteles' => $planteles]);
    }
    function viewAction(){
        if (session()->get('user_roles')['Generaciones']->Modificar != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        $generacionId = $_GET['generacion']; 
        $generacion          = DB::select('SELECT * FROM generaciones WHERE Id = :Id', ['Id' => $generacionId]);
        $planteles           = DB::select('SELECT * FROM planteles');
        $generacionPeriodos  = DB::select('SELECT * FROM generacion_periodos WHERE Generacion_id = :Id ORDER BY Periodo_numero ASC', ['Id' => $generacionId]);

        return view('generaciones.view',['generacion' => $generacion,'planteles' => $planteles,'generacionPeriodos' => json_encode($generacionPeriodos)]);
    }
     
    
    function getGeneraciones(){
         if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = '  WHERE G.Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }
        $generaciones = DB::select('select G.Id,G.Nombre,G.Estatus,P.Nombre AS Plantel,(SELECT COUNT(AR.Id) FROM  alumnos A LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id  WHERE A.Estatus = 1 AND AR.Generacion_id = G.Id) AS Alumnos from generaciones G  LEFT JOIN planteles P ON P.Id = G.Plantel_id '.$whereQuery.' GROUP BY G.Id');
        
        return ['data'=>$generaciones];
    }
    function createGeneracion($generacion,$generacionPeriodos){
        $result = '';
        try{
                $id = DB::table('generaciones')->insertGetId(
                        [
                            'Nombre'              => $generacion['nombre'],
                            'Fecha_inicio'        => $generacion['fechaInicio'],
                            'Fecha_finalizacion'  => $generacion['fechaFinalizacion'],
                            'Periodo'             => $generacion['periodo'],
                            'Plantel_id'          => $generacion['plantel'],
                            'Estatus'             => 1
                        ]
                );
                foreach($generacionPeriodos as $generacionPeriodo){
                    DB::table('generacion_periodos')->insert(
                            [
                                'Generacion_id'     => $id,
                                'Periodo_numero'    => $generacionPeriodo['periodoNumero'],
                                'Fecha_inicio'      => $generacionPeriodo['fechaInicio'],
                                'Fecha_finalizacion'=> $generacionPeriodo['fechaFinalizacion']
                            ]
                    );
                }

            $result = ['success','¡Generacion creada exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $result = ['warning','La generación ya ha sido previamente agregado!'];
            }else{
                $result = ['error','¡Error al guardar Generacion! '];
            }
        }
        return $result;
    }
    function updateGeneracion($generacion){
        $result = '';
        try{
            $generaciones = Generaciones::where('Id', $generacion['id'])->update(['Nombre' => $generacion['nombre'],'Fecha_inicio' => $generacion['fechaInicio'],'Fecha_finalizacion' => $generacion['fechaFinalizacion'],'Plantel_id' => $generacion['plantel']]);
            $result = ['success','Generacion editada exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error al editar generacion!'];
        }
        return $result;
    }
    function updateGeneracionPeriodos($generacionId,$generacionPeriodos){
        $result = '';
        try{
            foreach($generacionPeriodos as $generacionPeriodo){
                $generaciones = generacion_periodos::where('Generacion_id', $generacionId)->where('Periodo_numero', $generacionPeriodo['periodoNumero'])->update(
                    [
                        'Fecha_inicio'      => $generacionPeriodo['fechaInicio'],
                        'Fecha_finalizacion'=> $generacionPeriodo['fechaFinalizacion']
                    ]
                );
            }
            $result = ['success','¡Generacion editado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error al editar generacion!'];
        }
        return $result;
    }
}
