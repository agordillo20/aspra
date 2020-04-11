@extends('layouts.app')

@section('content')
    <div class="alerta alert-danger text-center" id="alerta">
    </div>
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="principal">Mis Datos @if($usuario->foto==null)<img
                        src="{{URL::asset('images/defUser.png')}}"> @else <img src="{{$usuario->foto}}"> @endif</div>
                <a href="#" onclick="updateFoto()">Cambiar foto de perfil</a>
                <div class="secundario" style="background-image: url({{URL::asset('images/fondo.png')}})">
                    Mi cuenta<br>
                    <pre>{{$usuario->email}}</pre>
                </div>
                <div>
                    <table class="table table-hover">
                        <tr>
                            <td>
                                <form action="/updateUser" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="pedidos text-center">
                                                PEDIDOS
                                                <p>{{$pedidos}}</p>
                                                {{--                                                TODO:Posible mejora,implementar listado con los pedidos realizados al hacer click en el numero de pedidos--}}
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label>Nick</label><br>
                                            <input class="form-control" type="text" name="username"
                                                   value="{{$usuario->name}}" style="width: min-content">
                                        </div>
                                        <div class="col">
                                            <label style="margin-left: -3em">Fecha de nacimiento</label>
                                            <input type="date" class="form-control" name="fecha_nacimiento"
                                                   style="margin-left: -3em" value="{{$usuario->fecha_nacimiento}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
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
                                            <div class="col text-right">
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
                                    <div class="cabecera row font-weight-bold">
                                        <div class="col-2">
                                            <label>Pais</label>
                                        </div>
                                        <div class="col-2">
                                            <label>Provincia</label>
                                        </div>
                                        <div class="col-2">
                                            <label>Localidad</label>
                                        </div>
                                        <div class="col-2">
                                            <label>Codigo postal</label>
                                        </div>
                                        <div class="col">
                                            <label>Domicilio</label>
                                        </div>
                                    </div>
                                    @foreach(\App\Direccion::all()->where('id_usuario','=',Auth::id()) as $direccion)
                                        <div class="row">
                                            <div class="col-2">
                                                <label>{{$direccion->pais}}</label>
                                            </div>
                                            <div class="col-2">
                                                <label>{{$direccion->provincia}}</label>
                                            </div>
                                            <div class="col-2">
                                                <label>{{$direccion->localidad}}</label>
                                            </div>
                                            <div class="col-2">
                                                <label>{{$direccion->cod_postal}}</label>
                                            </div>
                                            <div class="col-1">
                                                <label>{{$direccion->domicilio}}</label>
                                            </div>
                                            <div class="col">
                                                <div class="dropright">
                                                    <button class="btn-outline-primary btn-xs dropdown-toggle"
                                                            type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                         style="width: 10px !important;">
                                                        <button class="dropdown-item" type="button"
                                                                onclick="borrar({{$direccion->id}})"><i
                                                                class="far fa-trash-alt"></i></button>
                                                        <button class="dropdown-item" type="button"
                                                                onclick="editar({{$direccion->id}})"><i
                                                                class="fas fa-edit"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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

    {{--    javascript y jquery--}}
    <script type="application/javascript">
        $(document).ready(function () {
            $('#alerta').hide();
        });

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
    </script>
@endsection
