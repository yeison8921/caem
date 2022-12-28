@extends('layouts.app')

@section('content')
<div class="container">
    <form-estiercol-component :datos="{ 
        accion: '{{ $accion }}',
        tipo: '{{ $tipo }}', 
        @if ($accion == 'Actualizar') 
        id_estiercol: {{ $id_estiercol }}
        @endif }">
    </form-estiercol-component>

</div>
@endsection