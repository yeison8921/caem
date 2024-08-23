@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form-refrigerante-component :datos="{ 
        accion: '{{ $accion }}',
        @if ($accion == 'Actualizar') 
        id_refrigerante: {{ $id_refrigerante }}
        @endif }">
    </form-refrigerante-component>

</div>
@endsection