@extends('layouts.app')

@section('content')
<div class="container">
    <form-fertilizante-component :datos="{ 
        accion: '{{ $accion }}',
        tipo: '{{ $tipo }}', 
        @if ($accion == 'Actualizar') 
        id_fertilizante: {{ $id_fertilizante }}
        @endif }">
    </form-fertilizante-component>

</div>
@endsection