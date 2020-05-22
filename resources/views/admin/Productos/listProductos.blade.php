@extends('layouts.app')

@section('content')
    <div class="col-sm-auto" style="margin-top: 5em">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="overflow-x: auto">
                    <div class="card-header w-auto text-center font-weight-bold bg-success"><i
                            class="fas fa-eye float-left" id="icon" onclick="baja()"> Mostrar productos dados de
                            baja</i>Listado de productos
                    </div>
                    <div class="card-body">
                        <table class="table table-hover text-center table-responsive-lg">
                            <thead>
                            <tr>
                                <td>id</td>
                                <td>Nombre</td>
                                <td>id categoria</td>
                                <td>id fabricante</td>
                                <td>id descripción</td>
                                <td>código del producto</td>
                                <td>precio venta</td>
                                <td>precio compra</td>
                                <td>stock actual</td>
                                <td>stock minimo</td>
                                <td>rebajado</td>
                                <td>precio anterior</td>
                                <td>creado</td>
                                <td>actualizado</td>
                                <td>foto</td>
                                <td>Opciones</td>
                            </tr>
                            </thead>
                            <tbody id="tb">
                            @foreach($productos as $p)
                                <tr>
                                    <td>{{$p->id}}</td>
                                    <td>{{$p->nombre}}</td>
                                    <td><a id={{$p->id_categoria}} href="#"
                                           onclick="mostrarCategoria(this.id)">{{$p->id_categoria}}</a></td>
                                    <td><a id={{$p->id_fabricante}} href="#"
                                           onclick="mostrarFabricante(this.id)">{{$p->id_fabricante}}</a></td>
                                    <td><a id={{$p->id_descripcion}} href="#"
                                           onclick="mostrarDescripcion(this.id)">{{$p->id_descripcion}}</a></td>
                                    <td>{{$p->cod_producto}}</td>
                                    <td>{{$p->precio_venta}}</td>
                                    <td>{{$p->precio_compra}}</td>
                                    <td>{{$p->stock_actual}}</td>
                                    <td>{{$p->stock_minimo}}</td>
                                    <td>@if($p->rebajado==0)no @else si @endif</td>
                                    <td>{{$p->precio_anterior}}</td>
                                    <td>{{$p->created_at}}</td>
                                    <td>{{$p->updated_at}}</td>
                                    <td><img src={{$p->foto}} alt="foto" style="height: 70px;width: 70px"></td>
                                    <td class="align-middle">
                                        <a href="#" onclick="editar({{$p->id}})"><img
                                                src={{URL::asset('images/editar.png')}} alt="editar"></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{route('actualizar')}}" method="post" id="form">
        @csrf
        <input type="hidden" name="id" id="inputHidden">
    </form>
    <script type="application/javascript">
        function mostrarCategoria(id) {
            var url = "/admin/verCategoria";
            $.ajax({
                type: 'post',
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'id': id},
                success: function (data) {
                    alert("La categoria es " + data[0]['nombre']);
                },
                error: function () {
                    console.log("error en la peticion ajax");
                }
            });
        }

        function mostrarFabricante(id) {
            var url = "/admin/verFabricante";
            $.ajax({
                type: 'post',
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'id': id},
                success: function (data) {
                    alert("El fabricante es " + data[0]['razon_social']);
                },
                error: function () {
                    console.log("error en la peticion ajax");
                }
            });
        }

        function mostrarDescripcion(id) {
            var url = "/admin/verDescripcion";
            $.ajax({
                type: 'post',
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'id': id},
                success: function (data) {
                    var longitud = data[data.length - 1];
                    var datos = data[longitud];
                    var cadena = "";
                    for (var i = 0; i < longitud; i++) {
                        cadena += datos[i] + ":\t" + data[i] + "\n ";
                    }
                    if (cadena === "") {
                        cadena = "no hay descripcion disponible";
                    }
                    alert(cadena);
                },
                error: function () {
                    console.log("error en la peticion ajax");
                }
            });
        }

        function editar(id) {
            var url = "/admin/editar/producto";
            $.ajax({
                type: 'post',
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'id': id},
                success: function (data) {
                    $('#inputHidden').val(data);
                    $('#form').submit();
                },
                error: function () {
                    console.log("error en la peticion ajax");
                }
            });
        }

        function baja() {
            var url = "/admin/list/productos/baja";
            $.ajax({
                type: 'post',
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    document.getElementById("icon").className = "fas fa-eye-slash float-left";
                    document.getElementById("icon").textContent = " Ocultar productos dados de baja";
                    document.getElementById("icon").onclick = function () {
                        document.getElementById("icon").className = "fas fa-eye float-left";
                        document.getElementById("icon").textContent = " Mostrar productos dados de baja";
                        document.getElementById("icon").onclick = function () {
                            baja();
                        };
                        $(".trBajas").remove();
                    };
                    renderBajas(data);
                },
                error: function () {
                    console.log("error en la peticion ajax");
                }
            });
        }

        function renderBajas(productos) {
            var tbody = document.getElementById("tb");
            productos.forEach(function (l) {
                var tr = document.createElement("tr");
                tr.style.backgroundColor = "rgba(34,34,34,0.2)";
                tr.className = "trBajas";
                var td = document.createElement("td");
                td.appendChild(document.createTextNode(l.id));
                var td1 = document.createElement("td");
                td1.appendChild(document.createTextNode(l.nombre));

                var td2 = document.createElement("td");
                var a = document.createElement("a");
                a.id = l.id_categoria;
                a.href = "#";
                a.onclick = function () {
                    mostrarCategoria(this.id);
                };
                a.appendChild(document.createTextNode(l.id_categoria));
                td2.appendChild(a);

                var td3 = document.createElement("td");
                var a1 = document.createElement("a");
                a1.id = l.id_fabricante;
                a1.href = "#";
                a1.onclick = function () {
                    mostrarFabricante(this.id);
                };
                a1.appendChild(document.createTextNode(l.id_fabricante));
                td3.appendChild(a1);

                var td4 = document.createElement("td");
                var a2 = document.createElement("a");
                a2.id = l.id_descripcion;
                a2.href = "#";
                a2.onclick = function () {
                    mostrarDescripcion(this.id);
                };
                a2.appendChild(document.createTextNode(l.id_descripcion));
                td4.appendChild(a2);

                var td5 = document.createElement("td");
                td5.appendChild(document.createTextNode(l.cod_producto));
                var td6 = document.createElement("td");
                td6.appendChild(document.createTextNode(l.precio_venta));
                var td7 = document.createElement("td");
                td7.appendChild(document.createTextNode(l.precio_compra));
                var td8 = document.createElement("td");
                td8.appendChild(document.createTextNode(l.stock_actual));
                var td9 = document.createElement("td");
                td9.appendChild(document.createTextNode(l.stock_minimo));
                var td10 = document.createElement("td");
                if (l.rebajado === 0) {
                    td10.appendChild(document.createTextNode("no"));
                } else {
                    td10.appendChild(document.createTextNode("si"));
                }
                var td11 = document.createElement("td");
                td11.appendChild(document.createTextNode(l.precio_anterior));
                var td12 = document.createElement("td");
                td12.appendChild(document.createTextNode(l.created_at));
                var td13 = document.createElement("td");
                td13.appendChild(document.createTextNode(l.updated_at));
                var td14 = document.createElement("td");
                var img = document.createElement("img");
                img.src = l.foto;
                img.alt = "nada";
                img.style.width = "70px";
                img.style.height = "70px";
                td14.appendChild(img);
                tr.append(td, td1, td2, td3, td4, td5, td6, td7, td8, td9, td10, td11, td12, td13, td14);
                tbody.appendChild(tr);
            });
        }
    </script>
@endsection
