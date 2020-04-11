@extends('layouts.app')

@section('content')
    <div class="col-sm-auto" style="margin-top: 5em">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">NUEVA CATEGORIA</div>
                    <div class="card-body bg-primary text-white">
                        <form method="POST" enctype="multipart/form-data" action="{{'/admin/add/categoria'}}">
                            @csrf
                            <div class="form-group row">
                                <label for="nombre"
                                       class="col-2 col-form-label text-md-right">{{ __('Nombre') }}</label>
                                <input id="nombre" type="text"
                                       class="form-control col-2 @error('nombre') is-invalid @enderror"
                                       name="nombre"
                                       required autocomplete="nombre">

                                @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="campos"
                                       class="col-3 col-form-label text-md-right">{{ __('¿Cuántos campos desea?') }}</label>
                                <input id="campos" type="number" min="0" max="18"
                                       class="form-control col-1 @error('origen') is-invalid @enderror"
                                       name="campos"
                                       required autocomplete="campos">

                                @error('campos')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="col text-center">
                                    <button type="button" class="btn btn-secondary" onclick="add()" id="btnAdd">Añadir
                                    </button>
                                </div>
                            </div>
                            <div class="col" id="pp">
                                <div id="borrar">

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        function add() {
            var cantidad = $('#campos').val();
            if (cantidad === "") {
                cantidad = 0;
            }
            console.log(cantidad);
            if (cantidad > 0 && cantidad <= 18) {
                render(cantidad);
            }
        }

        function render(cantidad) {
            var borrar = document.getElementById("borrar");
            borrar.remove();
            var principal = document.getElementById("pp");
            var del = document.createElement("div");
            del.id = "borrar";
            principal.appendChild(del);
            var row;
            for (let i = 0; i < cantidad; i++) {
                if (i === 0 || i % 3 === 0) {
                    row = document.createElement("div");
                    row.className = "row text-center my-2";
                    del.appendChild(row);
                }
                var item = document.createElement("div");
                item.className = "col";
                var input = document.createElement("input");
                input.className = "form-control";
                input.type = "text";
                input.name = "descripcion" + (i + 1);
                input.id = "input" + i;
                item.appendChild(input);
                row.appendChild(item);
            }
            var bt = document.createElement("button");
            bt.type = "submit";

            bt.className = "btn btn-secondary";
            bt.appendChild(document.createTextNode("Añadir categoria"));
            var div = document.createElement("div");
            div.className = "row";
            var div1 = document.createElement("div");
            div1.className = "col text-center";
            div1.appendChild(bt);
            div.appendChild(div1);
            del.appendChild(div);
        }
    </script>
@endsection
