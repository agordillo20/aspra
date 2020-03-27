@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="background-color: rgba(5,92,28,0.31)">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">OFERTAS</div>
                    <div class="card-body">
                        <div class="row">
                            <?php $i = 0; ?>
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
                                        <a id={{$p->id}} href="#" class="font-weight-bold"
                                           onclick="enviar(this.id)">{{$separado[$i]}}</a>
                                        <form id="show-form" action="{{route('ConsultaProducto')}}" method="post"
                                              style="display: none;">
                                            @csrf
                                            <input type="hidden" name="id" id="hiden">
                                        </form>
                                    </div>
                                    <?php $i += 1; ?>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        function enviar(id) {
            event.preventDefault();
            document.getElementById('hiden').setAttribute('value', id);
            document.getElementById('show-form').submit();
        }
    </script>
@endsection
