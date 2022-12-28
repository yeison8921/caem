@extends('layouts.app')

@section('content')
<div class="container">
    <form-emision-component :datos="{ 
        accion: '{{ $accion }}',
        tipo: '{{ $tipo }}', 
        @if ($accion == 'Actualizar') 
        id_emision: {{ $id_emision }}
        @endif }">
    </form-emision-component>

</div>
@endsection