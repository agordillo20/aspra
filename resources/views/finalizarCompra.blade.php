@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row mx-1 justify-content-center">
            <div class="col contenedor" id="prodC">
                <strong>({{$productos}})</strong> Articulos en el carrito
                <div class="productos">
                    <table class="table table-responsive-lg table-hover listaCompra">
                        <thead></thead>
                        <tbody>
                        @php
                            $total=0;
                            $c=0;
                        @endphp
                        @foreach($carrito as $c)
                            @php
                                $total+=$c[1]['precio_venta']*$c[0];
                            @endphp
                            <tr>
                                <td><img src="{{$c[1]['foto']}}" width="80px" height="100px" class="img-responsive">
                                </td>
                                <td>
                                    <pre>{{\App\Fabricante::find($c[1]['id_fabricante'])->razon_social}} - {{$c[1]['nombre']}}</pre>
                                </td>
                                <td>
                                    <div class="numbers">
                                        <i class="fas fa-plus" onclick="more({{json_encode($c[1])}})"></i><br>
                                        <div style="background-color: white"><input type="text" id="contador"
                                                                                    value="{{$c[0]}}"
                                                                                    maxlength="3" onchange="comprobar()"
                                                                                    class="text-center"></div>
                                        <i class="fas fa-minus" onclick="less({{json_encode($c[1])}})"></i>
                                    </div>
                                </td>
                                <td>{{number_format($c[1]['precio_venta'],2)}}€</td>
                                <td>{{number_format($c[0]*$c[1]['precio_venta'],2)}}€</td>
                                @php($producto=0)
                                <td id="{{$c[0]}}" style="display: block" onclick="del({{json_encode($c[1])}})"><i
                                        class="fas fa-trash"></i></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row m-1 justify-content-center">
            <div class="col finalizarCompra" id="finalizarC">
                <div class="row pt-2 bg-primary">
                </div>
                <div class="row mx-3 mt-2" style="height: 35%">
                    <pre>(*)Si el pedido es inferior a 40€, se aplicaran costes adicionales<br/> de transporte.</pre>
                </div>
                <div class="row my-1 " style="height: 35%">
                    <div class="col-12 mt-3 mx-3">
                        <div class="row">
                            <div class="col-7">Base imponible:</div>
                            <div class="col-2 text-right">{{number_format($total,2)}}€</div>
                        </div>
                        <div class="row">
                            <div class="col-7">IVA:</div>
                            <div class="col-2 text-right">{{number_format($total*0.21,2)}}€</div>
                        </div>
                        <div class="row">
                            <div class="col-7">Total:</div>
                            <div class="col-2 text-right">{{number_format($total*1.21,2)}}€</div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5 py-1 align-items-end" style="height: 23%;margin-bottom: 1em">
                    <div class="col text-center">
                        <button class="btn btn-outline-primary" onclick="comprobarC()">Finalizar pedido</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="opciones hide" id="direccion">
        <div class="opcionesCentro">
            <div class="row justify-content-end mr-3 mt-2"><i class="fas fa-times" onclick="mostrarOpciones()"></i>
            </div>
            <form action="/payment" method="post" id="form">
                @csrf
                <div class="row mt-2 mx-2">
                    <div class="col">
                        <label for="direccion">Dirección de envio</label>
                        <select name="direccion" required class="custom-select">
                            @foreach(\App\Direccion::all()->where('id_usuario','=',\Illuminate\Support\Facades\Auth::id()) as $d)
                                <option value="{{$d['domicilio']}}">{{$d['domicilio']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="transportista">Método de envio</label>
                        <select name="transportista" required class="custom-select">
                            @foreach(\App\Transportista::all() as $t)
                                <option value="{{$t->razon_social}}">{{$t->razon_social}} - {{$t->precio}}€</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row justify-content-center mt-5">
                    <button class="btn btn-outline-primary mr-2" type="submit"><i class="fab fa-cc-paypal"
                                                                                  style="font-size: 40px"></i></button>
                    <button class="btn-outline-primary" onclick="contrareembolso()">Contrareembolso</button>
                </div>
            </form>

        </div>
    </div>
    <script type="application/javascript">
        $(document).ready(function () {
            if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                var container1 = $('#prodC');
                var container2 = $('#finalizarC');
                container1.removeClass("col");
                container2.removeClass("col");
                container1.addClass("col-10");
                container2.addClass("col-7");
                container2.addClass("mt-5");
            }
        });

        function comprobarC() {
            $.ajax({
                type: "post",
                url: "/carrito/user/comprobar",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data === "") {
                        mostrarOpciones();
                    } else {
                        if (confirm(data)) {
                            if (data === "Se debe iniciar sesion para comprar") {
                                location.href = "/login";
                            } else {
                                location.href = "/perfil";
                            }
                        }
                    }
                }
            });
        }

        function del(producto) {
            $.ajax({
                type: "post",
                url: "/carrito/finalizar/delete",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {"producto": producto},
                success: function () {
                    location.reload();
                }
            });
        }

        $(document).ready(function () {
            $('#car').hide();
        });

        function comprobar() {
            if ($('#contador').val() === "") {
                $('#contador').val(1);
            }
        }

        function more(producto) {
            var contador = $('#contador');
            if (contador.val() < 999) {
                contador.val(parseInt(contador.val(), 10) + 1);
                add(producto, 1);
                setTimeout(function () {
                    location.reload();
                }, 100);
            }
        }

        function less(producto) {
            var contador = $('#contador');
            if (contador.val() > 1) {
                contador.val(parseInt(contador.val(), 10) - 1);
                quitar(0, producto);
                setTimeout(function () {
                    location.reload();
                }, 100);
            }
        }

        function mostrarOpciones() {
            $('#direccion').toggleClass('hide');
        }

        function contrareembolso() {
            $('#form').attr("action", "/contrareembolso").submit();
        }
    </script>
@endsection
