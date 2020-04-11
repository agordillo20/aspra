@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="background-color: rgba(5,92,28,0.31)">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">OFERTAS</div>
                    <div class="card-body">
                        <div class="row">
                            @foreach(\App\Producto::all()->where('rebajado','=','1') as $p)
                                <div class="col-md-3">
                                    <div class="card card-body text-center align-items-center"
                                         style="margin-bottom: 1em;">
                                        <div class="row">
                                            <div class="col"
                                                 style="text-decoration: line-through">{{$p->precio_anterior}}€
                                            </div>
                                            <div class="col font-weight-bold">Ahora:{{$p->precio_venta}}€</div>

                                        </div>
                                        <img class="img-fluid" src={{$p->foto}} th:alt="foto"
                                             style="height: 230px;width: 200px;"/>
                                    </div>
                                    <div class="card-footer text-center" style="margin-bottom: 3em;">
                                        <a href="/show?id={{$p->id}}" class="font-weight-bold">{{$p->nombre}}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
