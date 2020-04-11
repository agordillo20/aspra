<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="height: 100%">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ASPRA') }}</title>

    <!-- Scripts -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/popUp.css') }}" rel="stylesheet">
    <link href="{{ asset('css/perfil.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Filtros.css') }}" rel="stylesheet">
</head>
<body style="overflow-x: hidden">
<div id="app">
    <header class="navbar-header">
        <nav class="navbar navbar-expand-md navbar-light bg-primary fixed-top" style="z-index: 2">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <button class="btnIm" onclick="mostrar()"></button>
                    </li>
                    <li>
                        <a id="logo" class="navbar-brand text-white" href="{{ url('/') }}">
                            <img src="{{URL::asset('images/logo.png')}}" alt="no encontrada">
                        </a>
                    </li>
                </ul>
                @auth
                    @if(DB::select("select roles_id from roles_user where user_id=".Auth::id())[0]->roles_id==1)
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="/admin" class="btn btn-secondary">Administracion</a>
                            </li>
                        </ul>
                @endif
            @endauth
            <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item">
                        <i class="fas fa-shopping-cart"
                           style="font-size: 25px;padding-top: .4em;padding-right: .5em;cursor: pointer"
                           onclick="carrito()"></i>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="{{URL::asset('images/defUser.png')}}" alt="foto por defecto">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('login') }}">{{ __('Iniciar Sesion') }}</a>
                                @if (Route::has('register'))
                                    <a class=" dropdown-item" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                @endif
                            </div>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="{{URL::asset('images/defUser.png')}}" alt="foto por defecto"><span
                                    class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/perfil">Perfil - {{Auth::user()->name}}</a>
                                <a class="dropdown-item" href="#"
                                   onclick="
                                event.preventDefault();
                                document.getElementById('logout-form').submit();
                                ">{{ __('Salir') }}</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </header>

    <main class="py-4">
        <nav class="nv" id="navbar">
            <ul class="menu">
                @foreach(\Illuminate\Support\Facades\DB::select('select DISTINCT categorias.* from categorias inner join productos ON categorias.id=productos.id_categoria') as $c)
                    <li><a href="/catalogo?id={{$c->id}}">{{$c->nombre}}</a></li>
                @endforeach
            </ul>
        </nav>
        <div onclick="ocultar()">
            <div style="margin-top: 5em">
                @yield('content')
            </div>
        </div>

    </main>
</div>
<div class="carrito text-center" id="carrito">
    <div class="compra">
        @php
            $precio=0;
                $i=0;
        @endphp
        @foreach(\App\Producto::all() as $p)
            <div class="row pt-3 px-3" id="column{{$i}}">
                <div class="col-1"><img src="{{$p->foto}}" style="width: 30px;height: 30px"></div>
                <div class="col-2">x 1</div>
                <div class="col-5">{{$p->nombre}}</div>
                <div class="col-1" id="precio{{$i}}">{{$p->precio_venta}}€</div>
                @php($precio+=$p->precio_venta)
                <div class="col"><i id="{{$i}}" class="far fa-minus-square" onclick="quitar(this.id)"></i></div>
                @php($i++)
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-7 text-right">
            <button class="btn btn-link" id="finish">Terminar compra</button>
        </div>
        <div class="col-4 my-2 text-left" id="precio">Total {{$precio}}€</div>
    </div>


</div>
<script type="application/javascript">
    function carrito() {
        $('#carrito').toggleClass('ocultar');
    }

    function mostrar() {
        var estado = document.getElementById('navbar');
        if (estado.className === 'nv') {
            estado.className = 'mostrar';
            return true;
        } else {
            estado.className = 'nv';
            return false;
        }
    }

    function ocultar() {
        if (mostrar()) {
            var estado = document.getElementById('navbar');
            estado.className = 'nv';
        }
    }

    function quitar(id) {
        var precio = parseInt($('#precio' + id).text().slice(0, -1), 10);
        var total = parseInt($('#precio').text().split(' ')[1].slice(0, -1), 10);
        var nuevoTotal = total - precio;
        if (nuevoTotal === 0) {
            $('#finish').attr('disabled', true);
        }
        $('#precio').text("Total " + nuevoTotal + "€");
        $('#column' + id).remove();
        //eliminar del carrito
    }
</script>
</body>
</html>
