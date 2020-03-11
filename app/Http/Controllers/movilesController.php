<?php

namespace App\Http\Controllers;

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
        return view('moviles');
    }
}
