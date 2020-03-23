@extends('layouts.app')
@section('content')
    <div id="app">
        <program-index
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'
            :access='{!! json_encode($access) !!}'>
        </program-index>
    </div>
@stop