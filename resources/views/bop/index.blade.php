@extends('layouts.app')
@section('content')
    <div id="app">
        <bop-index
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'
            :access='{!! json_encode($access) !!}'>
        </bop-index>
    </div>
@stop