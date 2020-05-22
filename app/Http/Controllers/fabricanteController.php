<?php

namespace App\Http\Controllers;

use App\Fabricante;
use Illuminate\Http\Request;

class fabricanteController extends Controller implements interface_methods
{
    public function __construct()
    {
        $this->middleware('admin');
    }


    public function add()
    {
        return view('/admin/Fabricantes/addFabricantes');
    }

    public function add1(Request $request)
    {
        $fabricante = new Fabricante();
        $fabricante->razon_social = $request->input('razon_social');
        $fabricante->origen = $request->input('origen');
        $fabricante->descripcion = $request->input('descripcion');
        $fabricante->correo = $request->input('correo');
        $fabricante->save();
        return redirect('/admin/add/Fabricantes');
    }

    public function update(Request $request)
    {
        $fabricante = Fabricante::find($request->input('id'));
        $fabricante->correo = $request->input('correo');
        $fabricante->razon_social = $request->input('razon_social');
        $fabricante->origen = $request->input('origen');
        $fabricante->descripcion = $request->input('descripcion');
        $fabricante->save();
        return redirect('/admin/list/Fabricantes');
    }

    public function update1(Request $request)
    {
        // TODO: Implement update1() method.
    }

    public function delete(Request $request)
    {
        Fabricante::destroy($request->input('idFabricante'));
        return redirect('/admin/list/Fabricantes');
    }

    public function show()
    {
        return view('/admin/Fabricantes/listFabricantes');
    }
}
