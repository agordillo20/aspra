@extends('layouts.app')

@section('content')
    <div class="col-sm-auto" style="margin-top: 5em">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">NUEVO TRANSPORTISTA</div>
                    <div class="card-body bg-primary text-white">
                        <form method="POST" action="/admin/add/Tranportistas1">
                            @csrf
                            <div class="form-group row">
                                <label for="razon_social"
                                       class="col-2 col-form-label text-md-right">{{ __('Razon social') }}</label>
                                <input id="razon_social" type="text"
                                       class="form-control col-2 @error('razon_social') is-invalid @enderror"
                                       name="razon_social"
                                       required autocomplete="razon_social">

                                @error('razon_social')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="precio"
                                       class="col-2 col-form-label text-md-right">{{ __('Precio') }}</label>
                                <input id="precio" type="number" min="0"
                                       class="form-control col-1 @error('precio') is-invalid @enderror"
                                       name="precio"
                                       required autocomplete="precio">
                                @error('precio')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="duracion"
                                       class="col-3 col-form-label text-md-right">{{ __('Duración máxima del envio') }}</label>
                                <input id="duracion" type="number" min="0"
                                       class="form-control col-1 @error('duracion') is-invalid @enderror"
                                       name="duracion"
                                       required autocomplete="duracion">
                                @error('duracion')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-secondary">Añadir</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
