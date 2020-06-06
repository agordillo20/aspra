<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="height: 100%;margin-bottom: 0">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ASPRA') }}</title>
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/node-uuid/1.4.7/uuid.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/Functions.js') }}" defer></script>
    <script
        src="https://www.paypal.com/sdk/js?client-id=AbrAYFruSBuCSELV4fSTmSHHwnVNC96d2R2kr1arC4Ky_7BgLztxHPdncy96rWTgHVY7EwUZlywj0aan&currency=EUR"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/finalizarCompra.css') }}" rel="stylesheet">
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/popUp.css') }}" rel="stylesheet">
    <link href="{{ asset('css/perfil.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Filtros.css') }}" rel="stylesheet">
</head>
<body style="overflow-x: hidden">
<div id="app">
    <header class="navbar-header">
        <nav class="navbar navbar-expand navbar-light bg-primary fixed-top" style="z-index: 2">

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <i class="fas fa-bars btnIm" onclick="mostrar()" style="color: #f6993f"></i>
                    </li>
                    <li>
                        <a id="logo" class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{URL::asset('images/logo.png')}}" alt="no encontrada" class="img-fluid">
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
                        <i class="fas fa-shopping-cart" id="car"
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
                                @if(\Illuminate\Support\Facades\Auth::user()->foto !=null)
                                    <img src="{{\Illuminate\Support\Facades\Auth::user()->foto}}" alt="foto del usuario"
                                         style="width: 30px;height: 30px;border-radius: 20px">
                                @else
                                    <img src="{{URL::asset('images/defUser.png')}}" alt="foto por defecto">
                                @endif
                                <span
                                    class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/perfil">Perfil - {{Auth::user()->name}}</a>
                                <a class="dropdown-item" href="#"
                                   onclick="salir()">{{ __('Salir') }}</a>
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
                @foreach(\Illuminate\Support\Facades\DB::select('select categorias.id from categorias ') as $c)
                    @if(\Illuminate\Support\Facades\DB::table('productos')->join('categorias','categorias.id','=','productos.id_categoria')->where('categorias.id','=',$c->id)->where('activo','=',1)->count()>0){{--comprobacion necesaria para ocultar las categorias que no contengan productos--}}
                    <li>
                        <button class="btn text-left btn-link"
                                onclick="visualizarCatalogo({{$c->id}})">{{\App\Categoria::find($c->id)->nombre}}</button>
                    </li>
                    @endif
                @endforeach
            </ul>
        </nav>
        <div onclick="ocultar()">
            <div style="margin-top: 5em">
                @yield('content')
            </div>
        </div>
        <form method="post" action="/catalogo" id="formCatalogo">
            @csrf
            <input type="hidden" name="id" id="data">
        </form>
    </main>
</div>
<div class="carrito ocultar text-center" id="carrito">
{{--    establece la zona horaria, iniciar dos variables necesarias para el carrito y comprueba si la variable en sesion carrito esta
inicializada y si es asi la recupera en una variable, si no la inicializa y la guarda en una variable de sesion--}}
    @php
        date_default_timezone_set('Europe/Madrid');
        $i=0;
        $precio=0;
        @session_start();
        $carrito;
        if (isset($_SESSION['carrito'])){
            $carrito = $_SESSION['carrito'];
        }else{
            $_SESSION['carrito'] = array();
            $carrito = $_SESSION['carrito'];
        }
    @endphp
    <div class="compra" id="carritoCentro">@foreach($carrito as $c)<div class="row pt-3 px-3" id="column{{$i}}"><div class="col-1"><img src="{{$c[1]['foto']}}" style="width: 30px;height:30px"></div><div class="col-2" id="cantidad{{$i}}">x {{$c[0]}}</div><div class="col-5">{{$c[1]['nombre']}}</div><div class="col-1" id="precio{{$i}}">{{$c[1]['precio_venta']}}€</div>@php($precio+=$c[1]['precio_venta']*$c[0])<div class="col">@php($producto=json_encode($c[1]))<i id="{{$i}}" class="far fa-minus-square" onclick="quitar(this.id,{{$producto}})"></i></div><div hidden>{{$c[1]['cod_producto']}}</div>@php($i++)</div>@endforeach</div>
    <div class="row">
        <div class="col-7 text-right">
            <button class="btn btn-link" id="finish" disabled="disabled" onclick="location.href='{{route('comprar')}}'">
                Terminar compra
            </button>
        </div>
        <div class="col-4 my-2 text-left" id="precio">Total {{$precio}}€</div>
    </div>
</div>

<script type="application/javascript">
    var i = 0;

    function visualizarCatalogo(id) {
        $('#data').val(id);
        $('#formCatalogo').submit();
    }

    function salir() {
        $('#logout-form').submit();
    }

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

    function moveCarrito() {
        if (screen.width < 767) {
            if (i === 0) {
                $('#carrito').css("margin-top", "14em");
                i++;
            } else {
                $('#carrito').css("margin-top", "-1.3em");
                i--;
            }
        }
    }
</script>
</body>
</html>
