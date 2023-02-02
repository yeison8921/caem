@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form-producto-component :datos="{ 
        accion: '{{ $accion }}',
        tipo: '{{ $tipo }}', 
        @if ($accion == 'Actualizar') 
        id_producto: {{ $id_producto }}
        @endif }">
    </form-producto-component>

</div>
@endsection