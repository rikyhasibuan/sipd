@extends('layouts.app')
@section('content')
    <div id="app">
        <bbm-index
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'
            :access='{!! json_encode($access) !!}'>
        </bbm-index>
    </div>
@stop
