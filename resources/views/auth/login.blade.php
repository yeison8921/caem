@extends('layouts.app')

@section('content')
<div class="">
  
  <!-- <login-component></login-component> -->
  <main class="mt-0 main-content main-content-bg">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="mx-auto col-xl-5 col-lg-6 col-md-6 col-sm-10 d-flex flex-column">
              <div class="mt-8 card card-plain">
                <div class="pb-0 card-header text-start">
                  <h3 class="font-weight-bolder text-success text-gradient">
                    Bienvenido de nuevo
                  </h3>
                  <p class="mb-0"></p>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('login') }}">
                        @csrf
                                <label class="form-label">Correo electrónico</label>
                    <div class="form-group">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                    </div>
                    <label>Contraseña</label>
                    <div class="form-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                    </div>
                    <div class="text-center">
                      <soft-button-basic
                        class="my-4 mb-2"
                        variant="gradient"
                        color="success"
                        full-width
                        >Inicia sesión
                      </soft-button-basic>
                    </div>
                  </form>
                </div>
                <div class="px-1 pt-0 text-center card-footer px-lg-2">
                  <p class="mx-auto mb-4 text-sm">
                    ¿No tienes una cuenta?
                    <a
                      href="/register"
                      class="text-success text-gradient font-weight-bold"
                      >Registro</a
                    >
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div
                class="top-0 oblique position-absolute h-100 d-md-block d-none me-n8"
              >
                <div
                  class="bg-cover oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                  style="background-image:url('../images/Carbontest - bg.png'); background-position: center; margin-right: 200px;"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

</div>
@endsection