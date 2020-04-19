<?php

namespace App\Http\Controllers;

use App\Direccion;
use App\Factura;
use App\Pedido;
use App\Transportista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class perfilController extends Controller
{
    public function perfil(Request $request)
    {
        $user = Auth::user();
        $pedidos = DB::select("select count(id) as cantidad from pedidos where id_usuario=" . $user->id)[0]->cantidad;
        return view('perfil', ['usuario' => $user, 'pedidos' => $pedidos]);
    }

    public function addDireccion(Request $request)
    {
        $existe = false;
        $mensaje = "";
        $direcciones = DB::select("select domicilio from direcciones where id_usuario=" . Auth::id());
        foreach ($direcciones as $d) {
            if ($d->domicilio == $request->input('domicilio')) {
                $existe = true;
                break;
            }
        }
        if (!$existe) {
            $direccion = new Direccion();
            $direccion->pais = $request->input('pais');
            $direccion->provincia = $request->input('provincia');
            $direccion->localidad = $request->input('localidad');
            $direccion->cod_postal = $request->input('cod_postal');
            $direccion->domicilio = $request->input('domicilio');
            $direccion->id_usuario = Auth::id();
            $direccion->save();
            $mensaje = 'creado correctamente';
        } else {
            $mensaje = 'ya existe el domicilio que intenta agregar';
        }
        return response()->json($mensaje);
    }

    public function foto(Request $request)
    {
        $user = Auth::user();
        if ($user->foto != null) {
            $foto = $user->foto;
            $array = explode("/", $foto);
            $nombreAnterior = "\\" . $array[3] . "\\" . $array[4] . "\\" . $array[5];
            File::delete(public_path() . $nombreAnterior);
        }
        $file = $request->file('foto');
        //obtenemos el nombre del archivo
        $nombre = time() . "_" . $file->getClientOriginalName();
        //indicamos que queremos guardar un nuevo archivo en el disco local
        Storage::disk('imgusers')->put($nombre, File::get($file));
        $user->foto = asset("/images/users/" . $nombre);
        $user->save();
        return redirect('/perfil');
    }

    public function updateUser(Request $request)
    {
        $username = $request->input('username');
        $fecha = $request->input('fecha_nacimiento');
        $user = Auth::user();
        $user->name = $username;
        $user->fecha_nacimiento = $fecha;
        $user->save();
        return redirect('/perfil');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $oldPass = $request->input('old_password');
        $newPass = $request->input('new_password');
        $repitPass = $request->input('repit_password');
        if (Hash::check($oldPass, $user->getAuthPassword())) {
            if ($newPass == $repitPass) {
                $user->password = Hash::make($newPass);
                $user->save();
            }
        }
        return redirect('/perfil');
    }

    public function deleteDireccion(Request $request)
    {
        Direccion::destroy($request->input('id'));
    }

    public function searchDireccion(Request $request)
    {
        return response()->json(Direccion::find($request->input('id')));
    }

    public function updateDireccion(Request $request)
    {
        $direccion = Direccion::find($request->input('id'));
        $direccion->domicilio = $request->input('domicilio');
        $direccion->localidad = $request->input('localidad');
        $direccion->provincia = $request->input('provincia');
        $direccion->cod_postal = $request->input('cod_postal');
        $direccion->pais = $request->input('pais');
        $direccion->save();
        return response()->json();
    }

    public function imprimirfactura(Request $request)
    {
        $pedido = Pedido::find($request->input('idFactura'));
        $facturas = Factura::all()->where('id_pedido', '=', $pedido->id);
        $pdf = \PDF::loadView('pdf', ['cod_factura' => '000' . $pedido->id, 'direccion' => Direccion::find($pedido->id_direccion), 'transportista' => Transportista::find($pedido->id_transportista), 'factura' => $facturas]);
        return $pdf->download('factura' . $pedido->fecha_pedido . '.pdf');
    }
}
