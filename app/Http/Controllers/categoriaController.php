<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;

class categoriaController extends Controller implements interface_methods
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    //
    public function add()
    {
        return view('/admin/Categorias/addCategorias');
    }

    public function add1(Request $request)
    {
        $categoria = new Categoria();
        $categoria->nombre = $request->input('nombre');
        foreach ($request->input() as $peticion => $valor) {
            if ($peticion != "_token" && $peticion != "nombre" && $peticion != "campos") {
                $categoria->$peticion = $valor;
            }
        }
        $categoria->save();
        return redirect('/admin/add/Categorias');
    }

    public function update(Request $request)
    {
        $categoria = Categoria::find($request->input('id'));
        $categoria->nombre = $request->input('nombre');
        $categoria->descripcion1 = $request->input('descripcion1');
        $categoria->descripcion2 = $request->input('descripcion2');
        $categoria->descripcion3 = $request->input('descripcion3');
        $categoria->descripcion4 = $request->input('descripcion4');
        $categoria->descripcion5 = $request->input('descripcion5');
        $categoria->descripcion6 = $request->input('descripcion6');
        $categoria->descripcion7 = $request->input('descripcion7');
        $categoria->descripcion8 = $request->input('descripcion8');
        $categoria->descripcion9 = $request->input('descripcion9');
        $categoria->descripcion10 = $request->input('descripcion10');
        $categoria->descripcion11 = $request->input('descripcion11');
        $categoria->descripcion12 = $request->input('descripcion12');
        $categoria->descripcion13 = $request->input('descripcion13');
        $categoria->descripcion14 = $request->input('descripcion14');
        $categoria->descripcion15 = $request->input('descripcion15');
        $categoria->descripcion16 = $request->input('descripcion16');
        $categoria->descripcion17 = $request->input('descripcion17');
        $categoria->otras_caracteristicas = $request->input('otras_caracteristicas');
        $categoria->save();
        return redirect('/admin/list/Categorias');
    }

    public function update1(Request $request)
    {
        // TODO: Implement update1() method.
    }

    public function delete(Request $request)
    {
        Categoria::destroy($request->input('idCategoria'));
        return redirect('/admin/list/Categorias');
    }

    public function show()
    {
        return view('/admin/Categorias/listCategoria');
    }
}
