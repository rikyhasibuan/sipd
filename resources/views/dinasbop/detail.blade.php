@extends('layouts.app')
@section('content')
    <div id="app">
        <dinasbop-detail 
            :dinasbop='{!! json_encode($dinasbop) !!}'
            :dinasboptim='{!! json_encode($dinasboptim) !!}'
            :route='{!! json_encode($route) !!}'
            :api='{!! json_encode($api) !!}'>
        </dinasbop-detail>
    </div>
@stop