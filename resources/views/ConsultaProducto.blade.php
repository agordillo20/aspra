@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class=" card card-header w-auto text-center font-weight-bold bg-success"
                     style="margin:5em auto 0;padding-top: 2em;text-transform: uppercase">{{$producto->nombre}}</div>
                <div class="card-body bg-dark text-white font-weight-bold" style="margin:0 auto">
                    <div class="row">
                        <div class="col-9">
                            <table class="table table-hover table-dark text-white">
                                <tr>
                                    <td class="col-sm-1">Codigo del producto</td>
                                    <td class="col-sm-2">{{$producto->cod_producto}}</td>
                                </tr>
                                <tr>
                                    <td class="col-sm-1">Modelo</td>
                                    <td class="col-sm-2">{{$fabricante->razon_social}} - {{$producto->nombre}}</td>
                                </tr>
                                @for($i=0;$i<count($camposCategoria);$i++)
                                    <tr>
                                        <td class="col-sm-1">{{$camposCategoria[$i]}}</td>
                                        <td class="col-sm-2" id="descripcion {{$i}}">{{$camposDescripcion[$i]}}</td>
                                    </tr>
                                @endfor
                            </table>
                        </div>
                        <div class="col text-center">
                            <img class="img-responsive" src={{$producto->foto}} th:alt="foto"
                                 style="height: 230px;width: 200px;"/>
                            <div style="margin-top: .5em;padding: .5em">
                                <pre class="font-weight-bold"
                                     style="color: red;">{{$producto->stock_actual}} Restantes</pre>
                                Precio : {{$producto->precio_venta}} €<br>
                                <button class="btn btn-outline-primary" style="margin-top: .25em">Añadir al Carrito
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer font-weight-bold" style="margin: auto">
                    TAGS: <span class="badge badge-pill">{{$nombre->nombre}}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
