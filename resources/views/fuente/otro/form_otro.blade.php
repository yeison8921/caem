@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form-otro-component :datos="{ 
        accion: '{{ $accion }}',
        @if ($accion == 'Actualizar') 
        id_otro: {{ $id_otro }}
        @endif }">
    </form-otro-component>

</div>
@endsection