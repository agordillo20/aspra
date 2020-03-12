@extends('layouts.app')
@section('content')
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
            var add = document.createElement("a");
            add.setAttribute("href", "admin/add/" + nombre);
            add.appendChild(document.createTextNode("Añadir " + nombre));
            //mostrar
            var show = document.createElement("a");
            show.setAttribute("href", "admin/list/" + nombre);
            show.appendChild(document.createTextNode("Ver " + nombre));
            //modificar
            var modify = document.createElement("a");
            modify.setAttribute("href", "admin/update/" + nombre);
            modify.appendChild(document.createTextNode("Actualizar " + nombre));
            //borrar
            var del = document.createElement("a");
            del.setAttribute("href", "admin/delete/" + nombre);
            del.appendChild(document.createTextNode("Borrar " + nombre));
            //añadir a los elementos padres
            var secundario = document.createElement("div");
            secundario.id = "apoyo";
            secundario.append(add, show, modify, del);
            principal.append(secundario);
        }

    </script>
@endsection
