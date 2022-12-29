@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if ($accion == 'Crear')
    <form-parametro-component :datos="{ accion: 'Crear', tipo_parametro_id: {{ $tipo_parametro_id }} }"></form-parametro-component>
    @else
    <form-parametro-component :datos="{ accion: 'Actualizar', tipo_parametro_id: {{ $tipo_parametro_id }}, id_parametro: {{ $id_parametro }} }"></form-parametro-component>
    @endif
</div>
@endsection