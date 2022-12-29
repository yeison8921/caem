@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if ($accion == 'Crear')
    <form-convenio-component :datos="{ accion: 'Crear' }"></form-convenio-component>
    @else
    <form-convenio-component :datos="{ accion: 'Actualizar', id_convenio : {{ $id_convenio }} }"></form-convenio-component>
    @endif
</div>
@endsection