<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\descripcion;
use App\Fabricante;
use App\Producto;
use App\Transportista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class adminController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('/admin/admin');
    }

    public function showCategoria(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            $data = DB::table('categorias')->select('nombre')->where('id', '=', $id)->get();
            return response()->json($data);
        }
    }

    public function showFabricante(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            $data = DB::table('productos')->join('fabricantes', 'productos.id_fabricante', '=', 'fabricantes.id')->select('razon_social')->where('id_fabricante', '=', $id)->get();
            return response()->json($data);
        }
    }

    public function showDescripcion(Request $request)
    {
        if ($request->ajax()) {
            $campos = DB::select("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'aspra' AND table_name = 'descripcion'");
            $caracteristicas = DB::select("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'aspra' AND table_name = 'categorias'");
            $id = $request->input('id');
            $descripcion = descripcion::find($id);
            $array = array();
            foreach ($campos as $c) {
                $campo = $c->COLUMN_NAME;
                if (null !== $descripcion->$campo && $campo != 'id' && $campo != 'created_at' && $campo != 'updated_at') {
                    array_push($array, $descripcion->$campo);
                }
            }
            $atributos = count($array);
            $array1 = array();
            $array2 = array();
            for ($i = 2; $i < $atributos + 2; $i++) {
                //obtener cada columna que necesita
                array_push($array1, $caracteristicas[$i]->COLUMN_NAME);
            }
            $producto = Producto::where('id_descripcion', '=', $id)->get()->toArray()[0];
            $id_categoria = $producto['id_categoria'];
            foreach ($array1 as $a) {
                array_push($array2, DB::select("select " . $a . " from categorias where id=" . $id_categoria)[0]->$a);
            }
            array_push($array, $array2);
            array_push($array, $atributos);
        }
        return response()->json($array);
    }

    public function comprobarCodigo(Request $request)
    {
        if ($request->ajax()) {
            $cod_producto = $request->input('texto');
            try {
                if (DB::table('productos')->select()->get()->where('cod_producto', '=', $cod_producto)->count() > 0) {
                    return response()->json('existe');
                } else {
                    return response()->json('no existe');
                }
            } catch (Exception $e) {
                return response()->json('no existe');
            }
        }
    }

    public function buscar(Request $request)
    {
        $busqueda = $request->input('texto');
        if (substr_compare('cod_', $busqueda, 0, 4) == 0) {
            $producto = DB::table('productos')->select("*")->where('cod_producto', 'like', $busqueda . "%")->where('rebajado', '=', '0')->get("*");
        } else {
            $producto = DB::table('productos')->join('categorias', 'productos.id_categoria', '=', 'categorias.id')->select("productos.*")->where('categorias.nombre', 'like', $busqueda . "%")->where('rebajado', '=', '0')->get('productos.*');
        }
        return response()->json($producto);
    }

    public function aplicar(Request $request)
    {
        $porcentaje = $request->input('porcentaje');
        $productos = $request->input('productos');
        foreach ($productos as $p) {
            $producto = DB::table('productos')->select("*")->where('cod_producto', '=', $p)->get("*")[0];
            $nuevoPrecio = $producto->precio_venta - $producto->precio_venta * ($porcentaje / 100);
            DB::table('productos')->where('cod_producto', '=', $p)->update(['rebajado' => '1', 'precio_anterior' => $producto->precio_venta, 'precio_venta' => $nuevoPrecio]);
        }
        return response()->json("oferta aplicada con exito");
    }

    public function obtener(Request $request)
    {
        $id_categoria = $request->input('id_categoria');
        $caracteristicas = DB::select("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'aspra' AND table_name = 'categorias'");
        $categoria = Categoria::find($id_categoria);
        $array = array();
        foreach ($caracteristicas as $c) {
            $nombre = $c->COLUMN_NAME;
            if ($categoria->$nombre != null && $nombre != "id" && $nombre != "nombre" && $nombre != "created_at" && $nombre != "updated_at") {
                array_push($array, $categoria->$nombre);
            }
        }
        return response()->json($array);
    }

    public function obtener1(Request $request)
    {
        $campos = DB::select("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'aspra' AND table_name = 'descripcion'");
        $id = $request->input('id_descripcion');
        $descripcion = descripcion::find($id);
        $array = array();
        foreach ($campos as $c) {
            $campo = $c->COLUMN_NAME;
            if (null !== $descripcion->$campo && $campo != 'id' && $campo != 'created_at' && $campo != 'updated_at') {
                array_push($array, $descripcion->$campo);
            }
        }
        return response()->json($array);
    }

    public function editFabricante(Request $request)
    {
        return view('/admin/Fabricantes/editFabricante', ['fabricante' => Fabricante::find($request->input('id'))]);
    }

    public function editCategoria(Request $request)
    {
        $campos = DB::select("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'aspra' AND table_name = 'categorias'");
        return view('/admin/Categorias/editCategoria', ['categoria' => Categoria::find($request->input('id')), 'campos' => $campos]);
    }

    public function editTransportistas(Request $request)
    {
        return view('/admin/Transportistas/editTransportistas', ['transportista' => Transportista::find($request->input('id'))]);
    }
}
