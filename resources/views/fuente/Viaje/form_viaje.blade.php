@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form-viaje-component :datos="{ 
        accion: '{{ $accion }}',
        @if ($accion == 'Actualizar') 
        id_viaje: {{ $id_viaje }}
        @endif }">
    </form-viaje-component>

</div>
@endsection