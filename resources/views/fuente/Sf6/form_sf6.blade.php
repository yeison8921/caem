@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form-sf6-component :datos="{ 
        accion: '{{ $accion }}',
        @if ($accion == 'Actualizar') 
        id_sf6: {{ $id_sf6 }}
        @endif }">
    </form-sf6-component>

</div>
@endsection