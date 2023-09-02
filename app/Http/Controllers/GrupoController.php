<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupos;
use Illuminate\Support\Facades\DB;
use URL;

class GrupoController extends Controller
{
    function indexAction(){
        if (session()->get('user_roles')['Grupos']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        return view('grupos.index');
    }
    function newAction(){
        if (session()->get('user_roles')['Grupos']->Crear != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }

        $planteles      = DB::select('SELECT * FROM planteles WHERE Id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.') ');
        $licenciaturas  = DB::select('SELECT * FROM licenciaturas WHERE Estatus = 1 ');
        $niveles        = DB::select('SELECT * FROM niveles WHERE Estatus = 1 ');
        $sistemas       = DB::select('SELECT * FROM sistemas');
        return view('grupos.new',['planteles' => $planteles,'licenciaturas' => $licenciaturas,'niveles' => $niveles,'sistemas' => $sistemas]);
    }
    function viewAction(){
        if (session()->get('user_roles')['Grupos']->Modificar != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit(); 
        }
        $grupoId       = $_GET['grupo'];
        $grupo         = DB::select('SELECT * FROM grupos WHERE Id = :Id', ['Id' => $grupoId]);
        $planteles     = DB::select('SELECT * FROM planteles WHERE Id IN('.session()->get('user_roles')['Matrícula']->Plantel_id.') ');
        $niveles       = DB::select('SELECT * FROM niveles');
        $licenciaturas = DB::select('SELECT * FROM licenciaturas');
        $sistemas      = DB::select('SELECT * FROM sistemas');
 
        return view('grupos.view',['grupo' => $grupo,'planteles' => $planteles,'niveles' => $niveles,'licenciaturas' => $licenciaturas,'sistemas' => $sistemas]);
    }
    
    
    function getGrupos(){
        $grupos = DB::select('SELECT G.Id,G.Nombre,P.Nombre AS Plantel,N.Nombre AS Nivel,L.Nombre AS Licenciatura,S.Nombre AS Sistema,(SELECT COUNT(AR.Id) FROM  alumnos A LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id  WHERE A.Estatus = 1 AND AR.Grupo_id = G.Id) AS Alumnos FROM grupos G LEFT JOIN planteles P ON P.Id = G.Plantel_id LEFT JOIN niveles N ON N.Id = G.Nivel_id LEFT JOIN licenciaturas L ON L.Id = G.Licenciatura_id LEFT JOIN sistemas S ON S.Id = G.Sistema_id');
        //SELECT COUNT(AR.Id) FROM  alumnos A 
        return ['data'=>$grupos];
    }
    function createGrupo($grupo){
        $result = '';
        try{
            $grupos                  = new grupos;
    		$grupos->Nombre          = $grupo['nombre'];
            $grupos->Plantel_id      = $grupo['plantel'];
            $grupos->Nivel_id        = $grupo['nivel'];
            $grupos->Sistema_id      = $grupo['sistema'];
            $grupos->Licenciatura_id = @$grupo['licenciatura'];
            $grupos->save();
            $result = ['success','¡Grupo creado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $result = ['warning','¡El grupo ya ha sido previamente agregado!'];
            }else{
                print_r($e->errorInfo);
                $result = ['error','¡Error al guardar grupo!'];
            }
        }
        return $result;
    }
    function updateGrupo($grupo){
        $result = '';
        try{
            $grupos         = grupos::where('Id', $grupo['id'])->update([
                'Nombre'          => $grupo['nombre'],
                'Plantel_id'      => $grupo['plantel'],
                'Nivel_id'        => $grupo['nivel'],
                'Licenciatura_id' => $grupo['licenciatura'],
                'Sistema_id'      => $grupo['sistema'],
                'Estatus'         => $grupo['estatus']
            ]);
            $result = ['success','¡Grupo editado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error al editar grupo!'];
        }
        return $result;
    }
}