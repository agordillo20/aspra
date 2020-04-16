<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class carritoController extends Controller
{
    public function add(Request $request)
    {
        session_start();
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }
        $carrito = $_SESSION['carrito'];
        $articulo = array();
        $producto = $request->input('producto');
        $cantidad = $request->input('cantidad');
        if ($this->existe($producto, $carrito)) {
            foreach ($carrito as $c => $value) {
                foreach ($value as $produc) {
                    if ($producto == $produc) {
                        $carrito[$c][0] += $cantidad;
                    }
                }
            }
        } else {
            array_push($articulo, $cantidad);
            array_push($articulo, $producto);
            array_push($carrito, $articulo);
        }
        $_SESSION['carrito'] = $carrito;
    }

    function delete(Request $request)
    {
        session_start();
        $carrito = $_SESSION['carrito'];
        $producto = $request->input('producto');
        $cantidad = $request->input('cantidad_actual');
        if ($cantidad < 1) {
            foreach ($carrito as $c => $value) {
                foreach ($value as $produc) {
                    if ($producto == $produc) {
                        unset($carrito[$c]);
                    }
                }
            }
        } else {
            foreach ($carrito as $c => $value) {
                foreach ($value as $produc) {
                    if ($producto == $produc) {
                        $carrito[$c][0] = $cantidad;
                    }
                }
            }
        }
        $_SESSION['carrito'] = $carrito;
    }

    function comprar()
    {
        session_start();
        $total = 0;
        foreach ($_SESSION['carrito'] as $p) {
            $total += $p[0];
        }
        return view('finalizarCompra', ['carrito' => $_SESSION['carrito'], 'productos' => $total]);
    }

    function existe($producto, $carrito)
    {
        $existe = false;
        foreach ($carrito as $c => $k) {
            if ($carrito[$c][1]['cod_producto'] == $producto['cod_producto']) {
                $existe = true;
            }
        }
        return $existe;
    }

    function delete1(Request $request)
    {
        session_start();
        $carrito = $_SESSION['carrito'];
        $producto = $request->input('producto');
        foreach ($carrito as $c => $value) {
            foreach ($value as $produc) {
                if ($producto == $produc) {
                    unset($carrito[$c]);
                }
            }
        }
        $_SESSION['carrito'] = $carrito;
    }

    function comprobar()
    {
        $msg = "";
        if (Auth::check()) {
            $consulta = DB::select("select count(id) as c from direcciones where id_usuario=" . Auth::id())[0]->c;
            if ($consulta < 1) {
                $msg = "Se debe de registrar una dirección como minimo para realizar un pedido";
            }
        } else {
            $msg = "Se debe iniciar sesion para comprar";
        }
        return response()->json($msg);
    }

    function pago()
    {
        return view('pago');
    }
}
