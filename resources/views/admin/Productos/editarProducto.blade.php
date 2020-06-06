@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">{{$producto->nombre}}</div>
                    <div class="card-body">
                        <form method="post" action="{{route('editar')}}" enctype="multipart/form-data" id="formulario">
                            @csrf
                            <table class="table table-light">
                                <tr>
                                    <td>Nombre</td>
                                    <td><input type="text" value="{{$producto->nombre}}" name="nombre">
                                    </td>
                                    <td>*Si no se selecciona ninguna foto se mantendra la anterior</td>
                                </tr>
                                <tr>
                                    <td><label>Codigo del producto</label></td>
                                    <td><input type="text" id="texto" minlength="7" maxlength="10"
                                               @error('codigo') is-invalid @enderror value="{{$producto->cod_producto}}"
                                               name="cod_producto">
                                        @error('codigo')
                                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                                        @enderror
                                        <img id="correcto" src={{URL::asset('/images/correcto.png')}}>
                                    </td>
                                    <td id="msg"><label id="mensaje"></label></td>
                                </tr>
                                <tr>
                                    <td>Precio venta</td>
                                    <td><input type="number" value="{{$producto->precio_venta}}" name="precio_venta">
                                    </td>
                                <tr>
                                    <td>Precio compra</td>
                                    <td><input type="number" value="{{$producto->precio_compra}}" name="precio_compra">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Stock minimo</td>
                                    <td><input type="number" value="{{$producto->stock_minimo}}" name="stock_minimo">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Stock actual</td>
                                    <td><input type="number" value="{{$producto->stock_actual}}" name="stock_actual">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Valoración</td>
                                    <td><input type="text" value="{{$producto->valoracion}}" name="valoracion">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Foto(*)</td>
                                    <td><input type="file" name="foto"></td>
                                </tr>
                                <tr>
                                    <td>Descripcion</td>
                                    <td><a href="#" class="btn btn-primary"
                                           onclick="popUp({{$producto->id_categoria}},{{$producto->id_descripcion}})">Editar
                                            descripción</a>
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" name="categoria" value={{$producto->id_categoria}}>
                            <input type="hidden" name="id_fabricante" value={{$producto->id_fabricante}}>
                            <input type="hidden" name="id_producto" value={{$producto->id}}>
                        </form>
                        <div class="overlay" id="overlay">
                            <div class="popup">
                                <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
                                <br>
                                <div class="contenedor-inputs">
                                    <div id="borrar">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn-outline-primary"
                                    onclick="actualizarDescripcion({{$producto->id_descripcion}});">
                                Actualizar
                            </button>
                            <button onclick="borrar()" class="btn-outline-secondary">Dar de baja el producto</button>
                        </div>
                        <form method="post" action="{{route('borrar')}}" id="formularioBorrar">
                            @csrf
                            <input type="hidden" value="{{$producto->id}}" name="idProducto">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        var array = [];
        $(document).ready(function () {
            //Necesario para actualizar solo el producto y no la descripcion
            popUp({{$producto->id_categoria}},{{$producto->id_descripcion}});
            //Cerrar PopUp
            var close = document.getElementById("btn-cerrar-popup");
            close.onclick = function () {
                document.getElementById("overlay").className = "overlay";
            };
            close.click();
            //Hacer consulta por ajax para ver que campos contiene el producto

            var primerCodigo = $('#texto').val();
            $('#texto').change(function () {
                var data = {'texto': $('#texto').val()};
                var url = "/admin/editar/comprobarCodigo";
                if ($('#texto').val()?.length > 6 && $('#texto').val() !== primerCodigo) {
                    $.ajax({
                        type: 'post',
                        url: url,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: data,
                        success: function (data) {
                            var img = document.getElementById("correcto");
                            if (data === 'existe') {
                                img.setAttribute("src", "{{URL::asset('/images/incorrecto.png')}}");
                                document.getElementById("mensaje").innerText = "El codigo " + $("#texto").val() + " ya existe";
                            } else {
                                img.setAttribute("src", "{{URL::asset('/images/correcto.png')}}");
                                document.getElementById("mensaje").innerText = "";
                            }
                            $('#correcto').show(700);
                        },
                        error: function () {
                            console.log("error en la peticion ajax");
                        }
                    });
                }
            });
        });

        function borrar() {
            if (confirm("¿Estas seguro que desea borrar el producto?")) {
                document.getElementById("formularioBorrar").submit();
            }
        }

        function popUp(id_categoria, id_descripcion) {
            var overlay = document.getElementById("overlay");
            overlay.className = "overlay active";
            var url = "/admin/editar/obtenerCampos";
            var url1 = "/admin/editar/obtenerValores";
            $.ajax({
                type: 'post',
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'id_categoria': id_categoria},
                success: function (data) {
                    array = data;
                    $.ajax({
                        type: 'post',
                        url: url1,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'id_descripcion': id_descripcion},
                        success: function (data1) {
                            renderizar(data.length, data, data1);
                        },
                        error: function () {
                            console.log("error en la peticion ajax");
                        }
                    });
                },
                error: function () {
                    console.log("error en la peticion ajax");
                }
            });
        }

        function renderizar(items, array, datos) {
            var div = document.getElementById("borrar");
            div.remove();
            var borrar = document.createElement("div");
            borrar.id = "borrar";
            for (var i = 0; i < items; i++) {
                //each row
                var divRow = document.createElement("div");
                divRow.className = "row";
                //each text
                var divCol = document.createElement("div");
                divCol.className = "col";
                divCol.textContent = array[i];
                //each input
                var divCol1 = document.createElement("div");
                divCol1.className = "col";
                var input = document.createElement("input");
                input.setAttribute("type", "text");
                input.name = array[i];
                if (datos[i] !== undefined) {
                    input.value = datos[i];
                }
                divCol1.append(input);
                divRow.append(divCol, divCol1);
                borrar.append(divRow);
            }
            $('.contenedor-inputs').append(borrar);
        }

        function actualizarDescripcion(id) {
            var url = '/admin/update/descripcion';
            var data = [];
            for (var i = 0; i < array.length; i++) {
                data.push($("input[name=" + array[i] + "]").val());
            }
            $.ajax({
                type: 'post',
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'array': data, id: id},
                success: function (data) {
                    console.log(data);
                    $('#formulario').submit();
                }
            });
        }
    </script>
@endsection
