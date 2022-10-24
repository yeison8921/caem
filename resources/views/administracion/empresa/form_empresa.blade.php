@extends('layouts.app')

@section('content')
<div class="container">
    <form-empresa-component :datos="{ id_empresa : {{ $id_empresa }} }" ></form-empresa-component>
</div>
@endsection