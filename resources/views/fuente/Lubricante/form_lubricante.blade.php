@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form-lubricante-component :datos="{ 
        accion: '{{ $accion }}',
        @if ($accion == 'Actualizar') 
        id_lubricante: {{ $id_lubricante }}
        @endif }">
    </form-lubricante-component>

</div>
@endsection