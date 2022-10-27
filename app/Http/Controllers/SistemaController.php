<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sistemas;
use App\Http\Controllers\SistemaController;
use Illuminate\Support\Facades\DB;
use URL;

class SistemaController extends Controller
{
    function indexAction(){
        if (session()->get('user_roles')['Sistemas']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        return view('sistemas.index');
    }
    function newAction(){
        if (session()->get('user_roles')['Sistemas']->Crear != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        return view('sistemas.new');
    }
    function viewAction(){
        if (session()->get('user_roles')['Sistemas']->Modificar != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        $sistemaId = $_GET['sistema'];
        $sistema   = DB::select('SELECT * FROM sistemas WHERE Id = :Id', ['Id' => $sistemaId]);

        return view('sistemas.view',['sistema' => $sistema]);
    }
    
    
    function getSistemas(){
        $sistemas = DB::select('select * from sistemas');
        
        return ['data'=>$sistemas];
    }
    function createSistema($sistema){
        $result = '';
        try{
            $sistemas         = new sistemas;
    		$sistemas->Nombre = $sistema['nombre'];
            $sistemas->save();
            $result = ['success','¡Sistema creado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $result = ['warning','¡El sistema ya ha sido previamente agregado!'];
            }else{
                print_r($e->errorInfo);
                $result = ['error','¡Error al guardar sistema!'];
            }
        }
        return $result;
    }
    function updateSistema($sistema){
        $result = '';
        try{
            $sistemas = sistemas::where('Id', $sistema['id'])->update(['Nombre' => $sistema['nombre']]);
            $result = ['success','¡Sistemas editado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error al editar sistema!'];
        }
        return $result;
    }
}