@extends('layouts.app')

@section('content')
    <div class="col-sm-auto" style="margin-top: 5em">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">REPONER PRODUCTO</div>
                    <div class="card-body bg-primary text-white">
                        <form method="POST" action="{{'/admin/reponer/producto'}}">
                            @csrf
                            <table class="table table-responsive-xl text-white font-weight-bold">
                                <tr>
                                    <td>
                                        <label for="producto">{{ __('Producto') }}</label>
                                    </td>
                                    <td>
                                        <select name="producto" class="custom-select">
                                            @foreach(\App\Producto::all()->where('activo','=','1') as $c)
                                                <option>{{$c->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="unidades">{{ __('Numero de unidades a reponer') }}</label>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" min="0" name="unidades">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Dirección pago/entrega</label>
                                    </td>
                                    <td>
                                        <select name="direccion" class="custom-select">
                                            @foreach(\App\Direccion::all()->where('id_usuario','=',\Illuminate\Support\Facades\Auth::id()) as $d)
                                                <option>{{$d->domicilio}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-6">
                                    <button id="btn-submit" type="submit" class="btn bg-dark text-white">
                                        {{ __('Reponer') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
