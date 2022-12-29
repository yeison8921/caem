@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form-empresa-component :datos="{ id_empresa : {{ $id_empresa }} }"></form-empresa-component>
</div>
@endsection