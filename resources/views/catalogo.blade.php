@extends('layouts.app')

@section('content')
    <input type="hidden" value="{{$id_categoria}}" id="id_categoria">
    <div class="col">
        <div class="col-10">
            <div class="card" style="background-color: rgba(5,92,28,0.31)">
                <div class="card-header text-center font-weight-bold bg-success titulo">{{$nombre}} disponibles
                    <div class="float-right"> Ordenar por <select id="orden" name="orden"
                                                                  class="custom-select-sm"
                                                                  style="border-radius:5px;font-size: 15px">
                            <option value="Mvalo">Mejores valoradas ⭐</option>
                            <option value="Aasc">Orden alfabético(A-Z)</option>
                            <option value="Adesc">Orden alfabético(Z-A)</option>
                            <option value="Pdesc">Precio más alto</option>
                            <option value="Pasc">Precio más bajo</option>
                        </select></div>
                </div>
                <div class="card-body" id="principal">
                    <div class="row" id="borrar">
                        @foreach($productos as $p)
                            <div class="col-md-3">
                                <div class="card card-body text-center align-items-center"
                                     style="margin-bottom: 1em;">
                                    <div class="row">
                                        @if($p->rebajado)
                                            <div class="col"
                                                 style="text-decoration: line-through">{{$p->precio_anterior}}€
                                            </div>
                                            <div class="col font-weight-bold">Ahora:{{$p->precio_venta}}€</div>
                                        @else
                                            <div class="col font-weight-bold">{{$p->precio_venta}}€</div>
                                        @endif

                                    </div>
                                    <img class="img-fluid" src={{URL::asset($p->foto)}} th:alt="foto"
                                         style="height: 230px;width: 200px;"/>
                                </div>
                                <div class="card-footer text-center" style="margin-bottom: 3em;">
                                    <button class="btn btn-link font-weight-bold"
                                            onclick="visualizarProduct({{$p->id}})">{{$p->nombre}}</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <form method="post" action="/show" id="formShow">
            @csrf
            <input type="hidden" name="id" id="dato">
        </form>
    </div>

    {{--FILTROS--}}
    <div class="col-12 filtros" style="background-color:rgba(255,236,190,0.6)">
        <pre class="font-weight-bold text-center">Filtros disponibles</pre>
        <div class="card filtro">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">Marca</div>
                    <div class="col-1 text-right"><i id="icono_00" class="fas fa-times"
                                                     onclick="abrirCerrar(this.id)"></i></div>
                </div>
            </div>
            <div class="card-body" id="cuerpo00">
                @foreach($marcas as $v)
                    <pre><input type="checkbox" value="{{$v}}" onchange="filtrar(this.id)"
                                id="checkbox{{uniqid()}}">   {{$v}}</pre>
                @endforeach
            </div>
        </div>
        @for($i=0;$i<count($categorias);$i++)
            <div class="card filtro" id="oc{{$i}}">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">{{$categorias[$i]}}</div>
                        <div class="col-1 text-right"><i id="icono_{{$i}}" class="fas fa-times"
                                                         onclick="abrirCerrar(this.id)"></i></div>
                    </div>
                </div>
                <div class="card-body" id="cuerpo{{$i}}">
                    @if(isset($valores[$i]))
                        @foreach($valores[$i] as $v)
                            <pre><input type="checkbox" value="{{$v}}" onchange="filtrar(this.id)"
                                        id="checkbox{{uniqid()}}">   {{$v}}</pre>
                        @endforeach
                    @else
                        <script type="application/javascript">
                            $('#oc' +{{$i}}).hide();
                        </script>
                    @endif
                </div>
            </div>
        @endfor
    </div>
    <div class="txtShow btn-link" onclick="mostrarFiltros()">Mostrar/Ocultar filtros</div>
    <script type="application/javascript">
        $(window).resize(function () {
            if (screen.width > 1200) {
                $('.filtros').slideDown("slow");
            }
        });
        $(document).ready(function () {
            if (screen.width < 767) {
                $('.filtros').slideUp("fast");
            }
            var valor = $('#orden').val();
            var padre = $('#borrar')[0];
            var productos = [];
            for (let i = 0; i < padre.childNodes.length; i++) {
                if (padre.childNodes[i].nodeName !== "#text") {
                    productos.push(padre.childNodes[i].lastChild.firstChild.firstChild.textContent);
                }
            }
            $.ajax({
                type: 'post',
                url: '/ordenar',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'valor': valor, nombresProd: productos},
                success: function (data) {
                    renderizar(data);
                },
                error: function () {
                    console.log("error en la peticion ajax");
                }
            });
            $('#orden').on('change', function () {
                var valor = $(this).val();
                var padre = $('#borrar')[0];
                var productos = [];
                for (let i = 0; i < padre.childNodes.length; i++) {
                    if (padre.childNodes[i].nodeName !== "#text") {
                        productos.push(padre.childNodes[i].lastChild.firstChild.firstChild.textContent);
                    }
                }
                $.ajax({
                    type: 'post',
                    url: '/ordenar',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {'valor': valor, nombresProd: productos},
                    success: function (data) {
                        renderizar(data);
                    },
                    error: function () {
                        console.log("error en la peticion ajax");
                    }
                });
            });
        });

        function visualizarProduct(id) {
            $('#dato').val(id);
            $('#formShow').submit();
        }

        var j = 0;
        var arrayNombres = [];
        $(document).ready(function () {
            j++;
            if (j === 1) {
                for (var i = 0; i < document.getElementsByClassName("card filtro").length; i++) {
                    abrirCerrar("icono_" + i);

                }
                abrirCerrar("icono_00");
            }
        });

        function mostrarFiltros() {
            $('.filtros').slideToggle('slow');
        }

        function abrirCerrar(id) {
            var icono = $('#' + id);
            var cuerpo = $('#cuerpo' + id.split(['_'])[1]);
            if (icono.attr('class') === 'fas fa-plus') {//cerrado
                cuerpo.show(500);
                icono.attr('class', 'fas fa-times');
            } else {//abierto
                cuerpo.hide(500);
                icono.attr('class', 'fas fa-plus');
            }
        }

        function filtrar(id) {
            var item = $('#' + id);
            //array con los nombres
            var clase = item.parent().parent().siblings('div').children().children().html();
            clase = clase.replace(' ', '_');
            console.log(arrayNombres);
            if (arrayNombres.indexOf(clase) === -1) {
                arrayNombres.push(clase);
            }
            var valores = {nombre: arrayNombres, valor: item.val(), add: clase, id_categoria: $('#id_categoria').val()};
            if (item.is(':checked')) {
                //peticion ajax
                var url = "/catalogo/filtrar/productos";
                $.ajax({
                    type: 'post',
                    url: url,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: valores,
                    success: function (data) {
                        renderizar(data);
                    },
                    error: function () {
                        console.log("error en la peticion ajax");
                    }
                });
            } else {
                var url = "/catalogo/filtrar1/productos";
                $.ajax({
                    type: 'post',
                    url: url,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: valores,
                    success: function (data) {
                        arrayNombres = Object.values(data);//Convertir objeto json a array de javascript
                        if (arrayNombres.length === 0) {
                            location.reload();
                        } else {
                            var url = "/catalogo/filtrar/productos";
                            $.ajax({
                                type: 'post',
                                url: url,
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: {
                                    nombre: arrayNombres,
                                    valor: null,
                                    add: clase,
                                    id_categoria: $('#id_categoria').val()
                                },
                                success: function (data) {
                                    renderizar(data);
                                },
                                error: function () {
                                    console.log("error en la peticion ajax");
                                }
                            });
                        }
                    },
                    error: function () {
                        console.log("error en la peticion ajax");
                    }
                });
            }
        }

        function renderizar(data) {
            //Renderizado de la web mediante DOM
            //Eliminar y añadir el div borrar para quitar todos los elementos
            $('#borrar').remove();
            var principal = document.getElementById("principal");
            var remove = document.createElement("div");
            remove.className = "row";
            remove.id = "borrar";
            principal.appendChild(remove);
            data.forEach(function (element) {
                debugger
                var div = document.createElement("div");
                div.className = "col-md-3";
                var div1 = document.createElement("div");
                div1.className = "card card-body text-center align-items-center";
                div1.style.marginBottom = "1em";
                div.appendChild(div1);
                var div2 = document.createElement("div");
                div2.className = "row";
                div1.appendChild(div2);
                if (element.rebajado) {
                    var div3 = document.createElement("div");
                    div3.className = "col";
                    div3.style.textDecoration = "line-through";
                    div3.appendChild(document.createTextNode(element.precio_anterior + "€"));
                    var div4 = document.createElement("div");
                    div4.style.color = "red";
                    div4.className = "col font-weight-bold";
                    div4.appendChild(document.createTextNode("Ahora:" + element.precio_venta + "€"));
                    div2.append(div3, div4);
                } else {
                    var div4 = document.createElement("div");
                    div4.className = "col font-weight-bold";
                    div4.appendChild(document.createTextNode(element.precio_venta + "€"));
                    div2.append(div4);
                }
                var img = document.createElement("img");
                img.className = "img-fluid";
                img.src = element.foto;
                img.alt = "foto";
                img.style.height = "230px";
                img.style.width = "200px";
                div1.appendChild(img);
                var div5 = document.createElement("div");
                div5.className = "card-footer text-center";
                div5.style.marginBottom = "3em";
                var button = document.createElement("button");
                button.onclick = function () {
                    visualizarProduct(element.id);
                };
                button.className = "btn btn-link font-weight-bold";
                button.appendChild(document.createTextNode(element.nombre));
                div5.append(button);
                div.appendChild(div5);
                remove.appendChild(div);
            });
        }
    </script>
@endsection
