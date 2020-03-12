<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RedireccionController extends Controller
{
    public function redireccion()
    {
        $id = Auth::id();
        $rol = DB::table('roles')->join('roles_user', 'roles.id', '=', 'roles_user.roles_id', 'inner')->where('roles_user.user_id', '=', $id)->select('roles.nombre')->get()[0];
        if ($rol->nombre == "admin") {
            return redirect('/admin');
        } else {
            return redirect('/');
        }

    }
}
