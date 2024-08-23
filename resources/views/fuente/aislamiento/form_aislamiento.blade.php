@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form-aislamiento-component :datos="{ 
        accion: '{{ $accion }}',
        @if ($accion == 'Actualizar') 
        id_aislamiento: {{ $id_aislamiento }}
        @endif }">
    </form-aislamiento-component>

</div>
@endsection