<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\usuarios_onlines;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "/registrado";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout()
    {
        date_default_timezone_set('Europe/Madrid');
        $tiempo = usuarios_onlines::query("select fecha_inicio from usuarios_onlines where id_usuario='".Auth::id()."'")->get('fecha_inicio')[0]['fecha_inicio'];
        try {
            $tiempo = new \DateTime($tiempo);
        } catch (\Exception $e) {
        }
        $tiempo = $tiempo->diff(now());
        $tiempo = $this->get_format($tiempo);
        Telegram::sendMessage(['chat_id'=>'477948845','parse_mode' => 'HTML','text'=>'El usuario <b>'.Auth::user()->name.'</b> ha cerrado sesion y ha estado en linea <u>'.$tiempo.'</u>']);

        $users = array_values(usuarios_onlines::all()->where('id_usuario','=',Auth::id())->all())[0];
        usuarios_onlines::destroy($users->id);
        Auth::logout();
        @session_start();
        session_destroy();
        return redirect('/');
    }
    function get_format($df) {

        $str = '';
        $str .= ($df->invert == 1) ? ' - ' : '';
        if ($df->y > 0) {
            // years
            $str .= ($df->y > 1) ? $df->y . ' Años ' : $df->y . ' Año ';
        } if ($df->m > 0) {
            // month
            $str .= ($df->m > 1) ? $df->m . ' Meses ' : $df->m . ' Mes ';
        } if ($df->d > 0) {
            // days
            $str .= ($df->d > 1) ? $df->d . ' Dias ' : $df->d . ' Dia ';
        } if ($df->h > 0) {
            // hours
            $str .= ($df->h > 1) ? $df->h . ' Horas ' : $df->h . ' Hora ';
        } if ($df->i > 0) {
            // minutes
            $str .= ($df->i > 1) ? $df->i . ' Minutos ' : $df->i . ' Minuto ';
        } if ($df->s > 0) {
            // seconds
            $str .= ($df->s > 1) ? $df->s . ' Segundos ' : $df->s . ' Segundo ';
        }
        return $str;
    }
}
