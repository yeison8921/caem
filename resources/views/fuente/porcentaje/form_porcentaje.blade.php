@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form-porcentaje-component :datos="{ 
        accion: '{{ $accion }}',
        @if ($accion == 'Actualizar') 
        id_porcentaje: {{ $id_porcentaje }}
        @endif }">
    </form-porcentaje-component>

</div>
@endsection