@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">Ofertar productos</div>
                    <div class="card-body">
                        <form method="post" action="{{'/admin/aplicar'}}" id="formu">
                            @csrf
                            <table
                                class="table table-dark text-white table-responsive-xl font-weight-bold text-uppercase"
                                style="width: 100%;overflow-x: auto">
                                <thead>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <input type="search" placeholder="Categoria/codProducto" id="buscador">
                                            <div
                                                style="position: absolute;margin-left: 160px;margin-top: .15em;padding-bottom:.09em;padding-right: .39em;padding-left:.3em;background-color: rgba(5,92,28,0.31)">
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </thead>
                                <tbody id="cuerp">

                                <tr>
                                    <td>
                                        <label>Introduce el pocentaje a rebajar los productos seleccionados</label>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="porcentaje" min="0" max="100">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="fecha_fin">Introduce la fecha y hora que durara la rebaja</label>
                                    </td>
                                    <td>
                                        <input type="date" id="fecha_fin" name="fecha" class="form-control-sm">
                                        <input type="time" id="fecha_fin" name="hora" class="form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="seg">Seleccione el/los producto/s</label>
                                    </td>
                                    <td>
                                        <div id="seg">

                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <button class="btn btn-outline-primary" onclick="applyOfer()">Aplicar descuentos
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        $(document).ready(function () {
            $('#mensaje').hide();
            $('#cuerp').hide();
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
                            select.name = "productos[]";
                            select.id = "productos";
                            div.appendChild(select);
                            for (var i = 0; i < data.length; i++) {
                                var option = document.createElement("option");
                                option.setAttribute("value", data[i]['cod_producto']);
                                option.appendChild(document.createTextNode(data[i]['cod_producto'] + " - " + data[i]['nombre']));
                                select.appendChild(option);
                            }
                            $('#cuerp').show();
                        },
                        error: function () {
                            console.log("error en la peticion ajax");
                        }
                    });
                } else {
                    $('#productos').hide();
                    $('#cuerp').hide();
                }
            });
        });

        function applyOfer() {
            $('#formu').submit();
        }

        function aplicar() {
            var porcentaje = $('input[name="porcentaje"]').val();
            var productos = $('select[id="productos"]').val();
            var fecha = $('input[name=fecha]').val();
            var hora = $('input[name=hora]').val();
            $.ajax({
                type: 'post',
                url: "/admin/aplicar",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'porcentaje': porcentaje, 'productos': productos, 'fecha': fecha, 'hora': hora},
                success: function (data) {
                    $('#mensaje').text(data).show();
                },
                error: function () {
                    console.log("error en la peticion ajax");
                }
            });
        }
    </script>
@endsection
