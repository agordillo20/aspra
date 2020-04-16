<?php

namespace App\Http\Controllers;

use App\Transportista;
use Illuminate\Http\Request;

class transportistaController extends Controller implements interface_methods
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    //
    public function add()
    {
        return view('/admin/Transportistas/addTransportistas');
    }

    public function add1(Request $request)
    {
        $transportista = new Transportista();
        foreach ($request->input() as $peticion => $valor) {
            if ($peticion != "_token") {
                $transportista->$peticion = $valor;
            }
        }
        $transportista->save();
        return redirect('/admin/add/Transportistas');
    }

    public function update(Request $request)
    {
        $transportista = Transportista::find($request->input('id'));
        $transportista->razon_social = $request->input('razon_social');
        $transportista->precio = $request->input('precio');
        $transportista->duracion = $request->input('duracion');
        $transportista->save();
        return redirect('/admin/list/Transportistas');
    }

    public function delete(Request $request)
    {
        Transportista::destroy($request->input('idTransportista'));
        return redirect('/admin/list/Transportistas');
    }

    public function show()
    {
        return view('/admin/Transportistas/listTransportistas');
    }


    public function update1(Request $request)
    {
        // TODO: Implement update1() method.
    }
}
