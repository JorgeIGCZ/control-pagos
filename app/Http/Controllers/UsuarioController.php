<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UsuarioController;
use App\Models\Users;
use App\Models\User_relaciones;
use App\Models\User_planteles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use URL;

class UsuarioController extends Controller
{
    function indexAction(){
        if (session()->get('user_roles')['Configuración']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        $roles              = DB::select('SELECT * FROM roles');
        $planteles          = DB::select('SELECT * FROM planteles');
        return view('usuarios.index',[
            'roles'              => $roles,
            'planteles'          => $planteles
        ]);
    }
    function viewAction(){
        if (session()->get('user_roles')['Configuración']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        $usuarioId          = $_GET['usuario'];
        $usuario            = DB::select('SELECT * FROM users WHERE id = '.$usuarioId);
        $usuario_relaciones = DB::select('SELECT * FROM user_relaciones WHERE User_id = '.$usuarioId);
        $roles              = DB::select('SELECT * FROM roles');
        $planteles          = DB::select('SELECT * FROM planteles');
        return view('usuarios.view',[
            'usuario'            => $usuario,
            'usuario_relaciones' => $usuario_relaciones,
            'roles'              => $roles,
            'planteles'          => $planteles
        ]);
    }
    function getUsuarios(){
        $usersQuery = ''.
                      'select U.id,U.name,U.email,R.Nombre AS role,U.status AS estatus,U.last_login AS ultimo_ingreso, '.
                      '(                                                    '.
                      '  SELECT group_concat(P.Nombre separator ", ")       '.
                      '  FROM user_planteles UP                             '.
                      '  LEFT JOIN planteles P ON P.Id = UP.Plantel_id      '.
                      '  WHERE UP.User_id = U.id                            '.
                      ') AS plantel                                         '.
                      'FROM      users            U                         '.
                      'LEFT JOIN user_relaciones UR ON UR.User_id = U.id    '.
                      'LEFT JOIN roles            R ON R.Id = UR.Role_id    ';
        $users      = DB::select($usersQuery);
        return ['data'=>$users];
    }
    function createUsuario($datos){
        $result = '';
        try{
            $usuarioId = DB::table('users')->insertGetId(
                [
                    'name'      => $datos['nombre'],
                    'email'     => $datos['email'],
                    'password'  => Hash::make($datos['password'])
                ]
            );
            if($usuarioId > 0){
                DB::table('user_relaciones')->insertGetId(
                    [
                        'User_id'     => $usuarioId,
                        'Role_id'     => $datos['rol'],
                        'Plantel_id'  => 0
                    ]
                );
                $deletedRows = User_planteles::where('User_Id', $usuarioId)->delete();
                foreach ($datos['plantel'] as $plantel) {
                    $id = DB::table('user_planteles')->insertGetId(
                        [
                            'User_id'    => $usuarioId,
                            'Plantel_id' => $plantel
                        ]
                    );
                }
            }



            if($usuarioId > 0){
                $result = ['success','Usuario creado exitosamente!'];
            }else{
                $result = ['error','¡Error al crear usuario!'];
            }
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error al editar usuario!'];
        }
        return $result;
    }
    function updateUsuario($datos){
        $result = '';
        try{
            $usuarioRelaciones = DB::select('SELECT * FROM user_relaciones WHERE User_id = '.$datos['id']);
            if(count($usuarioRelaciones) > 0){

                user_relaciones::where('User_id', $datos['id'])->update([
                    'Role_id'    => $datos['rol']
                ]); 

            }else{
                $id = DB::table('user_relaciones')->insertGetId([
                    'User_id'    => $datos['id'],
                    'Role_id'    => $datos['rol']
                ]);
            }

            if(@$datos['plantel'] != ''){
                $deletedRows = User_planteles::where('User_Id', $datos['id'])->delete();
                foreach ($datos['plantel'] as $plantel) {
                    $id = DB::table('user_planteles')->insertGetId([
                        'User_id'    => $datos['id'],
                        'Plantel_id' => $plantel
                    ]);
                }
            }

            if($datos['password'] != ''){
                users::where('id', $datos['id'])->update([
                    'password'   => Hash::make($datos['password'])
                ]);
            }
            users::where('id', $datos['id'])->update([
                'name'   => $datos['nombre'],
                'email'  => $datos['email'],
                'status' => $datos['estatus']
            ]);       

            $result = ['success','Usuario editado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error al editar usuario!'];
        }
        return $result;
    }
    function updateLoginUsuario($datos){
        /*users::where('id', $datos['id'])->update([
            'name'   => $datos['nombre'],
            'email'  => $datos['email'],
            'status' => $datos['estatus']
        ]);
        return $result;*/
    }
}