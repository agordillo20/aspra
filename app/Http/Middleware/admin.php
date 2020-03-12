<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $id = Auth::id();
            $rol = DB::table('roles')->join('roles_user', 'roles.id', '=', 'roles_user.roles_id', 'inner')->where('roles_user.user_id', '=', $id)->select('roles.nombre')->get()[0];
            if ($rol->nombre == "admin") {
                return $next($request);
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
    }
}
