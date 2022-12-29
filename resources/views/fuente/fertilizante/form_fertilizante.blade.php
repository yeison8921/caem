@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form-fertilizante-component :datos="{ 
        accion: '{{ $accion }}',
        tipo: '{{ $tipo }}', 
        @if ($accion == 'Actualizar') 
        id_fertilizante: {{ $id_fertilizante }}
        @endif }">
    </form-fertilizante-component>

</div>
@endsection