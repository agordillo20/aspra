<?php

namespace App\Http\Controllers;

use App\Direccion;
use App\Lineapedidos;
use App\Pedido;
use App\Producto;
use App\Transportista;
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

    function contrareembolso(Request $request)
    {
        @session_start();
        $direccion = Direccion::find(DB::table("direcciones")->where('domicilio', '=', $request->input('direccion'))->where('id_usuario', '=', Auth::id())->get()[0]->id);
        $transportista = Transportista::find(DB::table("transportistas")->where('razon_social', '=', explode(" - ", $request->input('transportista'))[0])->get()[0]->id);
        $pedido = new Pedido();
        $pedido->fecha_pedido = date("Y-m-d");
        $pedido->id_direccion = $direccion->id;
        $pedido->id_transportista = $transportista->id;
        $pedido->id_usuario = Auth::id();
        $pedido->metodo_pago = "contrareembolso";
        $pedido->fecha_entrega = date("Y-m-d", strtotime($pedido->fecha_pedido . '+' . $transportista->duracion . 'days'));
        $cart = $_SESSION['carrito'];
        $total = 0;
        foreach ($cart as $producto) {
            $total += ($producto[1]['precio_venta'] * $producto[0]);
        }
        $pedido->total = $total;
        $pedido->save();
        foreach ($cart as $producto) {
            $factura = new Lineapedidos();
            $factura->id_pedido = $pedido->id;
            $factura->id_producto = $producto[1]['id'];
            $factura->precio = $producto[1]['precio_venta'];
            $factura->cantidad = $producto[0];
            $total += ($producto[1]['precio_venta'] * $producto[0]);
            $factura->save();
            $productoC = Producto::find($producto[1]['id']);
            $productoC->stock_actual = $productoC->stock_actual - $producto[0];
            $productoC->save();
        }
        session_destroy();
        return redirect("/home")->with('message', 'pedido realizado correctamente,recibira la factura junto a su pedido en un periodo de ' . ($transportista->duracion - 2) . '-' . $transportista->duracion . ' dias hábiles');
    }
}
