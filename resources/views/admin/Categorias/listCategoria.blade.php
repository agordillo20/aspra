@extends('layouts.app')

@section('content')
    <div class="col-sm-auto" style="margin-top: 5em">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">Listado de Categorias</div>
                    <div class="card-body tabla">
                        <table class="table table-hover text-center table-responsive-lg">
                            <thead>
                            <tr>
                                <td>id</td>
                                <td>Nombre</td>
                                <td>Descripcion 1</td>
                                <td>Descripcion 2</td>
                                <td>Descripcion 3</td>
                                <td>Descripcion 4</td>
                                <td>Descripcion 5</td>
                                <td>Descripcion 6</td>
                                <td>Descripcion 7</td>
                                <td>Descripcion 8</td>
                                <td>Descripcion 9</td>
                                <td>Descripcion 10</td>
                                <td>Descripcion 11</td>
                                <td>Descripcion 12</td>
                                <td>Descripcion 13</td>
                                <td>Descripcion 14</td>
                                <td>Descripcion 15</td>
                                <td>Descripcion 16</td>
                                <td>Descripcion 17</td>
                                <td>Otras Caracteristicas</td>
                                <td>Creado</td>
                                <td>Modificado</td>
                                <td>Opciones</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\Categoria::all() as $c)
                                <tr>
                                    <td>{{$c->id}}</td>
                                    <td>{{$c->nombre}}</td>
                                    <td>{{$c->descripcion1}}</td>
                                    <td>{{$c->descripcion2}}</td>
                                    <td>{{$c->descripcion3}}</td>
                                    <td>{{$c->descripcion4}}</td>
                                    <td>{{$c->descripcion5}}</td>
                                    <td>{{$c->descripcion6}}</td>
                                    <td>{{$c->descripcion7}}</td>
                                    <td>{{$c->descripcion8}}</td>
                                    <td>{{$c->descripcion9}}</td>
                                    <td>{{$c->descripcion10}}</td>
                                    <td>{{$c->descripcion11}}</td>
                                    <td>{{$c->descripcion12}}</td>
                                    <td>{{$c->descripcion13}}</td>
                                    <td>{{$c->descripcion14}}</td>
                                    <td>{{$c->descripcion15}}</td>
                                    <td>{{$c->descripcion16}}</td>
                                    <td>{{$c->descripcion17}}</td>
                                    <td>{{$c->otras_caracteristicas}}</td>
                                    <td>@if($c->created_at==null || $c->created_at=="")
                                            admin @else {{$c->created_at}}@endif</td>
                                    <td>@if($c->updated_at==null || $c->updated_at=="")
                                            admin @else {{$c->updated_at}}@endif</td>
                                    <td class="align-middle">
                                        <a href="#" onclick="editar({{$c->id}})"><img
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
    <form action="/admin/editar/categoria" method="post" id="form">
        @csrf
        <input type="hidden" name="id" id="inputHidden">
    </form>
    <script type="application/javascript">
        function editar(id) {
            $('#inputHidden').val(id);
            $('#form').submit();
        }
    </script>
@endsection
