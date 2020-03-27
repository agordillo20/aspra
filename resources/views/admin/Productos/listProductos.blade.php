@extends('layouts.app')

@section('content')
    <div class="col-sm-auto" style="margin-top: 5em">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">Listado de productos</div>
                    <div class="card-body">
                        <table class="table table-hover text-center">
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
                            <tbody>
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
    </script>
@endsection
