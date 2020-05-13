@extends('layouts.app')
@section('content')
    <div id="app">
        <profile user='{!! json_encode($user) !!}' :api='{!! json_encode($api) !!}'></profile>
    </div>
@stop
