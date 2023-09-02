<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Niveles;
use Illuminate\Support\Facades\DB;
use URL;

class NivelController extends Controller
{
    function indexAction(){
        if (session()->get('user_roles')['Niveles']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        return view('niveles.index');
    }
    function newAction(){
        if (session()->get('user_roles')['Niveles']->Crear != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }

        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE P.Id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }
        $planteles = DB::select('SELECT * FROM planteles P '.$whereQuery);

        return view('niveles.new',['planteles' => $planteles]);
    }
    function viewAction(){
        if (session()->get('user_roles')['Niveles']->Modificar != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        $nivelId   = $_GET['nivel'];
        $nivel     = DB::select('SELECT * FROM niveles WHERE Id = :Id', ['Id' => $nivelId]);
        $planteles = DB::select('SELECT * FROM planteles');

        return view('niveles.view',['nivel' => $nivel,'planteles' => $planteles]);
    }
    
    
    function getNiveles(){
        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE N.Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }

        $niveles = DB::select('SELECT N.Id,N.Nombre,N.Estatus,P.Nombre AS Plantel,(SELECT COUNT(AR.Id) FROM  alumnos A LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id  WHERE A.Estatus = 1 AND AR.Nivel_id = N.Id) AS Alumnos FROM niveles N LEFT JOIN planteles P ON P.Id = N.Plantel_id 
         '.$whereQuery.' GROUP BY N.Id');
        
        return ['data'=>$niveles];
    }
    function createNivel($nivel){
        $result = '';
        try{
            $niveles         = new niveles;
            $niveles->Nombre = $nivel['nombre'];
            $niveles->Plantel_id = $nivel['plantel'];
            $niveles->save();
            $result = ['success','¡Nivel creado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $result = ['warning','¡El nivel ya ha sido previamente agregado!'];
            }else{
                print_r($e->errorInfo);
                $result = ['error','¡Error al guardar nivel!'];
            }
        }
        return $result;
    }
    function updateNivel($nivel){
        $result = '';
        try{
            $niveles         = niveles::where('Id', $nivel['id'])->update(['Nombre' => $nivel['nombre'],'Plantel_id' => $nivel['plantel']]);
            $result = ['success','¡Nivel editado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error al editar nivel!'];
        }
        return $result;
    }
}