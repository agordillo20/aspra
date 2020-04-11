<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\descripcion;
use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class catalogoController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function catalogo(Request $request)
    {
        session_start();
        session_destroy();
        $idCategoria = $request->get('id');//Cambiando este valor se modifica la vista entera,asi como sus filtros
        $categoria = Categoria::find($idCategoria);
        $nombreCategoria = $categoria->nombre;
        $arrayCamposCategoria = array();
        foreach (DB::select("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'aspra' AND table_name = 'categorias'") as $campo) {
            $nombre = $campo->COLUMN_NAME;
            if ($categoria->$nombre != null && $nombre != "id" && $nombre != "nombre" && $nombre != "created_at" && $nombre != "updated_at") {
                array_push($arrayCamposCategoria, str_replace('_', ' ', $categoria->$nombre));
            }
        }
        $productos = DB::select('SELECT id_descripcion FROM productos WHERE id_categoria=' . $idCategoria);
        $arrayDescripciones = array();
        $arrayCamposDescripcion = array();
        $camposDescripcion = DB::select("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'aspra' AND table_name = 'descripcion'");
        foreach ($productos as $p) {
            $descripcion = descripcion::find($p->id_descripcion);
            foreach ($camposDescripcion as $campo) {
                $nombre = $campo->COLUMN_NAME;
                if ($nombre != "id" && $nombre != "created_at" && $nombre != "updated_at") {
                    if ($descripcion->$nombre == null) {
                        array_push($arrayCamposDescripcion, array());
                    } else {
                        array_push($arrayCamposDescripcion, [$descripcion->$nombre]);
                    }

                }
            }
            array_push($arrayDescripciones, $arrayCamposDescripcion);
            $arrayCamposDescripcion = array();
        }
        $arrayFinal = $arrayDescripciones[0];
        foreach ($arrayDescripciones as $arrays) {
            for ($i = 0; $i < count($arrayCamposCategoria); $i++) {
                if (!empty($arrayFinal[$i])) {
                    $valor = $arrays[$i][0];
                    if (!in_array($valor, $arrayFinal[$i])) {
                        array_push($arrayFinal[$i], $valor);
                    }
                } else {
                    $valor = $arrays[$i];
                    if (!empty($valor)) {
                        array_push($arrayFinal[$i], $valor[0]);
                    }
                }
            }
        }
        foreach ($arrayFinal as $r => $v) {
            if (empty($v)) {
                unset($arrayFinal[$r]);
            }
        }
        return view('catalogo', ['categorias' => $arrayCamposCategoria, 'valores' => $arrayFinal, 'productos' => Producto::all()->where('id_categoria', '=', $idCategoria), 'id_categoria' => $idCategoria, 'nombre' => $nombreCategoria]);
    }

    public function filtrar(Request $request)
    {
        //obtener los valores
        $id_categoria = $request->input('id_categoria');
        $add = $request->input('add');
        $arrayNombres = $request->input('nombre');
        $valor = $request->input('valor');
        //obtener la posicion que toma el nombre buscado en nuestro array de nombres
        @session_start();
        //si esta la session con el elemento array activo,busca y comprueba que el elemento que intenta pasar no este anteriormente y lo añade al array y si no esta
        //definido lo define y lo establece en el array
        $posicion = array_search($add, $arrayNombres);
        if (!isset($_SESSION['array'])) {
            $global = array();
            $_SESSION['array'] = $global;
        }
        if (isset($_SESSION['array'])) {
            $array = $_SESSION['array'];
            if ($valor != null) {
                if (isset($array[$posicion][$add])) {
                    if (!in_array($valor, $array[$posicion][$add])) {
                        array_push($array[$posicion][$add], $valor);
                    }
                } else {
                    $secundario = array($add => array());
                    array_push($array, $secundario);
                    array_push($array[$posicion][$add], $valor);
                }
                $_SESSION['array'] = $array;
            }
        }
        $campos = DB::select("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'aspra' AND table_name = 'descripcion'");
        $arrayCamposDesc = array();
        foreach ($campos as $c => $k) {
            if ($k->COLUMN_NAME != "created_at" && $k->COLUMN_NAME != "updated_at" && $k->COLUMN_NAME != "id") {
                array_push($arrayCamposDesc, $k->COLUMN_NAME);
            }
        }

        $sql = "select p.* from productos p inner join descripcion d on p.id_descripcion=d.id where p.id_categoria=" . $id_categoria;
        foreach ($array as $items => $value) {
            $i = 0;
            foreach ($value as $v => $z) {
                foreach ($z as $x) {
                    if ($i > 0) {
                        $sql = $sql . " OR d." . $arrayCamposDesc[$this->getPos($v, $id_categoria)] . "='" . $x . "'";
                        $i++;
                    } else {
                        $sql = $sql . " and (d." . $arrayCamposDesc[$this->getPos($v, $id_categoria)] . "='" . $x . "'";
                        $i++;
                    }
                }
                $sql = $sql . ")";
            }
        }
        return response()->json(DB::select($sql));
    }

    public function filtrar1(Request $request)
    {
        //obtener los valores
        $add = $request->input('add');
        $valor = $request->input('valor');
        $arrayNombres = $request->input('nombre');
        session_start();
        $array = $_SESSION['array'];
        if (count($array) == 0) {
            $arrayNombres = array();
        }
        foreach ($array as $i => $k) {
            if (isset($array[$i][$add])) {
                foreach ($array[$i][$add] as $items => $z) {
                    if ($z == $valor) {
                        if (count($array[$i][$add]) == 1) {
                            unset($array[$i]);
                            unset($arrayNombres[$i]);
                        } else {
                            unset($array[$i][$add][$items]);
                        }
                    }
                }
            }
        }
        $_SESSION['array'] = $array;
        return response()->json($arrayNombres);
    }

    private function getPos($nombre, $id)
    {
        $pos = 0;
        $camposC = DB::select("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'aspra' AND table_name = 'categorias'");
        $arrayCamposCategoria = array();
        foreach ($camposC as $c => $k) {
            if ($k->COLUMN_NAME != "nombre" && $k->COLUMN_NAME != "created_at" && $k->COLUMN_NAME != "updated_at" && $k->COLUMN_NAME != "id") {
                array_push($arrayCamposCategoria, $k->COLUMN_NAME);
            }
        }
        foreach ($arrayCamposCategoria as $categoria) {
            foreach (DB::select("select " . $categoria . " from categorias where id=" . $id) as $column => $s) {
                foreach ($s as $as) {
                    if ($as == $nombre) {
                        $pos = array_search($categoria, $arrayCamposCategoria);
                    }
                }
            }
        }
        return $pos;
    }

    public function showUser(Request $request)
    {
        $id = $request->get('id');
        $producto = Producto::find($id);
        $descripcion = descripcion::find($producto->id_descripcion);
        $arrayCamposDescripcion = array();
        //Se recorren los campos de la descripcion y guarda en un array los valores de los campos que son distintos de null ...
        foreach (DB::select("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'aspra' AND table_name = 'descripcion'") as $campo) {
            $nombre = $campo->COLUMN_NAME;
            if ($nombre != "id" && $nombre != "created_at" && $nombre != "updated_at") {
                array_push($arrayCamposDescripcion, $descripcion->$nombre);
            }
        }
        $categoria = Categoria::find($producto->id_categoria);
        $arrayCamposCategoria = array();
        foreach (DB::select("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'aspra' AND table_name = 'categorias'") as $campo) {
            $nombre = $campo->COLUMN_NAME;
            if ($categoria->$nombre != null && $nombre != "id" && $nombre != "nombre" && $nombre != "created_at" && $nombre != "updated_at") {
                array_push($arrayCamposCategoria, str_replace('_', ' ', $categoria->$nombre));
            }
        }
        $Nombrecategoria = DB::table('productos')->join('categorias', 'productos.id_categoria', '=', 'categorias.id')->select('categorias.nombre')->get()[0];
        $fabricante = DB::table('productos')->join('fabricantes', 'productos.id_fabricante', '=', 'fabricantes.id')->select('razon_social')->where('productos.id', '=', $producto->id)->get()[0];
        return view('ConsultaProducto', ['producto' => $producto, 'nombre' => $Nombrecategoria, 'fabricante' => $fabricante, 'camposCategoria' => $arrayCamposCategoria, 'camposDescripcion' => $arrayCamposDescripcion]);
    }
}
