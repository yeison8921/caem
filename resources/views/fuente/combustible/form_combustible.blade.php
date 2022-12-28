@extends('layouts.app')

@section('content')
<div class="container">
    <form-combustible-component :datos="{ 
        accion: '{{ $accion }}',
        tipo: '{{ $tipo }}', 
        @if ($accion == 'Actualizar') 
        id_combustible: {{ $id_combustible }}
        @endif }">
    </form-combustible-component>

</div>
@endsection