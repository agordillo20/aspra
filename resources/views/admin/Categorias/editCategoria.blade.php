@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">Editar Categoria</div>
                    <form method="post" action="/admin/update/categoria" id="formUpdate">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" value="{{$categoria->id}}" name="id">
                            <div class="row">
                                <div class="col-2">
                                    <label>Nombre*</label>
                                    <input type="text" name="nombre" value="{{$categoria->nombre}}" class="form-control"
                                           required>
                                </div>
                                @foreach($campos as $c)
                                    @foreach($c as $v)
                                        @if($v!="nombre" && $v!="id" && $v!="created_at" && $v!="updated_at")
                                            <div class="col-2">
                                                <label>{{$v}}</label>
                                                <input type="text" name="{{$v}}" value="{{$categoria->$v}}"
                                                       class="form-control">
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
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
