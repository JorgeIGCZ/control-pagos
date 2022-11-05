<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles_resources;
use App\Models\Roles;
use Illuminate\Support\Facades\DB;
use URL;

class RoleController extends Controller
{
    protected $fillable = ['Ver'];
    function indexAction(){
        if (session()->get('user_roles')['Configuración']->Ver != 'Y'){
            header("Location: " . URL::to('/login'), true, 302);
            exit();
        }
        $roles      = DB::select('SELECT * FROM roles_resources');
        return view('roles.index',['roles' => $roles]);
    }
    function updateRole($data,$roleId){
        $result = '';
        try{
            foreach($data as $resources){
                $query = [];
                foreach($resources['data'] as $key => $value){
                    $query[] = [$key => $value];
                }
                $role = DB::select('SELECT * FROM roles_resources WHERE Role_id = '.$roleId.' AND Resource_id = '.$resources['id']);
                if(count($role) > 0){
                    Roles_resources::where('Role_id', $roleId)->where('Resource_id', $resources['id'])->update(
                        $resources['data']
                    );
                }else{
                    $resourcesA                = $resources['data'];
                    $resourcesA['Role_id']     = $roleId;
                    $resourcesA['Resource_id'] = $resources['id'];
                    
                    $id = DB::table('roles_resources')->insertGetId(
                        $resourcesA
                    );
                }
            }                                                       
            $result = ['success','¡Rol editado exitosamente!'];
        }catch(\Illuminate\Database\QueryException $e){
            print_r($e->errorInfo);
            $result = ['error','¡Error al editar rol!'];
        }
        return $result;
    }
    function getRoles($email){
        
        $roleQuery = ''.
                     'SELECT R.Nombre,RR.Ver,RR.Crear,RR.Modificar,RR.Eliminar,RR.Estatus, '.
                     '(                                                          '.
                      '  SELECT group_concat(UP.Plantel_id separator ", ")       '.
                      '  FROM user_planteles UP                                  '.
                      '  WHERE UP.User_id = U.id                                 '.
                      ') AS Plantel_id                                           '.
                     'FROM                users  U                                        '.
                     'LEFT JOIN user_relaciones UR ON UR.User_id = U.id                   '.
                     'LEFT JOIN roles_resources RR ON RR.Role_id = UR.Role_id             '.
                     'LEFT JOIN resources        R ON R.Id       = RR.Resource_id         '.
                     'WHERE U.email =  "'.$email.'"  ';

        $roles     = DB::select($roleQuery);


        $roleNameQuery =  ''.
                          'SELECT R.Nombre                                   '.
                          'FROM users U                                      '.
                          'LEFT JOIN user_relaciones UR ON UR.User_id = U.Id '.
                          'LEFT JOIN roles R            ON R.Id = UR.Role_id '.
                          'WHERE U.email =  "'.$email.'"                     ';

        $roleName     = DB::select($roleNameQuery);

        $user_roles = array();
        foreach ($roles as $role) {
            $user_roles[$role->Nombre] = $role;
        }
        $user_roles['role'] = $roleName[0]->Nombre;

        return $user_roles;
    }
}