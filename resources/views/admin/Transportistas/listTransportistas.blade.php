@extends('layouts.app')

@section('content')
    <div class="col-sm-auto" style="margin-top: 5em">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">Listado de Transportistas
                    </div>
                    <div class="card-body">
                        <table class="table table-hover text-center table-responsive-lg">
                            <thead>
                            <tr>
                                <td>id</td>
                                <td>Razon social</td>
                                <td>Precio</td>
                                <td>Duración</td>
                                <td>Creado</td>
                                <td>Modificado</td>
                                <td>Opciones</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\Transportista::all() as $c)
                                <tr>
                                    <td>{{$c->id}}</td>
                                    <td>{{$c->razon_social}}</td>
                                    <td>{{$c->precio}}</td>
                                    <td>{{$c->duracion}}</td>
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
    <form action="/admin/editar/Transportistas" method="post" id="form">
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
