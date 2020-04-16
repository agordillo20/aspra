@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">Editar Transportista</div>
                    <form method="post" action="/admin/update/Transportistas" id="formUpdate">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" value="{{$transportista->id}}" name="id">
                            <div class="row">
                                <div class="col-2">
                                    <label>Razon social</label>
                                    <input type="text" name="razon_social" value="{{$transportista->razon_social}}"
                                           class="form-control"
                                           required>
                                </div>
                                <div class="col-2">
                                    <label>Precio</label>
                                    <input type="number" name="precio" value="{{$transportista->precio}}"
                                           class="form-control"
                                           required>
                                </div>
                                <div class="col-2">
                                    <label>Duración maxima</label>
                                    <input type="number" name="duracion" value="{{$transportista->duracion}}"
                                           class="form-control"
                                           required>
                                </div>
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-outline-primary" onclick="actualizar()">Actualizar</button>
                    <button class="btn btn-outline-secondary" onclick="borrar()">Borrar</button>
                </div>
            </div>
        </div>
    </div>
    <form method="post" action="/admin/delete/Transportistas" id="formularioBorrar">
        @csrf
        <input type="hidden" value="{{$transportista->id}}" name="idTransportista">
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
