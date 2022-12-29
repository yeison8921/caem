@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form-trasversal-component :datos="{ 
        accion: '{{ $accion }}',
        @if ($accion == 'Actualizar') 
        id_trasversal: {{ $id_trasversal }}
        @endif }">
    </form-trasversal-component>

</div>
@endsection