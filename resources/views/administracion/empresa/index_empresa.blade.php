@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <index-empresa-component :user-logged="{{auth()->user() ? auth()->user() : '{}'}}"></index-empresa-component>
</div>
@endsection