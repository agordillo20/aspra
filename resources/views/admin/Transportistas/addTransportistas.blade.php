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
                                        <label for="precio">{{ __('Precio') }}</label>
                                    </td>
                                    <td>
                                        <input id="precio" type="number" min="0"
                                               class="form-control @error('precio') is-invalid @enderror"
                                               name="precio"
                                               required autocomplete="precio">
                                        @error('precio')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="duracion">{{ __('Duración máxima del envio') }}</label>
                                    </td>
                                    <td>
                                        <input id="duracion" type="number" min="0"
                                               class="form-control @error('duracion') is-invalid @enderror"
                                               name="duracion"
                                               required autocomplete="duracion">
                                        @error('duracion')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </td>
                                </tr>
                            </table>
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
