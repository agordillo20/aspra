<?php

namespace App\Http\Controllers;

use App\Producto;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $productos = Producto::all();
        $descripcion = array();
        foreach ($productos as $p) {
            array_push($descripcion, explode(",", $p->descripcion)[0]);
        }
        return view('home', ["separado" => $descripcion]);
    }
}
