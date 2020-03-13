<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class productoController extends Controller implements interface_methods
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function add()
    {
        return view('addProducto');
    }

    public function update()
    {
        return view('updateProducto');
    }

    public function delete()
    {
        return view('deleteProducto');
    }

    public function show()
    {
        return view('listProducto');
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
        $producto->precio_venta = $request->input('precio_venta');
        $producto->precio_compra = $request->input('precio_compra');
        $producto->descripcion = $request->input('descripcion');
        $producto->stock_minimo = $request->input('stock_minimo');
        $producto->stock_actual = $request->input('stock_actual');
        $categoria = DB::table('categorias')->where('nombre', "=", $request->input('categoria'));
        $producto->id_categoria = $categoria->get('id')[0]->id;
        $fabricante = DB::table('fabricantes')->where('razon_social', "=", $request->input('fabricante'));
        $producto->id_fabricante = $fabricante->get('id')[0]->id;
        $producto->cod_producto = $cod_producto;
        $file = $request->file('foto');
        //obtenemos el nombre del archivo
        $nombre = time() . "_" . $file->getClientOriginalName();
        //indicamos que queremos guardar un nuevo archivo en el disco local
        Storage::disk('imgproductos')->put($nombre, File::get($file));
        $producto->foto = asset("/images/productos/" . $nombre);
        $producto->save();
        return redirect('/admin/add/Productos');
    }

    public function update1(Request $request)
    {
        // TODO: Implement update1() method.
    }

    public function delete1(Request $request)
    {
        // TODO: Implement delete1() method.
    }

    public function show1(Request $request)
    {
        // TODO: Implement show1() method.
    }
}
