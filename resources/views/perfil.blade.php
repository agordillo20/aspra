@extends('layouts.app')

@section('content')
    <div class="alerta alert-danger text-center" id="alerta">
    </div>
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="principal">Mis Datos @if($usuario->foto==null)<img
                        src="{{URL::asset('images/defUser.png')}}"> @else <img
                        src={{URL::asset($usuario->foto)}}> @endif</div>
                <a href="#" onclick="updateFoto()">Cambiar foto de perfil</a>
                <div class="secundario" style="background-image: url({{URL::asset('images/fondo.png')}})">
                    Mi cuenta<br>
                    <pre>{{$usuario->email}}</pre>
                </div>
                <div>
                    <table class="table">
                        <tr>
                            <td>
                                <form action="/updateUser" method="post">
                                    @csrf
                                    <table class="table table-light" id="tableDatosU">
                                        <tr>
                                            <td class="text-center">
                                                <div class="pedidos text-center" onclick="listaPedidos()">
                                                    <b id="bTxt">PEDIDOS</b>
                                                    <p class="listaPedidos">{{$pedidos}}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <label>Nick</label><br>
                                                <input class="form-control" type="text" name="username"
                                                       value="{{$usuario->name}}">
                                                <label>Fecha de nacimiento</label>
                                                <input type="date" class="form-control" name="fecha_nacimiento"
                                                       value="{{$usuario->fecha_nacimiento}}">
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit" class="btn btn-outline-primary">Guardar cambios
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <form action="/updatePassword" method="post">
                                    @csrf
                                    <div class="password">
                                        <p>Cambiar contraseña</p>
                                        <div class="row">
                                            <div class="col">
                                                <label>Contraseña antigua</label>
                                                <input type="password" class="form-control" name="old_password">
                                            </div>
                                            <div class="col">
                                                <label>Contraseña nueva</label>
                                                <input type="password" class="form-control" name="new_password"
                                                       minlength="8">
                                            </div>
                                            <div class="col">
                                                <label>Repetir contraseña</label>
                                                <input type="password" class="form-control" name="repit_password"
                                                       minlength="8">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 1.5em">
                                            <div class="col">
                                                <button type="submit" class="btn btn-outline-primary">Actualizar
                                                    contraseña
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="direcciones">
                                    <p>Direcciones de envio</p>
                                    <table class="table table-responsive-xl ">
                                        <thead>
                                        <tr class="cabecera font-weight-bold">
                                            <td>Pais</td>
                                            <td>Provincia</td>
                                            <td>Localidad</td>
                                            <td>Codigo postal</td>
                                            <td>Domicilio</td>
                                            <td></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Direccion::all()->where('id_usuario','=',Auth::id()) as $direccion)
                                            <tr>
                                                <td>{{$direccion->pais}}</td>
                                                <td>{{$direccion->provincia}}</td>
                                                <td>{{$direccion->localidad}}</td>
                                                <td>{{$direccion->cod_postal}}</td>
                                                <td>{{$direccion->domicilio}}</td>
                                                <td>
                                                    <div class="dropright">
                                                        <button class="btn-outline-primary btn-xs dropdown-toggle"
                                                                type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                             style="width: 10px !important;">
                                                            <button class="dropdown-item" type="button"
                                                                    onclick="borrar({{$direccion->id}})"><i
                                                                    class="far fa-trash-alt"></i> Borrar
                                                            </button>
                                                            <button class="dropdown-item" type="button"
                                                                    onclick="editar({{$direccion->id}})"><i
                                                                    class="fas fa-edit"></i> Modificar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col">
                                            <a class="btn-link" href="#" onclick="popUp()"><i class="fas fa-plus"></i>
                                                Añadir dirección</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--    Añadir direccion--}}
    <div class="direccion hide" id="overlay">
        <div class="centro">
            <div class="row">
                <div class="col text-right">
                    <a id="cerrar" class="cerrar-popup"><i class="fas fa-times" onclick="popUp()"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Pais</label>
                    <input type="text" name="pais" class="form-control" required>
                </div>
                <div class="col">
                    <label>Provincia</label>
                    <input type="text" name="provincia" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Localidad</label>
                    <input type="text" name="localidad" class="form-control" required>
                </div>
                <div class="col">
                    <label>Codigo postal</label>
                    <input type="number" maxlength="5" name="cod_postal" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Domicilio</label>
                    <input type="text" name="domicilio" class="form-control" required>
                </div>
                <div class="col">
                    <button type="button" class="btn-outline-primary" onclick="addDireccion()">Añadir dirección</button>
                </div>
            </div>
        </div>
    </div>

    {{--    Editar direccion--}}
    <div class="Editardireccion hide" id="overlay2">
        <div class="centro">
            <div class="row">
                <div class="col text-right">
                    <a id="cerrar" class="cerrar-popup"><i class="fas fa-times" onclick="editar()"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Pais</label>
                    <input type="text" name="pais1" class="form-control">
                </div>
                <div class="col">
                    <label>Provincia</label>
                    <input type="text" name="provincia1" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Localidad</label>
                    <input type="text" name="localidad1" class="form-control">
                </div>
                <div class="col">
                    <label>Codigo postal</label>
                    <input type="number1" maxlength="5" name="cod_postal1" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Domicilio</label>
                    <input type="text" name="domicilio1" class="form-control">
                </div>
                <div class="col">
                    <button id="editarDireccion" type="button" class="btn-outline-primary"
                            onclick="editDireccion(this.id)">Editar dirección
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{--    Actualizar foto--}}
    <div class="back hide" id="overlay1">
        <div class="centro">
            <div class="row">
                <div class="col text-right">
                    <a id="cerrar" class="cerrar-popup"><i class="fas fa-times" onclick="updateFoto()"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <form action="/foto" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" accept="image/*" name="foto"><br>
                        <button type="submit" class="btn-outline-primary">Actualizar foto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--    Listado de pedidos--}}
    <div class="lista oculto" id="listaPedidos">
        <div class="cen">
            <table class="table">
                <thead>
                <tr id="trd" class="font-weight-bold">
                    <td>Fecha</td>
                    <td id="txtCambiar">Factura</td>
                    <td id="ult"><i class="fas fa-times cerrarH" onclick="listaPedidos()"></i></td>
                </tr>
                </thead>
                <tbody>
                @foreach(\App\Pedido::all()->where('id_usuario','=',\Illuminate\Support\Facades\Auth::id()) as $p)
                    @if(\Illuminate\Support\Facades\Auth::id()=="1")
                        <script type="application/javascript">
                            $('#txtCambiar').text('Nombre');
                            let td = document.createElement("td");
                            td.appendChild(document.createTextNode("Cantidad"));

                            function insertAfter(e, i) {
                                if (e.nextSibling) {
                                    e.parentNode.insertBefore(i, e.nextSibling);
                                } else {
                                    e.parentNode.appendChild(i);
                                }
                            }

                            insertAfter(document.getElementById("txtCambiar"), td);
                            $('#bTxt').text('Historial de repuestos');
                        </script>
                        <tr>
                            <td>{{$p->fecha_pedido}}</td>
                            <td>{{\App\Producto::find(\App\Lineapedidos::all()->where('id_pedido','=',$p->id)->first()->id_producto)->nombre}}</td>
                            <td>{{\App\Lineapedidos::all()->where('id_pedido','=',$p->id)->first()->cantidad}}</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{$p->fecha_pedido}}</td>
                            <td><i id="{{$p->id}}" class="fas fa-file-pdf"
                                   onclick="factura(this.id);console.log(this.id)"></i></td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <form action="/pdf" method="post" id="factura">
        @csrf
        <input type="hidden" name="idFactura">
    </form>
    {{--    javascript y jquery--}}
    <script type="application/javascript">
        $(document).ready(function () {
            if (screen.width < 767) {
                $('#tableDatosU').addClass("w-auto");
            }
            $('#alerta').hide();
        });

        function factura(id) {
            $('input[name="idFactura"]').val(id);
            $('#factura').submit();
        }

        function addDireccion() {
            var pais = $('input[name="pais"]').val();
            var provincia = $('input[name="provincia"]').val();
            var localidad = $('input[name="localidad"]').val();
            var cod_postal = $('input[name="cod_postal"]').val();
            var domicilio = $('input[name="domicilio"]').val();
            if (pais.length > 0 && provincia.length > 0 && localidad.length > 0 && cod_postal.length === 5 && domicilio.length > 0) {
                var url = "/direccion/add";
                $.ajax({
                    type: 'post',
                    url: url,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        pais: pais,
                        provincia: provincia,
                        localidad: localidad,
                        cod_postal: cod_postal,
                        domicilio: domicilio
                    },
                    success: function (data) {
                        $('#alerta').text(data).show();
                        window.setTimeout(function () {
                            popUp();
                            location.reload();
                        }, 3000);
                    },
                    error: function () {
                        console.log("error en la peticion ajax");
                    }
                });
            } else {
                $('#alerta').text("Para añadir una dirección se deben completar todos los campos").show();
                window.setTimeout(function () {
                    $('#alerta').slideUp(300).hide();
                }, 4000)
            }
        }

        function popUp() {
            $('#overlay').toggleClass('hide');
            if (!$('#alerta').hidden) {
                $('#alerta').slideUp(300).hide();
            }
        }

        function updateFoto() {
            $('#overlay1').toggleClass('hide');
        }

        function borrar(id) {
            var respuesta = confirm("¿Esta seguro?");
            if (respuesta) {
                var url = "/direccion/delete";
                $.ajax({
                    type: 'post',
                    url: url,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {id: id},
                    success: function () {
                        location.reload();
                    },
                    error: function () {
                        console.log("error en la peticion ajax");
                    }
                });
            }
        }

        function editar(id) {
            $('#overlay2').toggleClass('hide');
            var url = "/direccion/search";
            $.ajax({
                type: 'post',
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {id: id},
                success: function (data) {
                    $('input[name="pais1"]').val(data['pais']);
                    $('input[name="provincia1"]').val(data['provincia']);
                    $('input[name="localidad1"]').val(data['localidad']);
                    $('input[name="cod_postal1"]').val(data['cod_postal']);
                    $('input[name="domicilio1"]').val(data['domicilio']);
                    document.getElementById("editarDireccion").id = data['id'];
                },
                error: function () {
                    console.log("error en la peticion ajax");
                }
            });
        }

        function editDireccion(id) {
            var url = "direccion/update";
            $.ajax({
                type: 'post',
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    id: id,
                    pais: $('input[name="pais1"]').val(),
                    provincia: $('input[name="provincia1"]').val(),
                    localidad: $('input[name="localidad1"]').val(),
                    cod_postal: $('input[name="cod_postal1"]').val(),
                    domicilio: $('input[name="domicilio1"]').val()
                },
                success: function () {
                    location.reload();
                },
                error: function () {
                    console.log("error en la peticion ajax");
                }
            });
        }

        function listaPedidos() {
            $('#listaPedidos').toggleClass('oculto');
        }
    </script>
@endsection
