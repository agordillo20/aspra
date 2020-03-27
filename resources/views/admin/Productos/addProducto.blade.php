@extends('layouts.app')

@section('content')
    <div class="col-sm-auto" style="margin-top: 5em">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">NUEVO PRODUCTO</div>
                    <div class="card-body bg-primary text-white">
                        <form method="POST" enctype="multipart/form-data" action="{{'/admin/add/producto'}}">
                            @csrf
                            <div class="form-group row">
                                <label for="Categoria"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }}</label>
                                <div class="col-md-2">
                                    <select name="categoria">
                                        @foreach(\App\Categoria::all() as $c)
                                            <option>{{$c->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="Categoria"
                                       class="col-md-2 col-form-label text-md-right">{{ __('Fabricante') }}</label>
                                <div class="col-md-1">
                                    <select name="fabricante">
                                        @foreach(\App\Fabricante::all() as $f)
                                            <option>{{$f->razon_social}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombre"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                                <input id="nombre" type="text"
                                       class="form-control col-2 @error('nombre') is-invalid @enderror"
                                       name="nombre"
                                       required autocomplete="nombre">

                                @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="text-center col-4">
                                    <a href="#" class="btn btn-secondary" onclick="popUp()">Añadir descripcion</a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="precio_compra"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Precio compra') }}</label>
                                <div class="col-md-2">
                                    <input id="precio_compra" type="number"
                                           class="form-control @error('precio_compra') is-invalid @enderror"
                                           name="precio_compra"
                                           required autocomplete="precio_compra">

                                    @error('precio_compra')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <label for="precio_venta"
                                       class="col-md-2 col-form-label text-md-right">{{ __('Precio venta') }}</label>
                                <div class="col-md-2">
                                    <input id="precio_venta" type="number"
                                           class="form-control @error('precio_venta') is-invalid @enderror"
                                           name="precio_venta"
                                           required autocomplete="precio_venta">

                                    @error('precio_venta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stock_minimo"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Stock minimo') }}</label>
                                <div class="col-md-2">
                                    <input id="stock_minimo" type="number"
                                           class="form-control @error('stock_minimo') is-invalid @enderror"
                                           name="stock_minimo"
                                           required autocomplete="stock_minimo">

                                    @error('stock_minimo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <label for="stock_actual"
                                       class="col-md-2 col-form-label text-md-right">{{ __('Stock actual') }}</label>
                                <div class="col-md-2">
                                    <input id="stock_actual" type="number"
                                           class="form-control @error('stock_actual') is-invalid @enderror"
                                           name="stock_actual"
                                           required autocomplete="stock_actual">

                                    @error('stock_actual')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">

                            </div>
                            <div class="form-group row">
                                <label for="foto" class="col-md-2 col-form-label text-md-left">{{ __('Foto') }}</label>
                                <div class="col-md-12">
                                    <input id="foto" type="file"
                                           class="form-control @error('foto') is-invalid @enderror" name="foto"
                                           required autocomplete="foto">

                                    @error('foto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-6">
                                    <button id="btn-submit" type="submit" class="btn bg-dark text-white"
                                            onclick="enviar()" disabled>
                                        {{ __('Añadir') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script type="application/javascript">
        var array = [];
        $(document).ready(function () {
            //Validacion de campos rellenos
            var correcto = false;
            var a = 0;
            $('#nombre').on('change', function () {
                if ($('#nombre').val().length >= 1) {
                    a++;
                } else {
                    a--;
                }
                console.log(a);
            });
            $('#precio_compra').on('change', function () {
                if ($('#precio_compra').val().length >= 1) {
                    a++;
                } else {
                    a--;
                }
                console.log(a);
            });
            $('#precio_venta').on('change', function () {
                if ($('#precio_venta').val().length >= 1) {
                    a++;
                } else {
                    a--;
                }
                console.log(a);
            });
            $('#stock_actual').on('change', function () {
                if ($('#stock_actual').val().length >= 1) {
                    a++;
                } else {
                    a--;
                }
                console.log(a);
            });
            $('#stock_minimo').on('change', function () {
                if ($('#stock_minimo').val().length >= 1) {
                    a++;
                } else {
                    a--;
                }
                console.log(a);
            });
            $('#foto').on('change', function () {
                if ($('#foto').val().length >= 1) {
                    a++;
                } else {
                    a--;
                }
                console.log(a);
                if (a === 6) {
                    $('#btn-submit').removeAttr("disabled");
                }
            });
            //Fin de la validacion
            array = ['pantalla', 'sistema_operativo', 'memoria_ram', 'almacenamiento_interno', 'almacenamiento_externo', 'camara_frontal', 'camara_trasera', 'procesador', 'bateria', 'conectividad', 'otras_caracteristicas'];
            var close = document.getElementById("btn-cerrar-popup");
            close.onclick = function () {
                document.getElementById("overlay").className = "overlay";
            };
            renderizar(11, array);
            $('select[name="categoria"]').on('change', function () {
                var n = 0;
                switch ($('select[name="categoria"]').val()) {
                    case "moviles":
                        array = ['pantalla', 'sistema_operativo', 'memoria_ram', 'almacenamiento_interno', 'almacenamiento_externo', 'camara_frontal', 'camara_trasera', 'procesador', 'bateria', 'conectividad'];
                        n = 11;
                        break;
                    case "sobre mesa":
                        array = ['placa_base', 'caja', 'fuente_alimentacion', 'procesador', 'disco_duro', 'memoria_ram', 'grafica', 'conexiones_delanteras', 'conexiones_traseras', 'tarjeta_sonido', 'tarjeta_red', 'sistema_operativo', 'dimensiones'];
                        n = 14;
                        break;
                    case "portatiles":
                        array = ['procesador', 'memoria_ram', 'almacenamiento', 'conectividad', 'camara', 'microfono', 'bateria', 'sistema_operativo', 'dimensiones', 'peso', 'color', 'grafica', 'display', 'unidad_optica', 'sonido', 'conexiones', 'teclado'];
                        n = 18;
                        break;
                    case "monitores":
                        array = ['puertos', 'peso', 'dimensiones', 'multimedia', 'pantalla'];
                        n = 6;
                        break;
                    case "consolas":
                        array = ['caracteristicas_generales', 'procesador', 'memoria_ram', 'almacenamiento_interno', 'entrada_salida', 'bluetooth', 'mando', 'conectividad'];
                        n = 9;
                        break;
                }
                array.push('otras_caracteristicas');
                renderizar(n, array);
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
            $('.contenedor-inputs').append(borrar);
        }

        function popUp() {
            var overlay = document.getElementById("overlay");
            overlay.className = "overlay active";
        }

        function enviar() {
            var url = '{{route('descripcion')}}';
            var data = [];
            for (var i = 0; i < array.length; i++) {
                data.push($("input[name=" + array[i] + "]").val());
            }
            $.ajax({
                type: 'post',
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'array': JSON.stringify(data)},
                success: function (data) {

                },
                error: function () {
                    console.log("error en la peticion ajax");
                }
            });
        }
    </script>
@endsection
