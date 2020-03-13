@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">OFERTAS</div>
                    <div class="card-body">
                        <div class="container-fluid">
                            @foreach(\App\Producto::all() as $p)
                                <div class="card col-sm-3">
                                    <div class="text-center">
                                        <img class="img-fluid" src={{$p->foto}} th:alt="foto"/>
                                    </div>
                                    <div class="card-body descripcion" id="descripcion">
                                        <h6 class="card-title font-weight-bold text-center">{{$separado[0]}}</h6>
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
