@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">Editar fabricante</div>
                    <form method="post" action="/admin/update/fabricante" id="formUpdate">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" value="{{$fabricante->id}}" name="id">
                            <label>Razon social</label>
                            <input type="text" name="razon_social" value="{{$fabricante->razon_social}}"
                                   class="form-control">
                            <label>Origen</label>
                            <input type="text" name="origen" value="{{$fabricante->origen}}" class="form-control">
                            <label>Descripción</label>
                            <input type="text" name="descripcion" value="{{$fabricante->descripcion}}"
                                   class="form-control">
                        </div>
                    </form>
                    <button class="btn btn-outline-primary" onclick="actualizar()">Actualizar</button>
                    <button class="btn btn-outline-secondary" onclick="borrar()">Borrar</button>
                </div>
            </div>
        </div>
    </div>
    <form method="post" action="/admin/delete/fabricante" id="formularioBorrar">
        @csrf
        <input type="hidden" value="{{$fabricante->id}}" name="idFabricante">
    </form>
    <script type="application/javascript">
        function borrar() {
            if (confirm("¿Estas seguro que desea borrar el fabricante?")) {
                document.getElementById("formularioBorrar").submit();
            }
        }

        function actualizar() {
            document.getElementById("formUpdate").submit();
        }
    </script>
@endsection
