@extends('layouts.app')

@section('content')
<div class="container">
    <form-fermentacion-component :datos="{ 
        accion: '{{ $accion }}',
        @if ($accion == 'Actualizar') 
        id_fermentacion: {{ $id_fermentacion }}
        @endif }">
    </form-fermentacion-component>

</div>
@endsection