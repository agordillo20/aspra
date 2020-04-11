@extends('layouts.app')

@section('content')
    <div class="col-sm-auto" style="margin-top: 5em">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header w-auto text-center font-weight-bold bg-success">NUEVO FABRICANTE</div>
                    <div class="card-body bg-primary text-white">
                        <form method="POST" enctype="multipart/form-data" action="{{'/admin/add/fabricantes'}}">
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
                                <label for="origen"
                                       class="col-2 col-form-label text-md-right">{{ __('Origen') }}</label>
                                <input id="origen" type="text"
                                       class="form-control col-2 @error('origen') is-invalid @enderror"
                                       name="origen"
                                       required autocomplete="origen">

                                @error('origen')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="col text-center" style="margin-top: 4em">
                                    <button id="btn-submit" type="submit"
                                            class="btn bg-dark text-white">{{ __('Añadir') }}</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="descripcion"
                                       class="col-2 col-form-label text-md-right">{{ __('Descripcion') }}</label>
                                <input id="descripcion" type="text"
                                       class="form-control col-6 @error('descripcion') is-invalid @enderror"
                                       name="descripcion"
                                       required autocomplete="descripcion">

                                @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
