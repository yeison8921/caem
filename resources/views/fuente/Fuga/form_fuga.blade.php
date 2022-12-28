@extends('layouts.app')

@section('content')
<div class="container">
    <form-fuga-component :datos="{ 
        accion: '{{ $accion }}',
        @if ($accion == 'Actualizar') 
        id_fuga: {{ $id_fuga }}
        @endif }">
    </form-fuga-component>

</div>
@endsection