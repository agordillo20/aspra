<?php

namespace App\Http\Controllers;

use App\Producto;

class movilesController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function catalogo()
    {
        $productos = Producto::all();
        $descripcion = array();
        foreach ($productos as $p) {
            array_push($descripcion, explode(",", $p->descripcion)[0]);
        }
        return view('moviles', ["separado" => $descripcion]);
    }
}
