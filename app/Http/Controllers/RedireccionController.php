<?php

namespace App\Http\Controllers;

use App\usuarios_onlines;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Laravel\Facades\Telegram;

class RedireccionController extends Controller
{
    public function redireccion()
    {
        if (!empty(array_values(usuarios_onlines::all()->where('id_usuario','=',Auth::id())->all())[0])){
            Auth::logout();
            return redirect('/login')->with(['message'=>'Ya esta iniciada la sesión,si no ha sido usted pongase en contacto con nosotros']);
        }else{
            Telegram::sendMessage(['chat_id'=>'477948845','parse_mode' => 'HTML','text'=> 'El usuario <b>' .Auth::user()->name. '</b> ha iniciado sesion']);
            $user = new usuarios_onlines();
            date_default_timezone_set('Europe/Madrid');
            $user->fecha_inicio=now();
            $user->id_usuario = Auth::id();
            $user->save();
            Telegram::sendMessage(['chat_id'=>'477948845','parse_mode' => 'HTML','text'=>'Usuarios online: <b>'.usuarios_onlines::count().'</b>']);
            $id = Auth::id();
            $rol = DB::table('roles')->join('roles_user', 'roles.id', '=', 'roles_user.roles_id', 'inner')->where('roles_user.user_id', '=', $id)->select('roles.nombre')->get()[0];
            if ($rol->nombre == "admin") {
                return redirect('/admin');
            } else {
                return redirect('/');
            }
        }
    }
}
