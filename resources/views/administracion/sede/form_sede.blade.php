@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if ($accion == 'Crear')
    <form-sede-component :datos="{ accion: 'Crear', empresa_id: {{ $empresa_id }} }"></form-sede-component>
    @else
    <form-sede-component :datos="{ accion: 'Actualizar', id_sede: {{ $id_sede }} }"></form-sede-component>
    @endif
</div>
@endsection