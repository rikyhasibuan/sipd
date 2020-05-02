@extends('layouts.app')
@section('content')
    <div id="app">
        <irban-index
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'
            :access='{!! json_encode($access) !!}'>
        </irban-index>
    </div>
@stop