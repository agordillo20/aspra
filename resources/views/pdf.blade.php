<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style type="text/css">
        @page {
            margin: 160px 50px;
        }

        header {
            position: fixed;
            left: 0;
            top: -100px;
            right: 0;
            height: 100px;
            margin-bottom: 3em;
        }

        footer {
            font-size: 12px;
            position: fixed;
            bottom: -11em;
            left: 0;
            right: 0;
        }
    </style>
    <title>Factura</title>
</head>
<body>
<header>
    <div class="row">
        <div class="col text-right"><img src="{{public_path().'/images/logo.png'}}"></div>
        <div class="col">Cliente</div>
        <div class="col-4 pt-4">
            <div class="border" style="height: 4.8em">
                <div class="row">
                    <div class="col pl-4">
                        {{Auth::user()->name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col pl-4">
                        {{$direccion->domicilio}}
                    </div>
                </div>
                <div class="row text-right pl-2">
                    <div class="col text-left">{{$direccion->cod_postal}}</div>
                    <div class="col-5">{{$direccion->localidad}}</div>
                    <div class="col-9">({{$direccion->provincia}})</div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="col-sm-auto">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card w-auto text-center">

            </div>
        </div>
        <div class="card-body">
            <div class="col text-left font-weight-bold">Factura Nº {{$cod_factura}}</div>
            <div class="row">
                @php
                    $total = 0;
                @endphp
                <table class="table table-active text-right">
                    <thead class="font-weight-bold">
                    <tr style="text-decoration: underline">
                        <td>Producto</td>
                        <td>Cantidad</td>
                        <td>Precio</td>
                        <td>IVA</td>
                        <td>Total</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($factura as $f)
                        <tr style="background-color: lightblue">
                            <td>{{\App\Producto::find($f->id_producto)->nombre}}</td>
                            <td>{{$f->cantidad}}</td>
                            <td>{{$f->precio}}</td>
                            <td>21%</td>
                            <td>{{number_format($f->precio*1.21*$f->cantidad,2)}}€</td>
                            {{$total+=$f->cantidad*($f->precio*1.21)}}
                        </tr>
                    @endforeach
                    @if($total<40)
                        <tr style="background-color: lightblue">
                            <td colspan="4">Plus de transporte</td>
                            <td>{{number_format($transportista->precio,2)}}€</td>
                            {{$total+=$transportista->precio}}
                        </tr>
                    @endif
                    <tr>
                        <td colspan="4" class="font-weight-bold">Importe</td>
                        <td>{{number_format($total,2)}}€</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<footer>
    <pre>Dirección:Calle falsa, 123    Tlf:666666666     Correo de contacto:adriangordillo91@gmail.com   CIF:B89567125</pre>
</footer>
</body>
</html>
