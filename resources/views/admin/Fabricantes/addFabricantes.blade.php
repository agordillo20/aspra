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
                            <table class="table table-responsive-xl text-white font-weight-bold">
                                <tr>
                                    <td>
                                        <label for="razon_social">{{ __('Razon social') }}</label>
                                    </td>
                                    <td>
                                        <input id="razon_social" type="text"
                                               class="form-control @error('razon_social') is-invalid @enderror"
                                               name="razon_social"
                                               required autocomplete="razon_social">

                                        @error('razon_social')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="origen">{{ __('Origen') }}</label>
                                    </td>
                                    <td>
                                        <input id="origen" type="text"
                                               class="form-control @error('origen') is-invalid @enderror"
                                               name="origen"
                                               required autocomplete="origen">

                                        @error('origen')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="descripcion">{{ __('Descripcion') }}</label>
                                    </td>
                                    <td>
                                        <input id="descripcion" type="text"
                                               class="form-control @error('descripcion') is-invalid @enderror"
                                               name="descripcion"
                                               required autocomplete="descripcion">

                                        @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="correo">{{ __('Correo electrónico') }}</label>
                                    </td>
                                    <td>
                                        <input id="correo" type="email"
                                               class="form-control @error('correo') is-invalid @enderror"
                                               name="correo"
                                               required autocomplete="correo">

                                        @error('correo')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </td>
                                </tr>
                            </table>
                            <div class="form-group row">
                                <div class="col text-center">
                                    <button id="btn-submit" type="submit"
                                            class="btn bg-dark text-white">{{ __('Añadir') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
