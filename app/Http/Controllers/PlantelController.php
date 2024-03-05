<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planteles;
use Illuminate\Support\Facades\DB;
use URL;

class PlantelController extends Controller
{
    function indexAction(){
        if (session()->get('user_roles')['Planteles']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        return view('planteles.index');
    }
    function newAction(){
        if (session()->get('user_roles')['Planteles']->Crear != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        return view('planteles.new');
    }
    function viewAction(){
        if (session()->get('user_roles')['Planteles']->Modificar != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        $plantelId = $_GET['plantel'];
        $plantel   = DB::select('SELECT * FROM planteles WHERE Id = :Id', ['Id' => $plantelId]);

        return view('planteles.view',['plantel' => $plantel]);
    }
    
    
    function getPlanteles(){
        $planteles = DB::select('select * from planteles');
        
        return ['data'=>$planteles];
    }
    function createPlantel($plantel){
        $result = '';
        try{
            $planteles         = new planteles;
    		$planteles->Nombre = $plantel['nombre'];
    		$planteles->Identificador = $plantel['identificador'];
    		$planteles->Region = $plantel['region'];
            $planteles->save();
            $result = ['success','¡Plantel creado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $result = ['warning','¡El plantel ya ha sido previamente agregado!'];
            }else{
                print_r($e->errorInfo);
                $result = ['error','¡Error al guardar plantel!'];
            }
        }
        return $result;
    }
    function updatePlantel($plantel){
        $result = '';
        try{
            $planteles         = planteles::where('Id', $plantel['id'])->update(['Nombre' => $plantel['nombre'],'Identificador' => $plantel['identificador'],'Region' => $plantel['region']]);
            $result = ['success','¡Plantel editado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error al editar plantel!'];
        }
        return $result;
    }
}