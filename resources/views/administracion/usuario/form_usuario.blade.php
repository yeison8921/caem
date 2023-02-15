@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if ($accion == 'Crear')
    <form-usuario-component :datos="{ accion: 'Crear' }"></form-usuario-component>
    @else
    <form-usuario-component :datos="{ accion: 'Actualizar', id_usuario: {{ $id_usuario }} }"></form-usuario-component>
    @endif
</div>
@endsection