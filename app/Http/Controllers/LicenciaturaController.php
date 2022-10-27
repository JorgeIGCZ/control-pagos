<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licenciaturas;
use App\Http\Controllers\LicenciaturaController;
use Illuminate\Support\Facades\DB;
use URL;

class LicenciaturaController extends Controller
{
    function indexAction(){
        if (session()->get('user_roles')['Licenciaturas']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        return view('licenciaturas.index');
    }
    function newAction(){
        if (session()->get('user_roles')['Licenciaturas']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE P.Id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }
        $planteles = DB::select('SELECT * FROM planteles P '.$whereQuery);
        $niveles   = DB::select('SELECT * FROM niveles');

        return view('licenciaturas.new',['planteles' => $planteles,'niveles' => $niveles]);
    }
    function viewAction(){
        if (session()->get('user_roles')['Licenciaturas']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        $licenciaturasId = $_GET['licenciatura'];
        $licenciatura   = DB::select('SELECT * FROM licenciaturas WHERE Id = :Id', ['Id' => $licenciaturasId]);
        $planteles           = DB::select('SELECT * FROM planteles');
        $niveles           = DB::select('SELECT * FROM niveles');

        return view('licenciaturas.view',['licenciatura' => $licenciatura,'planteles' => $planteles,'niveles' => $niveles]);
    }
    
    
    function getLicenciaturas(){ 
        if(session()->get('user_roles')['Matrícula']->Plantel_id > 0){
            $whereQuery = ' WHERE L.Plantel_id IN ('.session()->get('user_roles')['Matrícula']->Plantel_id.',0)';
        }



        $licenciaturas = DB::select('select L.Id,L.Nombre,L.Estatus,P.Nombre AS Plantel,N.Nombre AS Nivel,(SELECT COUNT(AR.Id) FROM  alumnos A LEFT JOIN alumno_relaciones AR ON AR.Alumno_id = A.Id  WHERE A.Estatus = 1 AND AR.Licenciatura_id = L.Id) AS Alumnos FROM licenciaturas L LEFT JOIN planteles P ON P.Id = L.Plantel_id LEFT JOIN niveles N ON N.Id = L.Nivel_id '.$whereQuery.' GROUP BY L.Id');
        
        return ['data'=>$licenciaturas];
    }
    function createLicenciatura($licenciatura){
        $result = '';
        try{
            $licenciaturas             = new licenciaturas;
            $licenciaturas->Nombre     = $licenciatura['nombre'];
            $licenciaturas->Plantel_id = $licenciatura['plantelId'];
            $licenciaturas->Nivel_id   = $licenciatura['nivelId'];
            $licenciaturas->save();
            $result = ['success','¡Licenciatura creado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $result = ['warning','¡La licenciatura ya ha sido previamente agregads!'];
            }else{
                print_r($e->errorInfo);
                $result = ['error','¡Error al guardar licenciatura!'];
            }
        }
        return $result;
    }
    function updateLicenciatura($licenciatura){
        $result = '';
        try{
            $licenciaturas         = licenciaturas::where('Id', $licenciatura['id'])->update(['Nombre' => $licenciatura['nombre'],'Plantel_id' => $licenciatura['plantelId'],'Nivel_id' => $licenciatura['nivelId']]);
            $result = ['success','¡Licenciatura editada exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error al editar licenciatura!'];
        }
        return $result;
    }
}