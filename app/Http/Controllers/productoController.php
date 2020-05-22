<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\descripcion;
use App\Direccion;
use App\Fabricante;
use App\Lineapedidos;
use App\Pedido;
use App\Producto;
use App\Transportista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Laravel\Facades\Telegram;

class productoController extends Controller implements interface_methods
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function add()
    {
        return view('admin/Productos/addProducto');
    }

    public function add1(Request $request)
    {
        $producto = new Producto();
        //generador de codigo
        $cod_producto = "cod_001";
        try {
            $id = DB::table('productos')->select('id')->limit(1)->orderBy('id', 'desc')->get()[0]->id;
            if ($id != null) {
                $id = $id + 1;
                $cod_producto = "cod_00" . $id;
            }
        } catch (\Exception $e) {
        }
        $producto->activo = true;
        $producto->precio_venta = $request->input('precio_venta');
        $producto->precio_compra = $request->input('precio_compra');
        $producto->id_descripcion = DB::table('descripcion')->select('id')->limit(1)->orderBy('id', 'desc')->get()[0]->id;
        $producto->stock_minimo = $request->input('stock_minimo');
        $producto->stock_actual = $request->input('stock_actual');
        $producto->nombre = $request->input('nombre');
        $categoria = DB::table('categorias')->where('nombre', "=", $request->input('categoria'));
        $producto->id_categoria = $categoria->get('id')[0]->id;
        $fabricante = DB::table('fabricantes')->where('razon_social', "=", $request->input('fabricante'));
        $producto->id_fabricante = $fabricante->get('id')[0]->id;
        $producto->cod_producto = $cod_producto;
        $producto->rebajado = false;
        $producto->precio_anterior = $producto->precio_venta;
        $file = $request->file('foto');
        //obtenemos el nombre del archivo
        $nombre = time() . "_" . $file->getClientOriginalName();
        //indicamos que queremos guardar un nuevo archivo en el disco local
        Storage::disk('imgproductos')->put($nombre, File::get($file));
        $producto->foto = "/images/productos/" . $nombre;
        $producto->save();
        return redirect('/admin/add/Productos');
    }

    public function addDescripcion(Request $request)
    {
        //Funcion proveniente de ajax para agregar la descripcion
        $campos = DB::select("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'aspra' AND table_name = 'descripcion'");
        $i = 0;
        $descripcion = new descripcion();
        foreach (json_decode($request->input('array')) as $k => $v) {
            if ($v != null) {
                $i++;
                $campo = $campos[$i]->COLUMN_NAME;
                $descripcion->$campo = $v;
            }
        }
        $descripcion->save();
        return response()->json('creado');
    }

    public function updateDescripcion(Request $request)
    {
        $campos = DB::select("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = 'aspra' AND table_name = 'descripcion'");
        $arrayCamposDesc = array();
        foreach ($campos as $c => $k) {
            if ($k->COLUMN_NAME != "created_at" && $k->COLUMN_NAME != "updated_at" && $k->COLUMN_NAME != "id" && $k->COLUMN_NAME != "campo_otros") {
                array_push($arrayCamposDesc, $k->COLUMN_NAME);
            }
        }
        $arrayDesc = $request->input('array');
        $descripcion = descripcion::find($request->input('id'));
        $i = 0;
        foreach ($arrayCamposDesc as $nombre) {
            if ($i < count($arrayDesc)) {
                $descripcion->$nombre = $arrayDesc[$i];
                $i++;
            } else {
                break;
            }
        }
        $descripcion->save();
        return response()->json();
    }

    public function update(Request $request)
    {
        return $request->input('id');
    }

    public function update2(Request $request)
    {
        $id = $request->input('id');
        $producto = Producto::find($id);
        return view('admin/Productos/editarProducto', ['producto' => $producto, 'categorias' => Categoria::all(), 'fabricantes' => Fabricante::all()]);
    }

    public function update1(Request $request)
    {
        $id = $request->input('id_producto');
        $producto = Producto::find($id);
        $id_categoria = $request->input('categoria');
        $id_fabricante = $request->input('id_fabricante');
        Producto::where('id', '=', $id)->update(['id_categoria' => $id_categoria, 'id_fabricante' => $id_fabricante, 'nombre' => $request->input('nombre'),
            'cod_producto' => $request->input('cod_producto'), 'precio_venta' => $request->input('precio_venta'),
            'precio_compra' => $request->input('precio_compra'), 'stock_actual' => $request->input('stock_actual'),
            'stock_minimo' => $request->input('stock_minimo')]);
        //Comprueba si la foto ha sido actualizada y la reemplaza por la nueva
        if ($request->file('foto') !== null) {
            $foto = $producto->foto;
            $array = explode("/", $foto);
            $nombreAnterior = "\\" . $array[1] . "\\" . $array[2] . "\\" . $array[3];
            File::delete(public_path() . $nombreAnterior);
            $file = $request->file('foto');
            $nombre = time() . "_" . $file->getClientOriginalName();
            Storage::disk('imgproductos')->put($nombre, File::get($file));
            $producto->update(['foto' => "/images/productos/" . $nombre]);
        }
        return redirect('/admin/list/Productos');
    }

    public function delete(Request $request)
    {
        $id = $request->input('idProducto');
        $producto = Producto::find($id);
        $producto->activo = false;
        $producto->save();
        return redirect('/admin/list/Productos');
    }

    public function show()
    {
        $productos = Producto::all()->where('activo', '=', '1')->all();
        return view('/admin/Productos/listProductos', ['productos' => $productos]);
    }

    public function ofertar()
    {
        return view('admin/Productos/ofertarProductos');
    }

    public function bajas()
    {
        return response()->json(array_values(Producto::all()->where('activo', '=', '0')->all()));
    }

    public function reponer()
    {
        return view('/admin/Productos/reponer');
    }

    public function reponer1(Request $request)
    {
        $unidades = $request->input('unidades');
        $Nombreproducto = $request->input('producto');
        $producto = Producto::all()->where('nombre', '=', $Nombreproducto)->first();
        $producto->stock_actual += $unidades;
        $producto->save();
        $d = DB::table("direcciones")->where('domicilio', '=', $request->input('direccion'))->where('id_usuario', '=', Auth::id())->get()[0];
        $direccion = Direccion::find($d->id);
        $transportistas = Transportista::all();
        $ids = array();
        foreach ($transportistas as $t) {
            array_push($ids, $t->id);
        }
        $idAleatorio = rand(0, count($ids) - 1);
        $transportista = Transportista::find($ids[$idAleatorio]);
        //Nuevo pedido a los fabricantes
        $pedido = new Pedido();
        $pedido->metodo_pago = "contrareembolso";
        $pedido->fecha_pedido = date("Y-m-d");
        $pedido->id_direccion = $direccion->id;
        $pedido->id_transportista = $transportista->id;
        $pedido->id_usuario = Auth::id();
        $pedido->fecha_entrega = date("Y-m-d", strtotime($pedido->fecha_pedido . '+' . $transportista->duracion . 'days'));
        $pedido->total = ($producto->precio_compra * $unidades);
        $pedido->save();
        //Insertar factura con los campos correspondientes
        $factura = new Lineapedidos();
        $factura->id_producto = $producto->id;
        $factura->id_pedido = Pedido::all()->last()->id;
        $factura->cantidad = $unidades;
        $factura->precio = $producto->precio_compra;
        $factura->save();
        //Mandar mensaje de pedido enviado
        Telegram::sendMessage(['chat_id' => '477948845', 'parse_mode' => 'HTML', 'text' => 'Se han recibido <b>' . $unidades . '</b> unidades al almacén localizado en <u>' . $direccion->domicilio . '</u> de <b>' . $producto->nombre . '</b>, provenientes de <u>' . Fabricante::find($producto->id_fabricante)->razon_social . '</u>']);
        return redirect('/admin');
    }
}
