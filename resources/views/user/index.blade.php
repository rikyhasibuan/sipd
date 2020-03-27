@extends('layouts.app')
@section('content')
    <div id="app">
        <user-index
            :level_data='{!! json_encode($level) !!}'
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'
            :access='{!! json_encode($access) !!}'>
        </user-index>
    </div>
@stop