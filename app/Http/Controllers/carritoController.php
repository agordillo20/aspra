<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        if ($cantidad != 1) {
            foreach ($carrito as $c => $value) {
                foreach ($value as $produc) {
                    if ($producto == $produc) {
                        $carrito[$c][0] = $cantidad;
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
        foreach ($carrito as $c => $value) {
            foreach ($value as $produc) {
                if ($producto == $produc) {
                    unset($carrito[$c]);
                }
            }
        }
        $_SESSION['carrito'] = $carrito;
    }
}
