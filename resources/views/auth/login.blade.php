@extends('layouts.app')

@section('content')
<div class="container">
    <!-- <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">

                <div class="card-body">
                    <div class="text-center mb-5">
                        <h4>PLATAFORMA DE CÁLCULO DE HUELLA DE CARBONO</h4>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Correo electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend"><i class="fa-solid fa-envelope"></i></span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroupPrepend"><i class="fa-solid fa-lock"></i></span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ __('Ingresar') }}
                                </button>
                            </div>

                            @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Olvidé mi contraseña') }}
                            </a>
                            @endif
                        </div>

                        <div class="row mt-3 text-center">
                            <h5>¿No se ha registrado?</h5>
                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Registrese aquí</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->
    <login-component></login-component>
</div>
@endsection