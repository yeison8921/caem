@extends('layouts.app')

@section('content')
<div class="container">
    <form-extintor-component :datos="{ 
        accion: '{{ $accion }}',
        @if ($accion == 'Actualizar') 
        id_extintor: {{ $id_extintor }}
        @endif }">
    </form-extintor-component>

</div>
@endsection