@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">Ofertar productos</div>
                    <div class="alert alert-success" id="mensaje"></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <div class="input-group">
                                    <input type="search" placeholder="Buscar producto... " id="buscador">
                                    <div
                                        style="position: absolute;margin-left: 160px;margin-top: .15em;padding-bottom:.09em;padding-right: .39em;padding-left:.3em;background-color: rgba(5,92,28,0.31)">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="porcentaje">
                            <div class="col">
                                <label>Introduce el pocentaje a rebajar los productos seleccionados</label>
                                <input type="number" name="porcentaje" min="0" max="100">
                            </div>
                            <div class="col text-right">
                                <div id="seg">

                                </div>
                            </div>
                        </div>
                        <div class="row" id="boton">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-outline-primary" onclick="aplicar()">Aplicar descuentos</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        $(document).ready(function () {
            $('#mensaje').hide();
            $('#porcentaje').hide();
            $('#boton').hide();
            $('#buscador').keyup(function () {
                if ($('#buscador').val().length > 4) {
                    $.ajax({
                        type: 'post',
                        url: "/admin/buscar",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {'texto': $('#buscador').val()},
                        success: function (data) {
                            $('#productos').remove();
                            var div = document.getElementById("seg");
                            var select = document.createElement("select");
                            select.multiple = true;
                            select.id = "productos";
                            div.appendChild(select);
                            for (var i = 0; i < data.length; i++) {
                                var option = document.createElement("option");
                                option.setAttribute("value", data[i]['cod_producto']);
                                option.appendChild(document.createTextNode(data[i]['cod_producto'] + " - " + data[i]['descripcion']));
                                select.appendChild(option);
                            }
                            $('#porcentaje').show();
                            $('#boton').show();
                        },
                        error: function () {
                            console.log("error en la peticion ajax");
                        }
                    });
                } else {
                    $('#productos').hide();
                    $('#porcentaje').hide();
                    $('#boton').hide();
                }
            });
        });

        function aplicar() {
            var porcentaje = $('input[name="porcentaje"]').val();
            var productos = $('select[id="productos"]').val();
            $.ajax({
                type: 'post',
                url: "/admin/aplicar",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'porcentaje': porcentaje, 'productos': productos},
                success: function (data) {
                    $('#mensaje').text(data).show();
                    setTimeout(function () {
                        location.href = "http://localhost:8000/admin";
                    }, 2000);
                },
                error: function () {
                    console.log("error en la peticion ajax");
                }
            });
        }
    </script>
@endsection
