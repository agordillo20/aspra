@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">Editar Categoria</div>
                    <form method="post" action="/admin/update/categoria" id="formUpdate">
                        @csrf
                        <div class="card-body bg-primary">
                            <table class="table table-responsive-xl text-white font-weight-bold">
                                <tr>
                                    <td>
                                        <label>Nombre*</label>
                                    </td>
                                    <td>
                                        <input type="text" name="nombre" value="{{$categoria->nombre}}"
                                               class="form-control"
                                               required>
                                    </td>
                                </tr>
                                @foreach($campos as $c)
                                    @foreach($c as $v)
                                        @if($v!="nombre" && $v!="id" && $v!="created_at" && $v!="updated_at")
                                            <tr>
                                                <td><label>{{$v}}</label></td>
                                                <td><input type="text" name="{{$v}}" value="{{$categoria->$v}}"
                                                           class="form-control"></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </table>
                            <input type="hidden" value="{{$categoria->id}}" name="id">
                        </div>
                    </form>
                    <button class="btn btn-outline-primary" onclick="actualizar()">Actualizar</button>
                    <button class="btn btn-outline-secondary" onclick="borrar()">Borrar</button>
                </div>
            </div>
        </div>
    </div>
    <form method="post" action="/admin/delete/categoria" id="formularioBorrar">
        @csrf
        <input type="hidden" value="{{$categoria->id}}" name="idCategoria">
    </form>
    <script type="application/javascript">
        function borrar() {
            if (confirm("¿Estas seguro que desea borrar la categoria?")) {
                document.getElementById("formularioBorrar").submit();
            }
        }

        function actualizar() {
            document.getElementById("formUpdate").submit();
        }
    </script>
@endsection
