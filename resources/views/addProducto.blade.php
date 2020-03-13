@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">NUEVO PRODUCTO</div>
                    <div class="card-body bg-primary text-white">
                        <form method="POST" enctype="multipart/form-data" action="{{'/admin/add/producto'}}">
                            @csrf
                            <div class="form-group row">
                                <label for="Categoria"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }}</label>
                                <div class="col-md-2">
                                    <select name="categoria">
                                        @foreach(\App\Categoria::all() as $c)
                                            <option>{{$c->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="Categoria"
                                       class="col-md-2 col-form-label text-md-right">{{ __('Fabricante') }}</label>
                                <div class="col-md-1">
                                    <select name="fabricante">
                                        @foreach(\App\Fabricante::all() as $f)
                                            <option>{{$f->razon_social}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="precio_compra"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Precio compra') }}</label>
                                <div class="col-md-2">
                                    <input id="precio_compra" type="number"
                                           class="form-control @error('precio_compra') is-invalid @enderror"
                                           name="precio_compra"
                                           required autocomplete="precio_compra">

                                    @error('precio_compra')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <label for="precio_venta"
                                       class="col-md-2 col-form-label text-md-right">{{ __('Precio venta') }}</label>
                                <div class="col-md-2">
                                    <input id="precio_venta" type="number"
                                           class="form-control @error('precio_venta') is-invalid @enderror"
                                           name="precio_venta"
                                           required autocomplete="precio_venta">

                                    @error('precio_venta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stock_minimo"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Stock minimo') }}</label>
                                <div class="col-md-2">
                                    <input id="stock_minimo" type="number"
                                           class="form-control @error('stock_minimo') is-invalid @enderror"
                                           name="stock_minimo"
                                           required autocomplete="stock_minimo">

                                    @error('stock_minimo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <label for="stock_actual"
                                       class="col-md-2 col-form-label text-md-right">{{ __('Stock actual') }}</label>
                                <div class="col-md-2">
                                    <input id="stock_actual" type="number"
                                           class="form-control @error('stock_actual') is-invalid @enderror"
                                           name="stock_actual"
                                           required autocomplete="stock_actual">

                                    @error('stock_actual')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="descripcion"
                                       class="col-2 col-form-label text-md-left">{{ __('Descripcion') }}</label>
                                <div class="col-md-12">
                                    <input id="descripcion" type="text"
                                           class="form-control descripcion @error('descripcion') is-invalid @enderror"
                                           name="descripcion"
                                           required autocomplete="descripcion"
                                           placeholder="nombre,bateria,pantalla,procesador,ram,almacenamiento interno">

                                    @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="foto" class="col-md-2 col-form-label text-md-left">{{ __('Foto') }}</label>
                                <div class="col-md-12">
                                    <input id="foto" type="file"
                                           class="form-control @error('foto') is-invalid @enderror" name="foto"
                                           required autocomplete="foto">

                                    @error('foto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-6">
                                    <button type="submit" class="btn bg-dark text-white">
                                        {{ __('Añadir') }}
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
