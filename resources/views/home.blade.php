@extends('layouts.app')

@section('content')
    @if (session('message'))
        <div class="alert alert-success text-center" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="background-color: rgba(5,92,28,0.31)">
                    <div class="card-header w-auto text-center font-weight-bold bg-success text-uppercase" id="txtHead">
                        OFERTAS
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if(\App\Producto::all()->where('rebajado','=','1')->where('activo','=','1')->count()>0)
                                @foreach(\App\Producto::all()->where('rebajado','=','1')->where('activo','=','1') as $p)
                                    <div class="col-md-3" onclick="visualizarProducto({{$p->id}})"
                                         style="cursor:pointer">
                                        <div class="card card-body text-center align-items-center"
                                             style="margin-bottom: 1em;">
                                            <div class="row">
                                                <label id="cronometro{{$p->id}}" class="cronometros" hidden>{{$p->id}}
                                                    *{{$p->fecha_fin_rebaja}}</label>
                                            </div>
                                            <div class="row d-inline-block">
                                                <div class="col"
                                                     style="text-decoration: line-through;display: block">{{$p->precio_anterior}}
                                                    €
                                                </div>
                                                <div class="col font-weight-bold">Ahora:{{$p->precio_venta}}€</div>

                                            </div>
                                            <img class="img-fluid" src={{URL::asset($p->foto)}} th:alt="foto"
                                                 style="height: 230px;width: 200px;"/>
                                        </div>
                                        <div class="card-footer text-center" style="margin-bottom: 3em;">
                                            <a class="card-link font-weight-bold" href="#">{{$p->nombre}}</a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <script type="application/javascript">
                                    $('#txtHead').text("Mejores valorados");
                                </script>
                                @foreach(\App\Producto::all()->where('activo','=','1')->where('valoracion','>','8') as $p)
                                    <div class="col-md-3" onclick="visualizarProducto({{$p->id}})"
                                         style="cursor:pointer;">
                                        <div class="card card-body text-center align-items-center"
                                             style="margin-bottom: 1em;">
                                            <div class="row">
                                                <div class="col font-weight-bold">{{$p->precio_venta}}€</div>
                                            </div>
                                            <img class="img-fluid" src={{URL::asset($p->foto)}} th:alt="foto"
                                                 style="height: 230px;width: 200px;"/>
                                        </div>
                                        <div class="card-footer text-center" style="margin-bottom: 3em;">
                                            <a class="card-link font-weight-bold" href="#">{{$p->nombre}}</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" action="/show" id="formShow">
        @csrf
        <input type="hidden" name="id" id="dato">
    </form>
    <script type="application/javascript">
        $(document).ready(function () {
            var cronos = $('.cronometros');
            for (let i = 0; i < cronos.length; i++) {
                var crono = $('#' + cronos[i].id);
                var txt = crono.text();
                var id = txt.split("*")[0];
                var fecha = txt.split("*")[1];
                mostrarContador(cronos[i].id, id, fecha);
            }
        });

        function visualizarProducto(id) {
            $('#dato').val(id);
            $('#formShow').submit();
        }
    </script>
@endsection
