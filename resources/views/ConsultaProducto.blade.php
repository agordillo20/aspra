@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class=" card card-header w-auto text-center font-weight-bold bg-success"
                     style="margin:5em auto 0;padding-top: 2em;text-transform: uppercase">{{$descripcion[0]}}</div>
                <div class="card-body bg-dark text-white font-weight-bold" style="margin:0 auto">
                    <div class="row">
                        <div class="col-9">
                            <table class="table table-hover table-dark text-white">
                                <tr>
                                    <td class="col-sm-2">Codigo del producto:</td>
                                    <td class="col-sm-2">{{$producto->cod_producto}}</td>
                                    <td class="col-sm-1">Marca:</td>
                                    <td class="col-sm-3">{{$fabricante->razon_social}}</td>
                                    <td class="col-lg-2">Bateria:</td>
                                    <td>{{$descripcion[1]}}</td>
                                </tr>
                                <tr>
                                    <td>Resolución de pantalla:</td>
                                    <td>{{$descripcion[2]}}</td>
                                    <td>Procesador:</td>
                                    <td>{{$descripcion[3]}}</td>
                                    <td>Memoria ram:</td>
                                    <td>{{$descripcion[4]}}</td>
                                </tr>
                                <tr>

                                    <td>Almacenamiento interno:</td>
                                    <td>{{$descripcion[5]}}</td>
                                    <td colspan="4"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col text-center">
                            <img class="img-responsive" src={{$producto->foto}} th:alt="foto"
                                 style="height: 230px;width: 200px;"/>
                        </div>
                    </div>
                </div>
                <div class="card-footer font-weight-bold" style="margin: auto">
                    TAGS: <span class="badge badge-pill">{{$categoria->nombre}}</span>
                </div>
            </div>
            <div style="margin-top: 3em;padding: .5em">
                <button class="btn btn-outline-primary">Añadir al Carrito</button>
            </div>
        </div>
    </div>
@endsection
