@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class=" card card-header w-auto text-center font-weight-bold bg-success"
                     style="margin:3.5em auto 0;padding-top: 1em;text-transform: uppercase">{{$producto->nombre}}</div>
                <div class="card-body bg-dark text-white font-weight-bold" style="margin:0 auto">
                    <div class="row align-items-center">
                        <div class="col">
                            <table class="table table-responsive-xl table-hover table-dark text-white">
                                <tr>
                                    <td class="col-sm-1">Codigo del producto</td>
                                    <td class="col-sm-2">{{$producto->cod_producto}}</td>
                                </tr>
                                <tr>
                                    <td class="col-sm-1">Modelo</td>
                                    <td class="col-sm-2">{{$fabricante->razon_social}} - {{$producto->nombre}}</td>
                                </tr>
                                @for($i=0;$i<count($camposCategoria);$i++)
                                    @if($camposDescripcion[$i]!=null)
                                        <tr>
                                            <td class="col-sm-1">{{$camposCategoria[$i]}}</td>
                                            <td class="col-sm-2 descripcion{{$i}}">{{$camposDescripcion[$i]}}</td>
                                        </tr>
                                    @endif
                                @endfor
                            </table>
                        </div>
                        <div class="col text-center">
                            <label id="temporizador" class="font-weight-normal px-3 py-1"
                                   style="background-color: white;border-radius: 15px" hidden="hidden"></label>
                            <br>
                            <img class="img-responsive" id="foto" src={{$producto->foto}} th:alt="foto"
                                 style="height: 230px;width: 200px;"/>
                            <div style="margin-top: .5em;padding: .5em">
                                <pre class="font-weight-bold"
                                     @if($producto->stock_actual>50)style="color: lightblue;font-size: 15px"
                                     @elseif($producto->stock_actual>10)style="color:lightgreen;font-size: 15px"
                                     @else style="color:red;font-size: 15px" @endif>{{$producto->stock_actual}} Restantes</pre>
                                Precio : {{$producto->precio_venta}} €<br>
                                <div class="row justify-content-center mt-1">
                                    <button class="btn btn-outline-primary col-4 mr-1"
                                            onclick="addCarrito({{$producto}})">Añadir al Carrito
                                    </button>
                                    <input type="number" min="1" max="{{$producto->stock_actual}}" name="cantidad"
                                           class="form-control col-2" value="1">
                                </div>
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
    <script type="application/javascript">
        $(document).ready(function () {
            @if($producto->rebajado=="1")
            mostrarContador("temporizador",@json($producto->id),@json($producto->fecha_fin_rebaja));
            $('#temporizador').removeAttr("hidden");
            @endif
        });

        function addCarrito(producto) {
            debugger
            if (compr(producto)) {
                if (producto.stock_actual > $('input[name="cantidad"]').val() && $('input[name="cantidad"]').val() > 0) {
                    add(producto, $('input[name="cantidad"]').val());
                    console.log("añadido");
                    $('#foto').toggleClass("volar");
                    setTimeout(function () {
                        $('#foto').toggleClass("volar");
                    }, 1500);
                }
            }
        }

        function compr(producto) {
            debugger
            var can = false;
            var articulos = document.getElementById("carritoCentro");
            if (articulos.childNodes.length > 0) {
                var cont = 0;
                for (let item = 0; item < articulos.childElementCount; item++) {
                    if (producto.cod_producto === articulos.childNodes[item].lastChild.textContent) {
                        var cantidad = parseInt(articulos.childNodes[item].childNodes[1].childNodes[0].textContent.split(' ')[1], 10);
                        if (cantidad < producto.stock_actual) {
                            can = true;
                        }
                    } else {
                        cont++;
                    }
                }
                if (cont === articulos.childNodes.length) {
                    can = true;
                }
            } else {
                can = true;
            }
            return can;
        }
    </script>
@endsection
