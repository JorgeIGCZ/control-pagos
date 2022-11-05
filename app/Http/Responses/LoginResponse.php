<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Controllers\RoleController;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $RoleController = new RoleController();
        $userRoles      = $RoleController->getRoles($_POST['email']);
        session()->put('user_roles', $userRoles);
        return redirect()->intended('/');
    }
}