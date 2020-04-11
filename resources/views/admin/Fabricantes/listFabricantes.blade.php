@extends('layouts.app')

@section('content')
    <div class="col-sm-auto" style="margin-top: 5em">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">Listado de fabricantes</div>
                    <div class="card-body">
                        <table class="table table-hover text-center">
                            <thead>
                            <tr>
                                <td>id</td>
                                <td>Razon social</td>
                                <td>Descripcion</td>
                                <td>Origen</td>
                                <td>Creado</td>
                                <td>Modificado</td>
                                <td>Opciones</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\Fabricante::all() as $p)
                                <tr>
                                    <td>{{$p->id}}</td>
                                    <td>{{$p->razon_social}}</td>
                                    <td>{{$p->descripcion}}</td>
                                    <td>{{$p->origen}}</td>
                                    <td>@if($p->created_at==null || $p->created_at=="")
                                            admin @else {{$p->created_at}}@endif</td>
                                    <td>@if($p->updated_at==null || $p->updated_at=="")
                                            admin @else {{$p->updated_at}}@endif</td>
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
    <form action="/admin/editar/fabricante" method="post" id="form">
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
