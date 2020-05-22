@extends('layouts.app')
@section('content')
    @if (session('message'))
        <div class="alert alert-success text-center" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <div class="admin">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                        <button id="1" class="nav-link btn-outline-primary font-weight-bold"
                                onclick="opciones(this.id)">Productos
                        </button>
                    </li>
                    <li class="nav-item">
                        <button id="2" class="nav-link btn-outline-primary font-weight-bold"
                                onclick="opciones(this.id)">Fabricantes
                        </button>
                    </li>
                    <li class="nav-item">
                        <button id="3" class="nav-link btn-outline-primary font-weight-bold"
                                onclick="opciones(this.id)">Categorias
                        </button>
                    </li>
                    <li class="nav-item">
                        <button id="4" class="nav-link btn-outline-primary font-weight-bold"
                                onclick="opciones(this.id)">Transportistas
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body" id="contenedor">
                <div id="apoyo">

                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        window.addEventListener("load", function () {
            opciones(1);
        });

        function opciones(id) {
            //Obtener el nombre del boton presionado
            var nombre = document.getElementById(id).innerText;
            //crear dinamicamente el contenido del contenedor
            var principal = document.getElementById("contenedor");
            var sec = document.getElementById("apoyo");
            //limpiar el contenido anterior
            sec.remove();
            //añadir
            if (nombre === "Productos") {
                var reponer = document.createElement("a");
                reponer.setAttribute("href", "admin/reponer/" + nombre);
                reponer.appendChild(document.createTextNode("reponer " + nombre));
                var ofertar = document.createElement("a");
                ofertar.setAttribute("href", "admin/ofertar/" + nombre);
                ofertar.appendChild(document.createTextNode("ofertar " + nombre));
            }
            var add = document.createElement("a");
            add.setAttribute("href", "admin/add/" + nombre);
            add.appendChild(document.createTextNode("Añadir " + nombre));
            //mostrar
            var show = document.createElement("a");
            show.setAttribute("href", "admin/list/" + nombre);
            show.appendChild(document.createTextNode("Listado de " + nombre));
            //añadir a los elementos padres
            var secundario = document.createElement("div");
            secundario.id = "apoyo";
            if (ofertar !== undefined && reponer !== undefined) {
                secundario.append(add, show, ofertar, reponer);
            } else {
                secundario.append(add, show);
            }
            principal.append(secundario);
        }
    </script>
@endsection
