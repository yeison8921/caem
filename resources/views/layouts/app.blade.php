<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Caem') }}</title>

    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('meta')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @stack('before-styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('after-styles')
</head>

<body>
    <div id="app">
        @if (auth()->check())
        <side-nav :class="'fixed-start'" :routeSelected="'{{url()->current();}}'"
        :is-logged="{{auth()->check() ? 'true' : 'false'}}"
        ></side-nav>
        @endif
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" >
            <!-- nav -->
            @if (!auth()->check())
                <nav-bar-component 
                is-blur="blur blur-rounded my-3 py-2 start-0 end-0 mx-4 shadow"
                btn-background="bg-gradient-success"
                :dark-mode="true"
                :is-logged="{{auth()->check() ? 'true' : 'false'}}" >
                </nav-bar-component>
            @endif
                <div style="height: 73vh !important;">
                    @yield('content')

                </div>
            <!-- <app-footer /> -->
        </main>
    </div>
</body>

</html>