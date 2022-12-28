@extends('layouts.app')

@section('content')
<div class="container">
    <form-electricidad-component :datos="{ 
        accion: '{{ $accion }}',
        @if ($accion == 'Actualizar') 
        id_electricidad: {{ $id_electricidad }}
        @endif }">
    </form-electricidad-component>

</div>
@endsection