@extends('layouts.app')

@section('content')
    <div class="col-sm-auto" style="margin-top: 5em">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">NUEVO PRODUCTO</div>
                    <div class="card-body bg-primary text-white">
                        <form method="POST" enctype="multipart/form-data" action="{{'/admin/add/producto'}}"
                              id="formulario">
                            @csrf
                            <table
                                class="table table-responsive-lg text-white font-weight-bold text-uppercase table-hover">
                                <tr>
                                    <td>
                                        <label for="Categoria">{{ __('Categoria') }}</label>
                                    </td>
                                    <td>
                                        <select name="categoria" class="custom-select">
                                            @foreach(\App\Categoria::all() as $c)
                                                <option>{{$c->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Categoria">{{ __('Fabricante') }}</label>
                                    </td>
                                    <td>
                                        <select name="fabricante" class="custom-select">
                                            @foreach(\App\Fabricante::all() as $f)
                                                <option>{{$f->razon_social}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="nombre">{{ __('Nombre') }}</label>
                                    </td>
                                    <td>
                                        <input id="nombre" type="text"
                                               class="form-control @error('nombre') is-invalid @enderror"
                                               name="nombre"
                                               required autocomplete="nombre">

                                        @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="precio_compra">{{ __('Precio compra') }}</label>
                                    </td>
                                    <td>
                                        <input id="precio_compra" type="number"
                                               class="form-control @error('precio_compra') is-invalid @enderror"
                                               name="precio_compra"
                                               required autocomplete="precio_compra">

                                        @error('precio_compra')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="precio_venta">{{ __('Precio venta') }}</label>
                                    </td>
                                    <td>
                                        <input id="precio_venta" type="number"
                                               class="form-control @error('precio_venta') is-invalid @enderror"
                                               name="precio_venta"
                                               required autocomplete="precio_venta">

                                        @error('precio_venta')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="valoracion">{{ __('Valoración') }}</label>
                                    </td>
                                    <td>
                                        <input id="valoracion" type="text"
                                               class="form-control @error('valoracion') is-invalid @enderror"
                                               name="valoracion"
                                               required autocomplete="valoracion" min="0" max="10">

                                        @error('valoracion')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="stock_minimo">{{ __('Stock minimo') }}</label>
                                    </td>
                                    <td>
                                        <input id="stock_minimo" type="number"
                                               class="form-control @error('stock_minimo') is-invalid @enderror"
                                               name="stock_minimo"
                                               required autocomplete="stock_minimo">

                                        @error('stock_minimo')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="stock_actual">{{ __('Stock actual') }}</label>
                                    </td>
                                    <td>
                                        <input id="stock_actual" type="number"
                                               class="form-control @error('stock_actual') is-invalid @enderror"
                                               name="stock_actual"
                                               required autocomplete="stock_actual">

                                        @error('stock_actual')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="foto">{{ __('Foto') }}</label>
                                    </td>
                                    <td>
                                        <input id="foto" type="file" accept="image/*"
                                               class="form-control @error('foto') is-invalid @enderror" name="foto"
                                               required autocomplete="foto">

                                        @error('foto')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <a href="#" class="btn btn-secondary float-right" onclick="popUp()">Añadir
                                    descripcion</a>
                                <button class="btn bg-dark text-white float-left"
                                        onclick="enviar()">
                                    {{ __('Añadir') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="overlay" id="overlay">
        <div class="popup">
            <a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
            <br>
            <div id="contenedor-inputs">
                <div id="borrar">

                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        var array = [];
        $(document).ready(function () {
            array = ['pantalla', 'sistema_operativo', 'memoria_ram', 'almacenamiento_interno', 'almacenamiento_externo', 'camara_frontal', 'camara_trasera', 'procesador', 'bateria', 'conectividad'];
            var close = document.getElementById("btn-cerrar-popup");
            close.onclick = function () {
                document.getElementById("overlay").className = "overlay";
            };
            renderizar(10, array);
        });
        $('select[name="categoria"]').on('change', function () {
            $.ajax({
                type: 'post',
                url: '/categorias/nombres',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'categoria': JSON.stringify($('select[name="categoria"]').val())},
                success: function (data) {
                    renderizar(data.length, data);
                },
            });
        });


        function renderizar(items, array) {
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
                divCol1.append(input);
                divRow.append(divCol, divCol1);
                borrar.append(divRow);
            }
            document.getElementById("contenedor-inputs").appendChild(borrar);
        }

        function popUp() {
            var overlay = document.getElementById("overlay");
            overlay.className = "overlay active";
        }

        function enviar() {
            var url = '/admin/add/descripcion';
            var data = [];
            for (var i = 0; i < array.length; i++) {
                data.push($("input[name=" + array[i] + "]").val());
            }
            $.ajax({
                type: 'post',
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'array': JSON.stringify(data)},
                success: function () {
                    $('#formulario').submit();
                },
            });
        }
    </script>
@endsection
